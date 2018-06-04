@extends('layouts.app')

@section('content')

     <div class="">
          <div class="mb-4">
               <a href="{{ route('employees.create') }}" class="btn btn-success">Add New Employee</a>
          </div>
          <div class="row">
               <div class="mb-3">
                    <h4>Employees</h4>
               </div>
               <table class="table text-center">
                    <thead>
                         <tr>
                              <th scope="col">Employee ID</th>
                              <th scope="col">Name</th>
                              <th scope="col">Login Status</th>
                              <th scope="col">Action</th>
                         </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $key => $employee)
                         <tr>
                              <td><a href="{{ route('employees.show', $employee->id) }}">{{ $employee->employee_id }}</a></td>
                              <td>{{ $employee->meta('first_name') }} {{ $employee->meta('last_name') }}</td>
                              <td>
                                   @if($employee->meta('login_status') == 0)
                                        Currently logged off
                                   @else
                                        Logged in
                                   @endif
                              </td>
                              <td>
                                   {{-- <a style="margin: 5px; font-size: 10px" href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></a>
                                   <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                        @csrf @method('delete')
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                   </form> --}}
                                    @if(\PermissionChecker::is_permitted('update expenses'))
                                        <a style="margin: 5px; font-size: 10px" href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if(\PermissionChecker::is_permitted('delete expenses'))
                                        <form id="form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee->id) }}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('delete')
                                            {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                            <button @click="focusedID = {{ $employee->id }}; chart_name = '{{ $employee->meta('first_name') }} {{ $employee->meta('last_name') }} ';" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target=".app-modal"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                              </td>
                         </tr>
                    @endforeach
                    </tbody>
               </table>
          </div>
          <b-modal id="app-modal" ref="requestfunds" @close="focusedID = 0" focusedID="focusedID" @confirm="deleteRequest" title="Confirm Action">
              Are you sure you want to delete Employee named <b>@{{ chart_name }}</b>?
          </b-modal>
     </div>

@endsection