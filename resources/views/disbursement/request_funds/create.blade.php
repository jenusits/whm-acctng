@extends('layouts.app')

@section('content')

<div >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Request Fund
                </div>
                @include('layouts.error-and-messages')
                <div class="card-body">
                @if(sizeof($categories) > 0)
                    <form method="POST" action="/request_funds">
                        @csrf
                        <div class="form-group row">
                            <label for="particulars" class="col-sm-4 col-form-label text-md-right">{{ __('Particulars') }}</label>
                            <div class="col-md-6">
                                <textarea type="text" rows="10" class="form-control" id="particulars" name="particulars"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-sm-4 col-form-label text-md-right">{{ __('Amount') }}</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="amount" name="amount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="categories" class="col-sm-4 col-form-label text-md-right">{{ __('Category') }}</label>
                            <div class="col-md-6">
                                <select id="categories" class="form-control" name="category">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" style="float: right">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success">Submit Request</button>
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