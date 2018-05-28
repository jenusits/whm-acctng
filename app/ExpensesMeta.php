<?php

namespace App;

class ExpensesMeta extends Model
{
    //
    public function expense() {
        return $this->belongsTo(Expenses::class, 'reference_id', 'id')->first();
    }
}
