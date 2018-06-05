@extends('layouts.app')

@section('content')
     <div class="container">
         <h2>Add New Employee</h2>
          @include('layouts.error-and-messages')
          <form action="{{ route('employees.store') }}" method="POST">
               @csrf 
               <div class="form-group">
                    <label for="employee_id">Employee ID</label>
                    <input id="employee_id" name="employee_id" type="text" required class="form-control">
               </div>     
               <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input id="first_name" name="first_name" type="text" required class="form-control">
               </div>     
               <div class="form-group">
                    <label for="first_name">Last Name</label>
                    <input id="first_name" name="last_name" type="text" required class="form-control">
               </div>
               <button class="btn btn-success">Save</button>
          </form>
     </div>

@endsection