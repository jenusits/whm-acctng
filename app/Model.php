<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    //
    protected $fillable = [
        'account_name',
        'particulars',
        'amount',
        'category',
        'author',
        'approved'
    ];
}
