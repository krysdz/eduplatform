<?php

namespace App\Http\Controllers\Messenger;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Thread;
use App\Models\ThreadUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    public function index()
    {
        return view('messenger.index', [
            'threads' => $this->getThreads()
        ]);
    }

    public function create()
    {
        return view('messenger.create', [
            'users' => User::orderBy('last_name')->orderBy('first_name')->get(),
            'threads' => $this->getThreads()
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

            if(empty($validatedData['name'])) {
                $validatedData['name'] = User::find($validatedData['users'][0]). " + ". (count($validatedData['users']) - 1). " użytkowników";
            }

            $validatedData['users'][] = $userId;

            $thread = Thread::create(['name' => $validatedData['name']]);
            $thread->threadUsers()->attach(User::find($validatedData['users']));

            Message::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
                'content' => $validatedData['content']
            ]);

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
        return view('messenger.show', [
            'thread' => $thread,
            'threads' => $this->getThreads()
        ]);
    }

    public function update(Request $request, Thread $thread)
    {
        $validatedData = $request->validate([
            'content' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::user()->id;

            Message::create([
                'thread_id' => $thread->id,
                'user_id' => $userId,
                'content' => $validatedData['content']
            ]);

            DB::commit();

            return redirect()->route('messenger.show', $thread);
        } catch (Exception $e) {
            report($e);

            DB::rollback();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function getThreads()
    {
        return Thread::whereHas('threadUsers', function ($q) {
            $q->where('user_id', '=', Auth::user()->id);
        })->orderByDesc('updated_at')->get();
    }

}
