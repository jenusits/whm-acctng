@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="multi" class="" >
    <div class="row justify-content-center" style="max-width: 100%; margin: 0 !important;">
        <div class="col-md-12 " style="margin: 0 !important; padding: 0 !important;">
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; float: left;">Bill</h3>
                    <div style="float: right;">
                        <h3 style="margin: 0;"><strong>PHP @{{ expense_amount || "0.00" }}</strong></h3>
                    </div>
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                @if(sizeof($categories) > 0)
                    <form method="POST" action="{{ route('bill.update', $expense->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input type="hidden" name="multi" v-model="rows.length">

                        <input type="hidden" name="form-type" value="expenses">
                        <input type="hidden" name="multi-edit" value="{{ $expense->id }}">

                        <div class="form-group row">
                            <label for="payee" class="col-md-3 col-form-label text-md-right">{{ __('Supplier') }}</label>
                            <div class="col-md-2">
                                <select id="payee" name="payee" class="form-control">
                                    @foreach ($payees as $payee)
                                        @if($expense_meta['supplier'] == $payee->id)
                                            <option value="{{ $payee->id }}" selected>{{ $payee->name }}</option>
                                        @else
                                            <option value="{{ $payee->id }}">{{ $payee->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mailing_address" class="col-md-3 col-form-label text-md-right">{{ __('Mailing Address') }}</label>
                            <div class="col-md-2">
                                <textarea name="mailing_address" id="mailing_address" maxlength="2000" style="resize: none;" rows="4" class="form-control">{{ $expense_meta['mailing_address'] }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bill-date" class="col-md-3 col-form-label text-md-right">{{ __('Bill Date') }}</label>
                            <div class="col-md-2">
                                <datepicker input-class="form-control" name="bill_date" id="bill-date" v-bind:value="'{{ \Carbon\Carbon::parse($expense_meta['bill_date'])->format('d M Y') }}'"></datepicker>
                            </div>

                            <label for="due-date" class="col-md-3 col-form-label text-md-right">{{ __('Due Date') }}</label>
                            <div class="col-md-2">
                                <datepicker input-class="form-control" name="due_date" id="due-date" v-bind:value="'{{ \Carbon\Carbon::parse($expense_meta['due_date'])->format('d M Y') }}'"></datepicker>
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
                                    <td style="">
                                        <input type="hidden" v-model="row.id" v-bind:name="row._id">
                                        <textarea type="text" rows="1" class="form-control" id="particulars" v-model="row.particulars" v-bind:name="row._particulars">@{{ index + ' ' + row.id }}</textarea>
                                    </td>
                                    <td style="">
                                        <input type="number" class="form-control" id="amount" v-model="row.amount" v-bind:name="row._amount">
                                    </td>
                                    <td style="">
                                        <select id="categories" class="form-control" v-model="row.category" v-bind:name="row._category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="">
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
                            <div class="col-md-5">
                                <textarea type="text" rows="3" class="form-control" name="memo" id="memo">{{ $expense->memo }}</textarea>
                            </div>
                        </div>
                        {{-- <div class="form-group">
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
                        </div> --}}
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" v-bind:disabled="errors" class="btn btn-success">Save Bill</button>
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