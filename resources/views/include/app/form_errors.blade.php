@if ($errors->any())
    <div class="notification is-danger my-3">
        <button class="delete"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
