@extends('layout')
@section('title', "$group - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">{{ $group }}</h1>

    <section class="section">
        <h5 class="subtitle-sm">Ogłoszenia</h5>
        <div class="accordion" id="accordionAnnouncements">
            @forelse($announcements as $announcement)
                <div class="accordion-item ">
                    <h2 class="accordion-header" id="heading-{{$announcement->id}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{$announcement->id}}">
                            {{ $announcement->title }} ({{ $announcement->type->description }})
                            ważność {{ $announcement->mark_at }}
                        </button>
                    </h2>
                    <div id="collapse-{{$announcement->id}}" class="accordion-collapse collapse"
                         data-bs-parent="#accordionAnnouncements">
                        <div class="accordion-body">
                            {!! $announcement->description !!}
                        </div>
                    </div>
                </div>
            @empty
                <p>Brak ogłoszeń.</p>
            @endforelse
        </div>

    </section>

    <section class="section">
        <h5 class="subtitle-sm">Sekcje</h5>
        <div class="accordion" id="accordionSections">
            @forelse($sections as $section)
                <div class="accordion-item ">
                    <h2 class="accordion-header" id="heading-s-{{$section->id}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-s-{{$section->id}}" aria-expanded="false"
                                aria-controls="collapse-s-{{$section->id}}">
                            {{ $section->name }} @if($section->lesson)({{ $section->lesson->name }} - {{$section->lesson->scheduledLesson->date}}) @endif
                        </button>
                    </h2>
                    <div id="collapse-s-{{$section->id}}" class="accordion-collapse collapse"
                         aria-labelledby="headingOne" data-bs-parent="#accordionSections">
                        <div class="accordion-body">
                            <div>{!! $section->description !!}</div>

                            <div class="card">
                                <div class="card-header">
                                    Pliki
                                </div>
                                <ul class="list-group list-group-flush">
                                    @forelse($section->files as $sectionFile)
                                        <li class="list-group-item">
                                            <a href="{{route('file.show', [$sectionFile, $sectionFile->filename])}}">{{$sectionFile}}</a>
                                        </li>
                                    @empty
                                        <p>Brak plików.</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Brak ogłoszeń.</p>
            @endforelse
        </div>

    </section>

@endsection
