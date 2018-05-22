@extends('layouts.app')

@section('content')

<div >
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            @if(Auth::check())
                <a class="btn btn-success" href="{{ route('permissions.create') }}">Add New Permission</a>
            @endif
        </div>
    </div>
        <hr>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-success table-responsive">
                <div class="panel-heading">Permissions</div>
                @include('layouts.error-and-messages')
                @if(Auth::check())
                    <!-- Table -->
                    <table class="table table-sm table-transparent table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Permission Name</th>
                        </tr>
                        @foreach($permissions as $key => $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td>{{ $permission->name }}</td>
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
</div>

@endsection