@extends('messenger.index')

@section('title', "$thread - Eduplatform.pl")

@section('messenger_content')
    @foreach($thread->messages as $message)
        <div class="notification @if($message->user->id === Auth::user()->id)is-primary @endif">
            <p>{{$message->user}}</p>
            <p>{{$message->content}}</p>
            <p>{{$message->updated_at}}</p>
        </div>
    @endforeach

    <form action="{{route('messenger.update', $thread)}}" method="POST">
        @csrf
        <input type="text" id="content" class="content" name="content">
        <button type="submit"><i class="far fa-paper-plane"></i></button>
    </form>
@endsection
