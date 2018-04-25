@extends('layouts.app')

@section('content')
     <div class="container">
          <h2>Edit an Account</h2><br  />
          @if($errors->all())
              <div class="alert alert-danger">
                  @foreach($errors->all() as $error)
                      <li>{{$error}}</li>
                      @endforeach
              </div>
          @endif
          @if(session()->has('message'))
              <div class="alert alert-success">{{session()->get('message')}}</div>
          @endif
          <form method="POST" action="{{route('charts.update', $chart->id)}}">
              @csrf
              <div class="row">
                  <div class="form-group col-md-4">
                      <label for="name">Account:</label>
                      <input type="text" class="form-control" name="account_name" value="{{$chart->account_name}}">
                  </div>
                  <div class="form-group col-md-4" style="margin-top:30px">
                      <button type="submit" class="btn btn-success">Update</button>
      
                  </div>
                  <div class="col-md-4"></div>
              </div>
          </form>
      </div>
@endsection