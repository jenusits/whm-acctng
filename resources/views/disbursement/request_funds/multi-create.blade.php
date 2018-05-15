@extends('layouts.app')

@section('content')
<div id="root"></div>
<div id="multi" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 table-responsive">
            <div class="card">
                <div class="card-header">
                    Request Fund
                    <a style="float: right;" class="link" href="{{ route('request_funds.create') }}">Submit a Single Particular</a>
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                @if(sizeof($categories) > 0)
                    <form method="POST" action="/request_funds">
                        @csrf
                        <input type="hidden" name="multi" v-model="rows.length">
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
                                    <td style="padding: 20px">
                                    <textarea type="text" rows="1" class="form-control" id="particulars" v-model="row.particulars" v-bind:name="row._particulars">@{{ index + ' ' + row.id }}</textarea>
                                    </td>
                                    <td style="padding: 20px">
                                        <input type="number" class="form-control" id="amount" v-model="row.amount" v-bind:name="row._amount">
                                    </td>
                                    <td style="padding: 20px">
                                        <select id="categories" class="form-control" v-model="row.category" v-bind:name="row._category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding: 20px">
                                        <button type="button" class="btn btn-success" @click.prevent="" title="Add new row" @click="addNewRow(index)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" v-if="rows.length > 1" title="Remove this row" @click="removeRow(row.id, index)" v-bind:id="row.id"><i v-bind:id="row.id" class="fas fa-minus"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" v-bind:disabled="errors" class="btn btn-success">Submit Request</button>
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