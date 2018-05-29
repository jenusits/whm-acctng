@extends('layouts.app')

@section('content')
    <div >
        <h2>Settings</h2><br  />
        @include('layouts.error-and-messages')
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf
            @method('put')
            @foreach($settings->get() as $key => $setting)
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="text" name="{{ $setting->key }}" class="form-control" name="account_name" value="{{ $setting->value }}">
                </div>
                <div class="col-md-4"></div>
            </div>
            @endforeach

            <div class="form-group col-md-4" style="margin-top:30px">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
@endsection