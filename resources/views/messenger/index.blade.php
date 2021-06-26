@extends('teacher.layout')

@section('title', "Wiadomości - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Wiadomości</h1>
        <a class="button is-normal ml-5"
           href="{{route('messenger.create')}}"/>

            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Nowa wiadomość</span>
            </span>
        </a>
    </div>

   <div class="is-flex">
       <div>
           @foreach($threads as $thread)
               <p><a href="{{route('messenger.show', $thread->id)}}">{{$thread->name}}</a></p>
           @endforeach
       </div>
       <div>
            @yield('messenger_content')
       </div>
   </div>



@endsection
