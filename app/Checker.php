<?php

namespace App;

use App\Model;

class Checker extends Model
{
    //
    public static function is_permitted($permission_name) {
        $user_id = \Auth::id();
        $user = \App\User::find($user_id);
        return $user->hasPermissionTo($permission_name);
    }

    public static function display() {
        return view('layouts.not-allowed');
    }
}
