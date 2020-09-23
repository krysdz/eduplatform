<div>
    @empty($lesson->title)
        <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET">
            <button type="submit" name="action" value="plan" class="btn btn-success">Zaplanuj lekcję</button>
            <button type="submit" name="action" value="create" class="btn btn-warning">Stwórz lekcję</button>
        </form>
    @endempty
    @isset($lesson->title)
        <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET">
            <button type="submit" name="action" value="edit" class="btn btn-primary">Edytuj lekcję</button>
        </form>
        <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST">
            @method('PUT')
            @csrf
            @if(!$lesson->is_active)
                <button type="submit" name="action" value="publish" class="btn btn-warning">Opublikuj lekcję</button>
            @endif
            <button type="submit" name="action" value="clear" class="btn btn-danger">Wyczyść lekcję</button>
        </form>
@endisset
