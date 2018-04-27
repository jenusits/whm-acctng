<?php

namespace App;

class Request_funds extends Model
{
    //
    public function particulars() {
        return $this->hasMany(Request_funds_meta::class);
    }
}
