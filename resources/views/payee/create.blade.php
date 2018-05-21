@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Add a Payee
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                    <form method="POST" action="{{ route('payee.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="category" class="col-sm-4 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                {{-- <input type="number" step="any" class="form-control" id="balance" name="balance"> --}}
                                <select class="form-control" name="category" id="category">
                                        <option value="supplier">Supplier</option>
                                        <option value="customer">Customer</option>
                                        <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea type="text" rows="5" class="form-control" id="description" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Save Payee</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection