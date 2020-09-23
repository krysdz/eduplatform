<button class="btn btn-primary">
    <a class="text-white" href="{{route('teacher.sections.edit', $section->id)}}">
        Edytuj sekcję
    </a>
</button>
<form action="{{route('teacher.sections.update', $section->id)}}" method="POST">
    @method('PUT')
    @csrf
    @if(!$section->is_active)
        <button type="submit" name="action" value="publish" class="btn btn-warning">
            Opublikuj sekcję
        </button>
    @else
        <button type="submit" name="action" value="hide" class="btn btn-success">
            Ukryj sekcję
        </button>
    @endif
</form>
<form action="{{route('teacher.sections.destroy', $section->id)}}" method="POST">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger" type="submit">Usuń</button>
</form>
