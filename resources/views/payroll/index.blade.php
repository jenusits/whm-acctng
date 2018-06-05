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
               <table class="table table-sm table-transparent table-hover text-center">
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
                                    @if(\PermissionChecker::is_permitted('update expenses'))
                                        <a style="margin: 5px;" href="{{ route('payroll.show', $employee->id) }}" class="btn btn-info btn-sm">Payroll</a>
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