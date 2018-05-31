@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="multi" class="" >
    <div class="row justify-content-center" style="max-width: 100%; margin: 0 !important;">
        <div class="col-md-12 " style="margin: 0 !important; padding: 0 !important;">
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; float: left;">Purchase Order</h3>
                    <div style="float: right;">
                        <h3 style="margin: 0;"><strong>PHP @{{ expense_amount || "0.00" }}</strong></h3>
                    </div>
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                @if(sizeof($categories) > 0)
                    <form method="POST" action="{{ route('purchase_order.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="multi" v-model="rows.length">

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="payee" class="col-form-label text-md-right">{{ __('Supplier') }}</label>
                                <select id="payee" name="payee" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($payees as $payee)
                                        <option value="{{ $payee->id }}">{{ $payee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="purchase_order_status" class="col-form-label text-md-right">{{ __('Purchase Order status') }}</label>
                                <select id="purchase_order_status" name="purchase_order_status" class="form-control">
                                    <option value="1">Open</option>
                                    <option value="0">Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="mailing_address" class=" col-form-label text-md-right">{{ __('Mailing Address') }}</label>
                                <textarea name="mailing_address" id="mailing_address" maxlength="2000" style="resize: none;" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="ship_to" class=" col-form-label text-md-right">{{ __('Ship to') }}</label>
                                <select id="ship_to" name="ship_to" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="due-date" class="col-form-label text-md-right">{{ __('Purchase Order Date') }}</label>
                                <datepicker input-class="form-control" name="due_date" id="due-date" v-bind:value="'{{ date('d M Y') }}'"></datepicker>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="shipping_address" class=" col-form-label text-md-right">{{ __('Shipping Address') }}</label>
                                <textarea name="shipping_address" id="shipping_address" maxlength="2000" style="resize: none;" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="ship_via" class="col-form-label text-md-right">{{ __('Ship via') }}</label>
                                <input class="form-control" name="ship_via" id="ship_via">
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
                                            <option value="">Please select</option>
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
                            <div class="col-md-5 mb-3">
                                <label for="message_to_supplier" class="">{{ __('Your message to supplier') }}</label>
                                <textarea type="text" rows="3" class="form-control" name="message_to_supplier" id="message_to_supplier"></textarea>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="memo" class="">{{ __('Memo') }}</label>
                                <textarea type="text" rows="3" class="form-control" name="memo" id="memo"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-5">
                                <label for="attachments" class="btn btn-info">{{ __('Add Attachment') }}</label>
                                <div class="alert alert-secondary border-secondary" v-if="inputFiles.length > 0">
                                    <div v-for="file, index in inputFiles">
                                        @{{ file.name }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <input type="file" style="display: none;" v-on:change="inputFileChange" multiple id="attachments" name="attachments[]" class="btn btn-info">
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