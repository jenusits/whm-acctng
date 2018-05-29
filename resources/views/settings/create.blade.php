@extends('layouts.app')

@section('content')
     
     <div >
          <h2>Create a Role</h2><br  />
          @include('layouts.error-and-messages')
          <form method="post" action="{{route('roles.store')}}">
              @csrf
              <div class="row">
                  <div class="form-group col-md-4">
                      <label for="name">Name of a Role:</label>
                      <input type="text" class="form-control" name="name">
                  </div>
                  <div class="form-group col-md-4" style="margin-top:30px">
                      <button type="submit" class="btn btn-success">Save</button>
      
                  </div>
                  <div class="col-md-4"></div>
              </div>
          </form>
      </div>

@endsection