<?php

namespace App;

class Expenses extends Model
{
    //
    public function particulars() {
        return $this->hasMany(ExpensesMeta::class)->orderBy('rfindex');
    }

    public function attachments() {
        return $this->hasMany(Attachments::class, 'reference_id');
    }

    public function expensesMeta() {
        return $this->hasMany(ExpensesMeta::class);
    }
    
    public static function get_meta($expense_id) {
        return self::find($expense_id);
    }
}
