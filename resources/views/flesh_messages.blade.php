@if(session('success'))
    <div class="notification is-success my-3">
        <button class="delete"></button>
        {!! session('success') !!}
    </div>
@endif

@if(session('error'))
    <div class="notification is-danger my-3">
        <button class="delete"></button>
        {!! session('error') !!}
    </div>
@endif
