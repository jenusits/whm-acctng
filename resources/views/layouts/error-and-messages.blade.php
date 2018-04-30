@if($errors->all())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success">{{session()->get('message')}}</div>
@elseif(session()->has('message')) 
    <div class="alert alert-danger">{{session()->get('message')}}</div>
@endif