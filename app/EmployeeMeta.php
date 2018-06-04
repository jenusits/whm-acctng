<?php

namespace App;

class EmployeeMeta extends Model
{
    //
    public function employee() {
        return $this->belongsTo(Employees::class, 'employee_id', 'id')->first();
    }
}
