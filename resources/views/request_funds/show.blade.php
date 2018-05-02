@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="request-fund" class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-success table-responsive">
                    <div class="panel-heading">
                        Request Fund Details: <b>#{{ $request_fund->id }}</b>
                        <span style="float: right">
                            Date: <b>{{ $request_fund->created_at->toFormattedDateString() }}</b>
                        </span>
                    </div>
                    @include('layouts.error-and-messages')
                    @if(Auth::check())
                        <!-- Table -->
                        <table class="table table-sm table-transparent table-hover">
                            <thead>
                                <tr>
                                    <th>Particulars</th>
                                    <th>Amount</th>
                                    <th>Account</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $total = 0; ?>
                            @foreach($particulars as $key => $particular)
                            <?php $total += $particular->amount ?>
                                <tr>
                                    <td>{{ $particular->particulars }}</td>
                                    <td>{{ $particular->amount }}</td>
                                    <td>{{ $charts->find($particular->category)->account_name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                @if(Auth::guest())
                  <a href="{{ route('login') }}" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                @endif
                <div style="float: right !important">
                    <div class="" style="margin: 20px;">
                        <div class="panel-heading">Total:</div><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" value="{{ $total }}" disabled>
                        <br>
                        <label>Created by:</label><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" value="{{ $user->name }}" disabled>
                    </div>
                    <div class="" style="margin: 20px;">
                        @if($user->hasPermissionTo('approve request_funds'))
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
                        @endif
                        
                        @if($user->hasPermissionTo('update request_funds'))
                            <a href="{{ route('request_funds.edit', $request_fund->id )}}" class="btn btn-warning">Edit</a>
                        @endif
                        @if($user->hasPermissionTo('delete request_funds'))
                            <form id="form-{{ $request_fund->id }}" action="{{route('request_funds.destroy', $request_fund->id)}}" method="post" class="d-inline-block">
                                @csrf
                                @method('delete')
                                {{-- <button class="btn btn-danger" type="submit">Delete</button> --}}
                                <button @click="focusedID = {{ $request_fund->id }}; reference_number = '#' + focusedID;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#app-modal">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <b-modal @close="focusedID = 0" @confirm="deleteRequest" title="Confirm Action">
            Are you sure you want to delete Request with a reference number of <b>@{{ reference_number }}</b>?
        </b-modal>
    </div>
    @include('layouts.vuejs')
    <script>
        new Vue({
            el: '#request-fund',
            data: {
                focusedID: 0,
                reference_number: 0,
            },
            methods: {
                deleteRequest: function() {
                    var form = document.querySelector('#form-' + this.focusedID)
                    form.submit();
                    this.focusedID = 0;
                }
            }
        });
    </script>
    

@endsection