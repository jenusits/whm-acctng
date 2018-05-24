@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="request-fund" >
    @include('layouts.error-and-messages')
        <div class="row">
            <div class="col-md-12 col-md-offset-1">
                <div class="row">
                    <div class="col-md-3"> 
                        Cheque Details: <b>#{{ $expense->id }}</b>
                    </div>
                    <div class="col-md-3">
                    <?php
                        $pd = \Carbon\Carbon::parse($expense_meta['payment_date'])->toFormattedDateString();
                    ?>
                        Payment Date: <b>{{ $pd }}</b>
                    </div>
                    <div class="col-md-3">
                        Status: <b>
                            @if($expense->approved == 1)
                                <span class="text-success">Approved</span>
                            @elseif($expense->approved == 2)
                                <span class="text-danger">Not Approved</span>
                            @else
                                <span class="text-warning">Pending</span>
                            @endif
                        </b>
                    </div>
                    <div class="col-md-3">
                        Created: <b>{{ $expense->created_at->toFormattedDateString() }}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        Payee: <b>{{ \App\Payee::find($expense_meta['payee'])->name }}</b>
                    </div>
                    <div class="col-md-3">
                        Bank Account: <b>{{ \App\Bank::find($expense_meta['bank_credit_account'])->name }}</b>
                    </div>
                </div>
                <div class="panel panel-success table-responsive">
                    <div class="panel-heading">
                    </div>
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
                <div class="row">
                    <div class="col-md-12">
                        Memo:
                        <p style=" padding-left: 20px;">
                            {{ $expense->memo }}
                        </p>
                    </div>
                </div>
                @if(Auth::guest())
                  <a href="{{ route('login') }}" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        Attachments
                        @foreach($attachments as $key => $attachment)
                        <div style="margin: 5px 45px">
                            <p><a href="{{ asset('uploads/attachments/' . $attachment->filename) }}" target="_blank">{{ $attachment->original_filename }}</a></p>
                            {{-- <img src="{{ asset('uploads/attachments/' . $attachment->filename) }}" class="rounded"> --}}
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-5 col-sd-3" style="float: right !important;">
                    <div class="" style="margin: 20px;">
                        <div class="panel-heading">Total:</div><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" value="{{ $total }}" disabled>
                        <br>
                        <label>Created by:</label><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" value="{{ $user->name }}" disabled>
                        <br>
                        @if($expense->approved == 1)
                            <label>Approved by:</label><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" value="<?php $apr = \App\User::find($expense->approved_by); echo $apr->name; ?>" disabled>
                            <br>
                            <label>Approved on:</label><input class="form-control" style="border: none; border-bottom: 1px solid #333; background: none; border-radius: 0;" type="text" value="<?php $apr_on = Carbon\Carbon::createFromTimeString($expense->approved_on); echo $apr_on->toDayDateTimeString() ?>" disabled>
                        @endif
                    </div>
                    <div class="" style="margin: 20px;">
                        @if($current_user->hasPermissionTo('approve expenses'))
                            {{-- @if($expense->approved == 1) --}}
                                <form id="form-approve-{{ $expense->id }}" action="{{ route('check.update', $expense->id ) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('patch')
                                    <?php session()->flash('approved', true); ?>
                                    <input type="hidden" name="approved" value="1">
                                    
                                    <span data-toggle="tooltip" data-html="true" title="Approve Request">
                                        <button class="btn btn-success" type="button" @click="focusedID = {{ $expense->id }}; reference_number = '#' + focusedID;" data-toggle="modal" data-target="#approve-modal" title="Approve request"><i class="fas fa-check"></i></button>
                                    </span>
                                </form>
                                <form id="form-disapprove-{{ $expense->id }}" action="{{ route('check.update', $expense->id ) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('patch')
                                    <?php session()->flash('approved', true); ?>
                                    <input type="hidden" name="approved" value="2">
                                    
                                    <span data-toggle="tooltip" data-html="true" title="Approve Request">
                                        <button class="btn btn-danger" type="button" @click="focusedID = {{ $expense->id }}; reference_number = '#' + focusedID;" data-toggle="modal" data-target="#disapprove-modal" title="Approve request"><i class="fas fa-times"></i></button>
                                    </span>
                                {{-- <button class="btn btn-danger" title="Disapprove request"><i class="fas fa-times"></i></button> --}}
                                </form>
                            {{-- @else --}}
                            {{-- @endif --}}
                        @endif
                        
                        @if($current_user->hasPermissionTo('update expenses') || Auth::id() == $expense->author)
                            <a href="{{ route('check.edit', $expense->id )}}" class="btn btn-warning">Edit</a>
                        @endif
                        @if($current_user->hasPermissionTo('delete expenses') || Auth::id() == $expense->author)
                            <form id="form-{{ $expense->id }}" action="{{route('check.destroy', $expense->id)}}" method="post" class="d-inline-block">
                                @csrf
                                @method('delete')
                                {{-- <button class="btn btn-danger" type="submit">Delete</button> --}}
                                <button @click="focusedID = {{ $expense->id }}; reference_number = '#' + focusedID;" type="button" class="btn btn-danger" data-toggle="modal" data-target="#app-modal">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <b-modal @close="focusedID = 0" @confirm="deleteRequest" id="app-modal" title="Confirm Action">
            Are you sure you want to delete Request with a reference number of <b>@{{ reference_number }}</b>?
        </b-modal>
        <b-modal @close="focusedID = 0" @confirm="approveRequest" id="approve-modal" title="Confirm Action">
            Approve request <b>@{{ reference_number }}</b>?
        </b-modal>
        <b-modal @close="focusedID = 0" @confirm="disapproveRequest" id="disapprove-modal" title="Confirm Action">
            Reject request <b>@{{ reference_number }}</b>?
        </b-modal>
    </div>
    

@endsection