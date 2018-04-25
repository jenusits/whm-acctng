@extends('layouts.app')

@section('content')
     
     <div class="container">
          <h2>Create an Account</h2><br  />
          @include('layouts.error-and-messages')
          <form method="post" action="{{route('charts.store')}}">
              @csrf
              <div class="row">
                  <div class="form-group col-md-4">
                      <label for="name">Account:</label>
                      <input type="text" class="form-control" name="account_name">
                  </div>
                  <div class="form-group col-md-4" style="margin-top:30px">
                      <button type="submit" class="btn btn-success">Save</button>
      
                  </div>
                  <div class="col-md-4"></div>
              </div>
          </form>
      </div>

@endsection