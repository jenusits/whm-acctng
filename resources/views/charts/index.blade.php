@extends('layouts.app')

@section('content')

<div class="container">
     <div class="row">
        @if(Auth::check())
            <a class="link" href="{{ route('charts.create') }}">Create Chart</a>
        @endif
     </div>
     <div class="row">
          <hr>
     </div>
     <div class="row">
              <div class="col-md-12 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-heading">Chart of Accounts</div>
  
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
                  @if(Auth::check())
                      <!-- Table -->
                          <table class="table">
                              <tr>
                                  <th>ID</th>
                                  <th>Accounts</th>
                              </tr>
                              @foreach($charts as $key => $chart)
                                  <tr>
                                      <td>{{ $chart->id }}</td><td><a href="{{route('charts.show', $chart->id)}}">{{ $chart->account_name }}</a></td>
                                      <td><a href="{{route('charts.edit', $chart->id)}}" class="btn btn-warning">Edit</a></td>
                                      <td>
                                          <form action="{{route('charts.destroy', $chart->id)}}" method="post" class="d-inline-block">
                                              @csrf
                                              @method('delete')
                                              <button class="btn btn-danger" type="submit">Delete</button>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach
                              <tr>
  
                              </tr>
                          </table>
                      @endif
  
  
                  </div>
                  @if(Auth::guest())
                      <a href="/login" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                  @endif
              </div>
          </div>
      </div>

@endsection