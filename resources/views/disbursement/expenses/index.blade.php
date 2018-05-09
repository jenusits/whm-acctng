@extends('layouts.app')

@section('content')
<div id="root"></div>
    <div id="request-funds" class="container">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                @if(Auth::check())
                    <a href="{{ route('expenses.create') }}" class="btn btn-success">Create Expense</a>
                @endif
            </div>
        </div>
        <hr>  
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Expenses</div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
    
                    <!-- Table -->
                    <table id="requests" class="table table-sm table-transparent table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            @foreach($expenses as $key => $expense)
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="link" href="{{ route('expenses.show', $expense->id) }}">{{ $expense->id }}</a>
                                    </td>
                                    <td>{{ $expense->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if(\App\Checker::is_permitted('update expenses'))
                                            <a style="margin: 5px; font-size: 10px" href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if(\App\Checker::is_permitted('delete expenses'))
                                            <form id="form-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                                <button @click="focusedID = {{ $expenses->id }}; reference_number = '#' + focusedID;" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target=".app-modal"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
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
        <b-modal ref="requestfunds" @close="focusedID = 0" focusedID="focusedID" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete <b>Expense #@{{ reference_number }}</b>?
        </b-modal>
    </div>
@endsection