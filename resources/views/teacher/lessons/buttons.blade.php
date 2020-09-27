<div class="buttons">

    @empty($lesson->title)
        <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET" class="is-flex">
            <button type="submit" name="action" value="plan" class="button">Zaplanuj lekcję</button>
            <button type="submit" name="action" value="create" class="button">Stwórz lekcję</button>
        </form>
    @endempty
    @isset($lesson->title)
        <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET" class="is-flex">
            <button type="submit" name="action" value="edit" class="button mr-2">Edytuj lekcję</button>
        </form>
        <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST" class="is-flex">
            @method('PUT')
            @csrf
            @if(!$lesson->is_active)
                <button type="submit" name="action" value="publish" class="button">Opublikuj lekcję</button>
            @endif
            <button type="submit" name="action" value="clear" class="button">Wyczyść lekcję</button>
        </form>
    @endisset
</div>
