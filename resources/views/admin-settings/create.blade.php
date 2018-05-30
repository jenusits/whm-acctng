@extends('layouts.app')

@section('content')
     
    <div >
        <h2>Create a new Option</h2><br  />
        @include('layouts.error-and-messages')
        <form method="post" action="{{route('admin-settings.store')}}">
            @csrf
            <div class="row mb-3 col-md-4">
                <label for="key">Name of Option:</label>
                <input type="text" id="key" class="form-control" name="key">
            </div>
            <div class="row mb-3 col-md-4">
                <label for="value">Value:</label>
                <input type="text" id="value" class="form-control" name="value">
            </div>
            <div class="row mb-3 col-md-4">
                <label for="data_type">Data type:</label>
                <input type="text" id="data_type" class="form-control" name="data_type">
            </div>
            <div class="form-group">
                <input type="checkbox" id="show" name="show">
                <label for="show">Show on Settings page?</label>
            </div>
            <div class="row mb-3 col-md-4" style="margin-top:30px">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            <div class="col-md-4"></div>
        </form>
    </div>

@endsection