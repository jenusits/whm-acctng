<?php

namespace App\Http\Controllers\TimeLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TimeLog;

class TimeLogController extends Controller
{
    //
    public function login(Request $request) {
        $this->validate($request, [
            'employee_id' => 'required',
            'tz' => 'required'
        ]);

        $emp = \App\Employees::where('employee_id', $request['employee_id'])->first();

        if ($emp == null)
            session()->flash('warning', 'Employee ID "' . $request['employee_id'] . '" doesn\'t exists.');
        else {
            $tl = new TimeLog;
            $tl->employee_id = $emp->id;
            $tl->login = \Carbon\Carbon::now();
            $tl->save();
            $emp->update_meta('login_status', 1);
            session()->flash('timezone', request('tz'));
            session()->flash('employee', $emp);
        }

        return redirect()->back();
    }

    public function logoff(Request $request) {
        $this->validate($request, [
            'employee_id' => 'required',
            'tz' => 'required'
        ]);

        $emp = \App\Employees::where('employee_id', $request['employee_id'])->first();

        if ($emp == null)
            session()->flash('warning', 'Employee ID "' . $request['employee_id'] . '" doesn\'t exists.');
        else {
            $tl = TimeLog::where('employee_id', $emp->id)->orderby('id', 'desc')->first();
            $tl->logoff = \Carbon\Carbon::now();
            $tl->save();
            $emp->update_meta('login_status', 0);
            session()->flash('timezone', request('tz'));
            session()->flash('employee', $emp);
        }

        return redirect()->back();
    }
}
