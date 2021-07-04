<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use App\Service\FileService;
use Exception;
use Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index()
    {
        return view('shared.messenger.index', [
            'threads' => Thread::getOwnThreads(),
        ]);
    }

    public function create()
    {
        return view('shared.messenger.create', [
            'users' => User::orderBy('last_name')->orderBy('first_name')->get(),
            'threads' => Thread::getOwnThreads(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'users' => 'required|array',
            'content' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $thread = Thread::create(['name' => $validatedData['name']]);
            $thread->threadUsers()->attach(
                User::find(array_merge(Auth::user()->id, $validatedData['users'])),
            );

            /** @var Message $message */
            $message = $thread->messages()->create([
                'user_id' => Auth::user()->id,
                'content' => $validatedData['content'],
            ]);
            $this->fileService->handleRequestMessageFiles($request, $message);

            DB::commit();
            return redirect()->route('messenger.show', $thread);
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return redirect()->back()
                ->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Thread $thread)
    {
        if (!Gate::allows('access_thread', $thread)) {
            return redirect()->route('messenger.index')
                ->with('error', 'Nie należysz do tej konwersacji.');
        }

        return view('shared.messenger.show', [
            'thread' => $thread,
            'threads' => Thread::getOwnThreads(),
            'name' => Thread::getDynamicThreadName($thread),
        ]);
    }

    public function sendMessage(Request $request, Thread $thread): RedirectResponse
    {
        if (!Gate::allows('access_thread', $thread)) {
            return redirect()->route('messenger.index')
                ->with('error', 'Nie należysz do tej konwersacji.');
        }

        $validatedData = $request->validate([
            'content' => 'required_without:files|nullable|string',
        ]);

        DB::beginTransaction();

        try {
            /** @var Message $message */
            $message = $thread->messages()->create([
                'user_id' => Auth::user()->id,
                'content' => $validatedData['content'],
            ]);
            $this->fileService->handleRequestMessageFiles($request, $message);

            DB::commit();
            return redirect()->route('messenger.show', $thread);
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return redirect()->back()
                ->with('error', $e->getMessage())->withInput();
        }
    }

}
