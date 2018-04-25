@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Request Fund</h2><br  />
    @include('layouts.error-and-messages')
    <form method="POST" action="{{ route('request_funds.update', $request_fund->id) }}">
        @csrf
        @method('patch')
        <div class="form-group row">
            <label for="particulars" class="col-sm-4 col-form-label text-md-right">{{ __('Particulars') }}</label>
            <div class="col-md-6">
                <textarea type="text" rows="10" class="form-control" id="particulars" name="particulars">{!! trim(preg_replace('/<br\\s*?\/??>/i', '', $request_fund->particulars)) !!}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="amount" class="col-sm-4 col-form-label text-md-right">{{ __('Amount') }}</label>
            <div class="col-md-6">
                <input type="number" class="form-control" id="amount" name="amount" value="{{ $request_fund->amount }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="categories" class="col-sm-4 col-form-label text-md-right">{{ __('Category') }}</label>
            <div class="col-md-6">
                <select id="categories" class="form-control" name="category">
                    @foreach ($charts as $category)
                        @if($request_fund->category == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->account_name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->account_name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row" style="float: right">
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">Update Request</button>
            </div>
        </div>
    </form>
</div>
@endsection