<?php

namespace App;

class Expenses extends Model
{
    //
    public function expensesMeta() {
        return $this->hasMany(ExpensesMeta::class);
    }
    
    public static function get_meta($expense_id) {
        return self::find($expense_id);
    }
}
