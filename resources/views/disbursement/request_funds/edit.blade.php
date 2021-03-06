@extends('layouts.app')

@section('content')
<div id="multi" class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 table-responsive">
            <div class="card">
                <div class="card-header">
                    Request Fund
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                    <form method="POST" action="{{ route('request_funds.update', $request_fund->id) }}">
                        @csrf
                        @method('put')
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
                                        <input type="hidden" v-model="row.id" v-bind:name="row._id">
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
                                <button type="submit" v-bind:disabled="errors" class="btn btn-success">Update Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.vuejs')
<script>
var i = 0;

var multi = new Vue({
    el: '#multi',
    data: {
        rows: [],
        submitted: false,
    },
    computed: {
        errors: function() {
            for (var key in this.rows) {
                if (! this.rows[key].particulars) return true
            }
            for (var key in this.rows) {
                if (! this.rows[key].amount) return true
            }
            for (var key in this.rows) {
                if (! this.rows[key].category) return true
            }

            return false;
        }
    },
    mounted: function() {
        this.rows = JSON.parse('<?= $request_fund->particulars ?>');
        for (i; i < this.rows.length; i++) {
            console.log(i);
            // this.rows[i].id = i;
            this.rows[i]._id = 'request_funds[' + i + '][id]';
            this.rows[i]._particulars = 'request_funds[' + i + '][particulars]';
            this.rows[i]._amount = 'request_funds[' + i + '][amount]';
            this.rows[i]._category = 'request_funds[' + i + '][category]';
        }
        console.log(this.rows);
    },
    methods: {
        addNewRow(index) {
            var newRow = {
                id: i,
                _particulars: 'request_funds[' + i + '][particulars]',
                _amount: 'request_funds[' + i + '][amount]',
                _category: 'request_funds[' + i + '][category]',
                particulars: '',
                amount: '',
                category: '',
            };
            try {
                this.rows.splice(index + 1, 0, newRow);
            } catch(e) {
                console.log(e);
            }
            i++;

        }, 
        removeRow(id, index) {
            console.log(index);
            this.rows.splice(index, 1);
        }
    }
});
</script>
@endsection