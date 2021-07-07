@if(session()->has('info'))
<div class="alert alert-info" role="alert">
    {{ session()->get('info') }}
</div>
@endif

@if(session()->has('danger'))
<div class="alert alert-warning" role="alert">
    <ul>
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif