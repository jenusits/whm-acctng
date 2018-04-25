@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success table-responsive">
                    <div class="panel-heading">Request Fund Details</div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
                        <!-- Table -->
                        <table class="table table-sm table-transparent table-hover">
                            <tr>
                                <th>Particulars</th>
                                <td colspan="2">
                                    <div>
                                        {!! $request_fund->particulars !!}
                                    </div>
                                </td>
                            </tr>
                        
                            <tr>
                                <th>Amount</th>
                                <td colspan="2">
                                    <div>
                                        {!! $request_fund->amount !!}
                                    </div>
                                </td>
                            </tr>      
                            <tr>
                                    <th>Accounts</th>
                                    <td colspan="2">{{ $charts->find($request_fund->category)->account_name }}</td>
                            </tr>
                            <tr>
                                <th>Actions</th>
                                <td>
                                    @if($request_fund->approved)
                                        <form action="{{ route('request_funds.update', $request_fund->id ) }}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('patch')
                                            <?php session()->flash('approved', true); ?>
                                            <input type="hidden" name="approved" value="0">
                                        <button class="btn btn-danger" title="Disapprove request"><i class="fas fa-times"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('request_funds.update', $request_fund->id ) }}" method="post" class="d-inline-block">
                                            @csrf
                                            @method('patch')
                                            <?php session()->flash('approved', true); ?>
                                            <input type="hidden" name="approved" value="1">
                                            <button class="btn btn-success" title="Approve request"><i class="fas fa-check"></i></button>
                                        </form>
                                    @endif
                                    <a href="{{ route('request_funds.edit', $request_fund->id )}}" class="btn btn-warning">Edit</a>
                                    <form action="{{route('request_funds.destroy', $request_fund->id)}}" method="post" class="d-inline-block">
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