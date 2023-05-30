@if(count($errors) > 0)
@foreach($errors->all() as $error)
<div class="warning-msg">
    !!! Warning : {{ $error }} !!!
</div>
@endforeach
@endif
