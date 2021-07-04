@extends('layout')

@section('title', "Wiadomości - Eduplatform.pl")
@section('body_class')vh-100 overflow-hidden @endsection

@section('left_sidebar')
    <aside class="container-fluid d-flex flex-column w-auto mx-0 my-4 mh-100" style="width: 420px;">
        <h1 class="mb-4">Wiadomości</h1>

        <div class="card h-100 overflow-hidden">
            <div class="card-header">
                <a class="d-block text-dark text-decoration-none" href="{{ route('messenger.create') }}">
                    <span class="me-2"><i class="fas fa-plus"></i></span>
                    <span>Nowa rozmowa</span>
                </a>
            </div>
            <nav class="list-group list-group-flush" style="overflow-y: auto;">
                @forelse ($threads as $thread)
                    <a class="list-group-item list-group-item-action"
                       href="{{ route('messenger.show', $thread ) }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">@if ($thread->name)
                                    {{ $thread->name }}
                                @else
                                    {{ \App\Models\Thread::getDynamicThreadName($thread, 1) }}
                                @endif</h5>
                            <small class="text-muted">{{ $thread->messages->first()->created_at->diffForHumans()}}</small>
                        </div>
                        <p class="mb-0" style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;">
                            {{ $thread->messages->first()->user}}: {{ $thread->messages->first()->content }}
                        </p>
                    </a>
                @empty
                @endforelse
            </nav>
        </div>
    </aside>
@endsection

@section('fluid_content')
    <div class="flex-fill container-fluid d-flex flex-column my-4">
        @yield('messenger_content')
    </div>
@endsection
