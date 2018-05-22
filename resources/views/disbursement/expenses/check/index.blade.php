@extends('layouts.app')

@section('content')
<div id="root"></div>
    <div id="request-funds" >
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                <div class="btn-group float-left">
                    <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        New Transaction
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('bill.create') }}?multi=2">Bill</a>
                        <a class="dropdown-item" href="{{ route('expenses.create') }}?multi=2">Expense</a>
                        <a class="dropdown-item" href="{{ route('check.create') }}?multi=2">Check</a>
                        {{-- <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('bill.create') }}?multi=2">Separated link</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-md-offset-1">
                @if(isset($_GET['pending']) || isset($_GET['notapproved']) || isset($_GET['approved']))
                    <a class="btn" href="{{ route('expenses.index') }}">See all expenses</a>
                @endif
            </div>
        </div>
        <hr>  
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success">
                    <div class="panel-heading">Expense Transactions</div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
    
                    <!-- Table -->
                    <table id="requests" class="table table-sm table-transparent table-hover">
                        <thead>
                            <tr>
                                <th>Reference #</th>
                                <th>Amount</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            @foreach($expenses as $key => $expense)
                            <tbody>
                                <tr>
                                    <td>
                                        <a class="link" href="{{ route('expenses.show', $expense->id) }}">#{{ $expense->id }}</a>
                                    </td>
                                    <td>
                                        <?php   
                                            $amount = DB::table('expenses')
                                            ->join('expenses_details', 'expenses.id', '=', 'expenses_details.expenses_id')->where('expenses_details.expenses_id', '=', $expense->id)
                                            ->sum('expenses_details.amount'); 
                                            echo $amount;
                                        ?>
                                    </td>
                                    <td>{{ $expense->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if($expense->approved == 1)
                                            <span class="text-success">Approved</span>
                                        @elseif($expense->approved == 2)
                                            <span class="text-danger">Not Approved</span>
                                        @else
                                            <span class="text-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                    {{-- @if(Auth::id() == $expense->author || \App\Checker::is_permitted('expenses')) --}}
                                        @if(Auth::id() == $expense->author || \App\Checker::is_permitted('update expenses'))
                                            <a style="margin: 5px; font-size: 10px" href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if(Auth::id() == $expense->author || \App\Checker::is_permitted('delete expenses'))
                                            <form id="form-{{ $expense->id }}" action="{{ route('expenses.destroy', $expense->id) }}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                {{-- <button style="margin: 5px; font-size: 10px" class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                                <button @click="focusedID = {{ $expense->id }}; reference_number = '#' + focusedID;" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target=".app-modal"><i class="fas fa-trash"></i></button>
                                            </form>
                                        @endif
                                    {{-- @endif --}}
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
        <b-modal id="app-modal" ref="requestfunds" @close="focusedID = 0" focusedID="focusedID" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete Request with a reference number of <b>@{{ reference_number }}</b>?
        </b-modal>
    </div>
@endsection