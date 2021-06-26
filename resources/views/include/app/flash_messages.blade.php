@if(Session::has('success'))
    <div class="notification is-success my-3">
        <button class="delete"></button>
        {!! Session::get('success') !!}
    </div>
@endif

@if(Session::has('error'))
    <div class="notification is-danger my-3">
        <button class="delete"></button>
        {!! Session::get('error') !!}
    </div>
@endif
