<?php

namespace App;

class ExpensesDetails extends Model
{
    //
    public function expense() {
        return $this->belongsTo(Expenses::class, 'expenses_id', 'id')->first();
    }
}
