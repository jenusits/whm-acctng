@extends('layouts.app')

@section('content')
     <div >
          <div class="row">
              <div class="col-md-12 col-md-offset-1">
                  <div class="panel panel-success">
                      <div class="panel-heading">Chart of Accounts</div>
                    @include('layouts.error-and-messages')  
                  @if(Auth::check())
                      <!-- Table -->
                          <table class="table">
                              <tr>
                                  <th>ID</th>
                                  <td colspan="2">{{ $chart->id }}</td>
                              </tr>
                              <tr>
                                      <th>Accounts</th>
                                      <td colspan="2">{{ $chart->account_name }}</td>
                              </tr>
                              <tr>
                                  <th>Actions</th>
                                  <td><a href="{{route('charts.edit', $chart->id)}}" class="btn btn-warning">Edit</a></td>
                                  <td>
                                        <form action="{{route('charts.destroy', $chart->id)}}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                      </td>
                                  </tr>
                              <tr>
  
                              </tr>
                          </table>
                      @endif
  
  
                  </div>
                  @if(Auth::guest())
                    <a href="{{ route('login') }}" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                  @endif
              </div>
          </div>
      </div>
@endsection