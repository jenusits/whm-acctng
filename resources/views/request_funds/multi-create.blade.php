@extends('layouts.app')

@section('content')

<div id="multi" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 table-responsive">
            <div class="card">
                <div class="card-header">
                    Request Fund
                    <button class="btn btn-success" style="float: right" title="Add new row" @click="addNewRow">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
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
                                    <td style="padding: 20px">
                                        <textarea type="text" rows="1" class="form-control" id="particulars" v-bind:name="row._particulars"></textarea>
                                    </td>
                                    <td style="padding: 20px">
                                        <input type="number" class="form-control" id="amount" v-bind:name="row._amount">
                                    </td>
                                    <td style="padding: 20px">
                                        <select id="categories" class="form-control" v-bind:name="row._category">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding: 20px">
                                        <button type="button" class="btn btn-danger" @click="removeRow(row.id, index)" v-bind:id="row.id"><i v-bind:id="row.id" class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Submit Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/request-funds.js') }}"></script>
@endsection