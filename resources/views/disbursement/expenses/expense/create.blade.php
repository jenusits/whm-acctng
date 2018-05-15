@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="multi" class="" >
    <div class="row justify-content-center" style="max-width: 100%; margin: 0 !important;">
        <div class="col-md-12 " style="margin: 0 !important; padding: 0 !important;">
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; float: left;">Expense</h3>
                    <div style="float: right;">
                        <h3 style="margin: 0;"><strong>PHP @{{ expense_amount || "0.00" }}</strong></h3>
                    </div>
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                @if(sizeof($categories) > 0)
                    <form method="POST" action="/expenses">
                        @csrf
                        <input type="hidden" name="multi" v-model="rows.length">

                        <div class="form-group row">
                            <label for="banks" class="col-md-3 col-form-label text-md-right">{{ __('Bank/Credit Account') }}</label>
                            <div class="col-md-2">
                                <select id="banks" name="bank" class="form-control">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment-date" class="col-md-3 col-form-label text-md-right">{{ __('Payment Date') }}</label>
                            <div class="col-md-2">
                                <datepicker input-class="form-control" name="payment_date" id="payment-date" v-bind:value="'{{ date('d M Y') }}'"></datepicker>
                            </div>
                            
                            <label for="payment-method" class="col-md-3 col-form-label text-md-right">{{ __('Payment Method') }}</label>
                            <div class="col-md-2">
                                <select id="payment-method" name="bank" class="form-control">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <table class="table table-sm table-transparent table-hover table-center ">
                            <thead>
                                <tr style="text-align: center;">
                                    <td>Particulars</td>
                                    <td>Amount</td>
                                    <td>Account Title</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>     
                                <tr v-for="row, index in rows" style="text-align: center;">
                                    <input type="hidden" v-bind:name="row._index" v-model="index">
                                    <td style="padding: 5px 20px">
                                    <textarea type="text" rows="1" class="form-control" id="particulars" v-model="row.particulars" v-bind:name="row._particulars">@{{ index + ' ' + row.id }}</textarea>
                                    </td>
                                    <td style="padding: 5px 20px">
                                        <input type="number" step="any" class="form-control" id="amount" v-model="row.amount" v-bind:name="row._amount">
                                    </td>
                                    <td style="padding: 5px 20px">
                                        <select id="categories" class="form-control" v-model="row.category" v-bind:name="row._category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding: 10px 20px">
                                        <button type="button" class="btn btn-success btn-sm" @click.prevent="" title="Add new row" @click="addNewRow(index)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" v-if="rows.length > 1" title="Remove this row" @click="removeRow(row.id, index)" v-bind:id="row.id"><i v-bind:id="row.id" class="fas fa-minus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <div>
                                <label for="memo" class="">{{ __('Memo') }}</label>
                            </div>
                            <div>
                                <textarea style="width: 20%" type="text" rows="3" class="form-control" id="memo"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" v-bind:disabled="errors" class="btn btn-success">Save Expense</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p>You don't have any Chart Accounts. Please create at least one <a href="{{ route('charts.create') }}">here</a>.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection