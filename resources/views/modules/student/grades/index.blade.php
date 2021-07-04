@extends('layout')

@section('title', "Moje oceny - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Moje oceny</h1>

    <section class="section">
        <div class="accordion" id="accordionGrades">
            @forelse($studentGradesByGroups as $group => $gradesList)
            <div class="accordion-item ">
                <h2 class="accordion-header" id="heading-{{$group}}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$group}}" aria-expanded="false" aria-controls="collapse-{{$group}}">
                        {{ $groups->find($group) }}
                    </button>
                </h2>
                <div id="collapse-{{$group}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionGrades">
                    <div class="accordion-body">
                        <div class="mb-3">
                            @forelse($gradesList['items'] as $grade)
                                <span class="badge border fs-7" style="color: {{ $grade->gradeItem->color }}; border-color: {{ $grade->gradeItem->color }};" data-bs-toggle="tooltip"
                                      data-bs-placement="top" data-bs-html="true"
                                      title="<div><p class='mb-0'>Nazwa: {{$grade->gradeItem->name}}</p><p class='mb-0'>Waga: {{$grade->gradeItem->weight}}</p><p class='mb-0'>Max pkt.: {{$grade->gradeItem->maxscore}}</p><p class='mb-0'>Komentarz: {{$grade->comment}}</p><p class='mb-0'>Data: {{$grade->updated_at}}</p></div>">
                                {{ $grade->gradeItem->code }}: {{ $grade->grade }}@if(!is_null($grade->score))
                                        ({{$grade->score}} pkt.)@endif
                            </span>
                            @empty
                                <p>Brak ocen.</p>
                            @endforelse
                        </div>

                        <div>
                            <p class="mb-0"><small>Średnia:</small> {{ number_format($gradesList['total']['average_grade'], 2) }}</p>
                            <p class="mb-0"><small>Punkty:</small> {{ $gradesList['total']['score_sum']}} pkt. <small>/</small> {{$gradesList['total']['score_max'] }} pkt.</p>
                        </div>

                    </div>
                </div>
            </div>
            @empty
                <h5>Brak ocen</h5>
            @endforelse
        </div>
    </section>
@endsection
