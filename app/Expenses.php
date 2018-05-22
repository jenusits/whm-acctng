<?php

namespace App;

class Expenses extends Model
{
    //
    public function particulars() {
        return $this->hasMany(ExpensesDetails::class)->orderBy('rfindex');
    }

    public function attachments() {
        $attachments = $this->hasMany(Attachments::class, 'reference_id');
        return $attachments->where('attached_to', '=', 'expenses');
    }

    public function expensesMeta() {
        return $this->hasMany(ExpensesMeta::class);
    }
    
    public static function getExpenses($type = 'expenses') {
        return self::where('type', '=', $type);
    }

    public  function getExpenseMeta($meta_key = '') {
        if ($meta_key == '') {
            $res = $this->hasMany(ExpensesMeta::class, 'reference_id')->get();
            $formatted_arr = [];
            foreach ($res as $key => $value) {
                $formatted_arr[$value->meta_key] = json_decode($value->meta_value); 
            }
            return $formatted_arr;
        } else {
            $res = $this->hasMany(ExpensesMeta::class, 'reference_id')->where('meta_key', '=', $meta_key)->first();
            if ($res)
                return json_decode($res->meta_value);
            else
                return false;
        }
    }
}
