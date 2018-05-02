@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            @if(Auth::check())
                <a class="btn btn-success" href="{{ route('users.create') }}">Add New User</a>
            @endif
        </div>
    </div>
        <hr>
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-success table-responsive">
                <div class="panel-heading">Users</div>
                @include('layouts.error-and-messages')
                @if(Auth::check())
                    <!-- Table -->
                    <table class="table table-sm table-transparent table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <?php
                                        $current_role = $user->roles->pluck('name');
                                        if (isset($current_role[0]))
                                            $current_role = $current_role[0];
                                        else
                                            $current_role = '';
                                    ?>
                                    {{ $current_role }}
                                </td>
                                <td>
                                    <a style="margin: 5px; font-size: 10px" href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>    
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
</div>

@endsection