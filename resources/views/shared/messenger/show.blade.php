@extends('shared.messenger.index')

@section('title', "$thread - Eduplatform.pl")

@section('messenger_content')
    <div>
        <h2 class="subtitle">
            @if ($thread->name)
                {{ $thread->name }}
            @else
                {{$name}}
            @endif
        </h2>
        <div>
            @if($thread->threadUsers->count() > 4)
                <span>Uczestnicy: </span>
                @foreach($thread->threadUsers as $user)
                    <span class="badge bg-primary">{{ $user }}</span>
                @endforeach
            @endif
        </div>
    </div>

    <div id="message_box" class="invisible" style="flex: 1 0 0; overflow-y: auto;">
        <div class="d-flex flex-column justify-content-end" style="min-height: 100%;">
            @foreach($thread->messages as $message)
                @if($message->user->id === Auth::user()->id)
                    <div class="align-self-end" style="max-width: 400px;">
                        <small>ja</small>
                        @if(!empty($message->content))
                            <div class="alert p-2 mb-0 alert-secondary">{{$message->content}}</div>
                        @endif

                        @forelse($message->files as $file)
                            <div class="alert p-2 mb-0 alert-secondary">
                                <a class='link-light' href="{{route('file.show', [$file, $file->filename])}}" target="_blank">{{$file}}</a>
                            </div>
                        @empty
                        @endforelse
                        <small class="">{{$message->updated_at}}</small>
                    </div>
                @else
                    <div class="align-self-start" style="max-width: 400px;">
                        <small>{{$message->user}}</small>
                        @if(!empty($message->content))
                            <div class="alert p-2 mb-0 alert-primary">{{$message->content}}</div>
                        @endif

                        @forelse($message->files as $file)
                            <div class="alert p-2 mb-0 alert-primary">
                                <a class='link-light' href="{{route('file.show', [$file, $file->filename])}}" target="_blank">{{$file}}</a>
                            </div>
                        @empty
                        @endforelse
                        <small>{{$message->updated_at}}</small>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div>
        <form action="{{route('messenger.send_message', $thread)}}" enctype="multipart/form-data" method="POST"
              class="d-flex">
            @csrf
            <div class="input-group mt-3 mb-3">
                <input type="text" class="form-control" id="content" name="content">
                <input type="file" class="form-control" id="files" name="files[]" style="max-width: 300px" multiple>
                <button type="submit" class="btn btn-outline-dark"><i class="far fa-paper-plane"></i></button>
            </div>
        </form>
    </div>

    <script>
        window.onload = function() {
            let element = document.getElementById('message_box');
            element.scrollTo(0,element.scrollHeight);
            element.classList.remove('invisible');
        }
    </script>
@endsection
