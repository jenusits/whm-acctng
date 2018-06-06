<?php

namespace App\Http\Controllers\TimeLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\TimeLog;

class TimeLogApi extends Controller
{
    //
    public function login(Request $request) {
        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        $emp = \App\Employees::where('employee_id', $request['employee_id'])->first();

        if ($emp == null) {
            session()->flash('warning', 'Employee ID "' . $request['employee_id'] . '" doesn\'t exists.');
            return response()->json(['message' => 'Employee ID doesn\'t exists.']);
        } else {
            $tl = new TimeLog;
            $tl->employee_id = $emp->id;
            $tl->login = \Carbon\Carbon::now();
            $tl->save();
            $emp->update_meta('login_status', 1);
            session()->flash('timezone', request('tz'));
            session()->flash('employee', $emp);
            
            return response()->json(['message' => 'Succcessfully logged in']);
        }

    }

    public function logoff(Request $request) {
        $this->validate($request, [
            'employee_id' => 'required'
        ]);

        $emp = \App\Employees::where('employee_id', $request['employee_id'])->first();

        if ($emp == null) {
            session()->flash('warning', 'Employee ID "' . $request['employee_id'] . '" doesn\'t exists.');
            return response()->json(['message' => 'Employee ID doesn\'t exists.']);
        } else {
            // $tl = TimeLog::where('employee_id', $emp->id)->orderby('id', 'desc')->first();
            $tl = $emp->last_timelog();
            $tl->logoff = \Carbon\Carbon::now();
            $tl->save();
            $emp->update_meta('login_status', 0);
            session()->flash('timezone', request('tz'));
            session()->flash('employee', $emp);

            return response()->json(['message' => 'Successfully logged off']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
