@extends('layouts.app')

@section('content')

<div >
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            @if(Auth::check())
                <a class="btn btn-success" href="{{ route('admin-settings.create') }}">Add New Option</a>
            @endif
        </div>
    </div>
        <hr>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-success table-responsive">
                <div class="panel-heading">Options</div>
                @include('layouts.error-and-messages')
                @if(Auth::check())
                    <!-- Table -->
                    <table class="table table-sm table-transparent table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Data Type</th>
                            <th>Display on Settings page</th>  
                            <th>Actions</th>                         
                        </tr>
                        @foreach($settings as $key => $setting)
                            <tr>
                                <td>{{ $setting->id }}</td>
                                <td><a href="{{ route('admin-settings.edit', $setting->id) }}">{{ $setting->key }}</a></td>
                                <td>{{ json_decode($setting->value) }}</td>
                                <td>{{ $setting->data_type }}</td>
                                <td>{{ $setting->show ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a style="margin: 5px; font-size: 10px" href="{{route('admin-settings.edit', $setting->id)}}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <form id="form-{{ $setting->id }}" action="{{route('admin-settings.destroy', $setting->id)}}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        {{-- <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button> --}}
                                        <button @click="focusedID = {{ $setting->id }}; chart_name = '{{ $setting->key }}';" style="margin: 5px; font-size: 10px" type="button" class="btn btn-danger" data-toggle="modal" data-target="#app-modal"><i class="fas fa-trash"></i></button> 
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                        </tr>
                    </table>
                @endif
            </div>
                @if(Auth::guest())
                    <a href="/login" class="btn btn-info"> You need to login to see the list 😜😜 >></a>
                @endif
        </div>
    </div>

    <b-modal id="app-modal" @close="focusedID = 0" @confirm="deleteChart" title="Confirm Action">
        Are you sure you want to delete this Option named <b>@{{ chart_name }}</b>?
    </b-modal>
</div>

@endsection