<?php

namespace App;

class Attachments extends Model
{
    //
    public function expense() {
        return $this->belongsTo(User::class);
    }
}
