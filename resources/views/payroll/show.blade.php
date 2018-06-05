@extends('layouts.app')

@section('content')

    <div class="">
        <div class="mb-4">
            <a href="{{ route('payroll.create', $employee->id) }}" class="btn btn-success">Add New Payroll</a>
        </div>
        <div class="row">
            <div class="col-md-3">
                <h3>Payroll: {{ $employee->meta('first_name') }} {{ $employee->meta('last_name') }}</h3>
            </div>
        </div>
        @include('layouts.error-and-messages')
        <table class="table text-center table-hover table-sm">
            <thead>
                <tr>
                        <th>Created</th>
                        <th>Overtime</th>
                        <th>Hours</th>
                        <th>Rate</th>
                        <th>Gross</th>
                        <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($employee->payrolls as $key => $payroll)
                <tr>
                    <td>{{ $payroll->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($payroll->over_time)
                        Yes
                        @else
                        No
                        @endif
                    </td>
                    <td>{{ $payroll->hours }}</td>
                    <td>{{ $payroll->rate }}</td>
                    <td>{{ $payroll->gross }}</td>
                    <td>
                        @if(\PermissionChecker::is_permitted('update payroll'))
                            <a style="margin: 5px; font-size: 10px" href="{{ route('payroll.edit', $payroll->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                        @endif
                        
                        @if(\PermissionChecker::is_permitted('delete payroll'))
                            <form id="form-{{ $payroll->id }}" action="{{ route('payroll.destroy', $payroll->id) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('delete')
                                {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                <button @click="focusedID = {{ $payroll->id }}; reference_number = '#' + focusedID;" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target=".app-modal"><i class="fas fa-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
        <b-modal id="app-modal" @close="focusedID = 0" focusedID="focusedID" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete this payroll?
        </b-modal>
    </div>

@endsection