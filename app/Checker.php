<?php

namespace App;

use App\Model;

use Spatie\Permission\Models\Role;

class Checker extends Model
{
    //
    public static function is_permitted($permission) {
        $user_id = \Auth::id();
        $user = \App\User::find($user_id);
        return $user->hasPermissionTo($permission);
    }

    public static function is_role_permitted($role_id, $permission) {
        $role = Role::find($role_id);
        return $role->hasPermissionTo($permission);
    }

    public static function display() {
        return view('layouts.not-allowed');
    }
}
