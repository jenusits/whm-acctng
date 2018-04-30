@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Permissions to this Role</h2><br  />
        @include('layouts.error-and-messages')
        @if(sizeof($permissions) > 1)
            <form method="POST" action="{{route('roles.update', $role->id)}}">
                @csrf
                @method('put')
                <div class="">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" disabled name="name" value="{{ $role->name }}">
                    </div>
                    <div class="form-group">
                        <h3>Permissions</h3>
                        @foreach($permissions as $key => $permission)
                            <div>
                                @if(\App\Checker::is_role_permitted($role->id, $permission->id))
                                    <input type="checkbox" checked class="" name="permissions[]" id="{{ $permission->id }}" value="{{ $permission->id }}">
                                @else
                                    <input type="checkbox" class="" name="permissions[]" id="{{ $permission->id }}" value="{{ $permission->id }}">
                                @endif
                                <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group" style="margin-top:30px">
                        <button type="submit" class="btn btn-success">Save</button>
        
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </form>
        @endif
    </div>
@endsection