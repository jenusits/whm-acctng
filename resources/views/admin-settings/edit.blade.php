@extends('layouts.app')

@section('content')
     
    <div >
        <h2>Edit  Option: {{ $setting->key }}</h2><br  />
        @include('layouts.error-and-messages')
        <form method="post" action="{{ route('admin-settings.update', $setting->id) }}">
            @csrf
            @method('put')
            <div class="row mb-3 col-md-4">
                <label for="key">Name of Option:</label>
                <input type="text" id="key" class="form-control" value="{{ $setting->key }}" name="key">
            </div>
            <div class="row mb-3 col-md-4">
                <label for="value">Value:</label>
                <input type="text" id="value" class="form-control" value="{{ json_decode( $setting->value) }}" name="value">
            </div>
            <div class="row mb-3 col-md-4">
                <label for="data_type">Data type:</label>
                <input type="text" id="data_type" class="form-control" value="{{ $setting->data_type }}" name="data_type">
            </div>
            <div class="form-group">
                <input type="checkbox" id="show" name="show" @if($setting->show) checked @endif>
                <label for="show">Show on Settings page?</label>
            </div>
            <div class="row mb-3 col-md-4" style="margin-top:30px">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            <div class="col-md-4"></div>
        </form>
    </div>

@endsection