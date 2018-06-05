@extends('layouts.app')

@section('content')
     <div id="payroll" class="container">
         <h2 class="mb-5">Payroll: {{ $employee->meta('first_name') }} {{ $employee->meta('last_name') }}</h2>

          @include('layouts.error-and-messages')
          <form action="{{ route('payroll.store') }}" method="POST">
               @csrf 
               <input type="hidden" step="any" id="employee_id" name="employee_id" value="{{ $employee->id }}">   
               <div class="form-group">
                    <input type="checkbox" id="over_time" name="over_time" class="">
                    <label for="over_time">Overtime?</label>
               </div>
               <div class="form-group">
                    <label for="hours">Hours</label>
                    <input type="number" step="any" id="hours" name="hours" class="form-control">
               </div>     
               <div class="form-group">
                    <label for="employee_id">Rate</label>
                    <input type="number" step="any" id="rate" name="rate" class="form-control">
               </div>
               <button class="btn btn-success">Save</button>
          </form>
     </div>
@endsection