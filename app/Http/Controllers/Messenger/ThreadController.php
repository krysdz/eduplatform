<?php

namespace App\Http\Controllers\Messenger;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Message;
use App\Models\SectionFile;
use App\Models\Thread;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    public function index()
    {
        return view('shared.messenger.index', [
            'threads' => Thread::getOwnThreads()
        ]);
    }

    public function create()
    {
        return view('shared.messenger.create', [
            'users' => User::orderBy('last_name')->orderBy('first_name')->get(),
            'threads' => Thread::getOwnThreads()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'users' => 'required|array',
            'content' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::user()->id;

            $validatedData['users'][] = $userId;

            $thread = Thread::create(['name' => $validatedData['name']]);
            $thread->threadUsers()->attach(User::find($validatedData['users']));

            $message = Message::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
                'content' => $validatedData['content']
            ]);

            if ($request->hasFile('message_files')) {
                $validatedFiles = $request->validate([
                    'message_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['message_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();

                    $message->files()->create([
                        'filename' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' =>  $sectionFile->storeAs('files/thread_' . $thread->id . '/message_' . $message->id, $filename, 'local'),
                        'mimetype' => $sectionFile->getClientMimeType(),
                        'size' => $sectionFile->getSize(),
                        'user_id' => $request->user()->id,
                        'title' => $filename,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('messenger.show', $thread);
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Thread $thread)
    {
        if (!$thread->threadUsers->contains(auth()->user())) {
            return redirect()->route('messenger.index')
                ->with('error', 'Nie należysz do tej konwersacji.');
        }

        return view('shared.messenger.show', [
            'thread' => $thread,
            'threads' => Thread::getOwnThreads(),
            'name' => Thread::getDynamicThreadName($thread)
        ]);
    }

    public function update(Request $request, Thread $thread)
    {
        if (!$thread->threadUsers->contains(auth()->user())) {
            return redirect()->route('messenger.index')
                ->with('error', 'Nie należysz do tej konwersacji.');
        }

        $validatedData = $request->validate([
            'content' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::user()->id;

            $message = Message::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
                'content' => $validatedData['content']
            ]);

            if ($request->hasFile('message_files')) {
                $validatedFiles = $request->validate([
                    'message_files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
                ]);

                foreach ($validatedFiles['message_files'] as $sectionFile) {
                    $filename = $sectionFile->getClientOriginalName();

                    $message->files()->create([
                        'filename' => $filename,
                        'extension' => $sectionFile->getClientOriginalExtension(),
                        'path' =>  $sectionFile->storeAs('files/thread_' . $thread->id . '/message_' . $message->id, $filename, 'local'),
                        'mimetype' => $sectionFile->getClientMimeType(),
                        'size' => $sectionFile->getSize(),
                        'user_id' => $request->user()->id,
                        'title' => $filename,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('messenger.show', $thread);
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

}
