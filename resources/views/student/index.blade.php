@extends('student.layout')

@section('content')
    <div>
        <h2 class="title is-2">Sekcja studenta</h2>
        @if($notifications)
            @foreach($notifications as $notification)
                @php
                    $gradeItem = \App\Models\GradeItem::find($notification->data['gradeItem'])
                @endphp
                <article class="message is-dark">
                    <div class="message-header">
                        <p>Nowa ocena z przedmiotu {{$gradeItem->group->course->name}}</p>
                        <button class="delete" aria-label="delete"></button>
                    </div>
                    <div class="message-body">
                        <p>Nazwa: {{$gradeItem->name}}</p>
                        <p>Ocena: {{$notification->data['grade']}}</p>
                        <p>Nauczyciel: {{$gradeItem->group->teacher->user->getFullNameAttribute()}}</p>
                        <p>Data: {{$notification->created_at}}</p>
                    </div>
                </article>
            @endforeach
        @else
            <h1>Brak powiadomień</h1>
        @endif
    </div>
@endsection
