@extends('layouts.app')

@section('content')
    <div >
        <h2>Settings</h2><br  />
        @include('layouts.error-and-messages')
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            @foreach($settings as $key => $setting)
                @if($setting->show)
                    @if($setting->data_type == 'image')
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                                @if(json_decode($setting->value) != '')
                                    <div class="p-4">
                                        <img style="width: 100%" onclick="jQuery('#{{ $setting->key }}').click()" src="{{ '/storage/' . json_decode($setting->value) }}" alt="..." class="">
                                    </div>
                                @endif
                                <input type="file" id="{{ $setting->key }}" name="{{ $setting->key }}[value]" accept="image/*" class="form-control" value="{{ json_decode($setting->value) }}">
                                <input type="hidden" name="{{ $setting->key }}[data_type]" value="{{ $setting->data_type }}">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    @else
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                                <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}[value]" class="form-control" value="{{ json_decode($setting->value) }}">
                                <input type="hidden" name="{{ $setting->key }}[data_type]" value="{{ $setting->data_type }}">
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    @endif
                @endif
            @endforeach

            <div class="form-group col-md-4" style="margin-top:30px">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
@endsection