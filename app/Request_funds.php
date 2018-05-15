<?php

namespace App;

class Request_funds extends Model
{
    //
    public function particulars() {
        return $this->hasMany(Request_funds_meta::class)->orderBy('rfindex');
    }

    public static function getPendingRequests() {
        return self::where('approved', '=', 0)->get();
    }

    public static function getApproveRequests() {
        return self::where('approved', '=', 1)->get();
    }

    public static function getNotApproveRequests() {
        return self::where('approved', '=', 2)->get();
    }

}
