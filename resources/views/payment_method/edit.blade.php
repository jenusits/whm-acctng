@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Payment Method
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                    <form method="POST" action="{{ route('payment_method.update', $payment_method->id) }}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $payment_method->name }}" id="name" name="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-4 col-form-label text-md-right">{{ __('Description') }}</label>
                            <div class="col-md-6">
                                <textarea type="text" rows="5" class="form-control" value="{{ $payment_method->description }}" id="description" name="description">{{ $payment_method->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection