@if($errors->all())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success">{{session()->get('message')}}
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
@elseif(session()->has('warning')) 
    <div class="alert alert-warning">{{session()->get('warning')}}
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
@endif