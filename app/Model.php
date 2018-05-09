<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Spatie\Permission\Traits\HasRoles;

class Model extends Eloquent
{
    //
    use HasRoles;

    protected $guard_name = 'web'; 

    protected $fillable = [
        'account_name',
        'particulars',
        'amount',
        'category',
        'author',
        'approved',
        'name',
    ];
}
