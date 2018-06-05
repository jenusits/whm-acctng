<?php

namespace App;

class Employees extends Model
{
    //
    public function metas() {
        return $this->hasMany(EmployeeMeta::class);
    }

    public function timelogs() {
        return $this->hasMany(TimeLog::class, 'employee_id')->orderby('id', 'desc');
    }

    public function last_timelog() {
        return $this->timelogs()->orderby('id', 'desc')->first();        
    }

    public function payrolls() {
        return $this->hasMany(Payroll::class, 'employee_id')->orderby('id', 'desc');
    }

    public function meta($meta_key = '') {
        if ($meta_key == '') {
            $res = $this->hasMany(EmployeeMeta::class, 'employee_id')->get();
            $formatted_arr = [];
            foreach ($res as $key => $value) {
                $formatted_arr[$value->meta_key] = json_decode($value->meta_value); 
            }
            return $formatted_arr;
        } else {
            $res = $this->hasMany(EmployeeMeta::class, 'employee_id')->where('meta_key', '=', $meta_key)->first();
            if ($res)
                return json_decode($res->meta_value);
            else
                return false;
        }
    }

    public function update_meta($meta_key, $meta_value = '') {
        $res = $this->hasMany(EmployeeMeta::class, 'employee_id')->where('meta_key', '=', $meta_key)->first();
        if ($res) {
            $res->meta_value = json_encode($meta_value);
            $res->save();
            return true;
        } else
            return false;
    }
}
