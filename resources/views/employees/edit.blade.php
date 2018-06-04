@extends('layouts.app')

@section('content')
     <div class="container">
          @include('layouts.error-and-messages')
          <form action="{{ route('employees.update', $employee->id) }}" method="POST">
               @csrf 
               @method('put')
               <div class="form-group">
                    <label for="employee_id">Employee ID</label>
                    <input id="employee_id" name="employee_id" type="text" required class="form-control" value="{{ $employee->employee_id }}">
               </div>     
               <div class="form-group">
                    <label for="employee_id">First Name</label>
                    <input id="employee_id" name="first_name" type="text" required class="form-control" value="{{ $employee->meta('first_name') }}">
               </div>     
               <div class="form-group">
                    <label for="employee_id">Last Name</label>
                    <input id="employee_id" name="last_name" type="text" required class="form-control" value="{{ $employee->meta('last_name') }}">
               </div>
               <button class="btn btn-success">Save</button>
          </form>
     </div>
@endsection