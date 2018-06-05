<?php

namespace App\Http\Controllers;

use App\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(! \PermissionChecker::is_permitted('view payroll'))
            return \PermissionChecker::display();

        $employees = \App\Employees::all();
        return view('payroll.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
        //
        if(! \PermissionChecker::is_permitted('create payroll'))
            return \PermissionChecker::display();

        $employee = \App\Employees::findOrFail($id);
        // $payrolls = $employee->payrolls();

        return view('payroll.create', compact('employee'));
    }

    public function store(Request $request)
    {
        //
        if(! \PermissionChecker::is_permitted('create payroll'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'employee_id' => 'required',
            'hours' => 'required',
            'rate' => 'required',
        ]);

        $p = new Payroll;
        $p->employee_id = request('employee_id');
        $p->over_time = null !== request('over_time') ? true : false;
        $p->hours = request('hours');
        $p->rate = request('rate');
        $gross = request('hours') * request('rate');
        $p->gross = $gross;
        $p->save();

        return redirect()->route('payroll.show', request('employee_id'))->with('message', 'Payroll created');
    }

    public function show($id)
    {
        //
        if(! \PermissionChecker::is_permitted('view payroll'))
            return \PermissionChecker::display();

        $employee = \App\Employees::findOrFail($id);
        $payrolls = $employee->payrolls();

        return view('payroll.show', compact('employee', 'payrolls'));
    }

    public function edit($payroll = 0)
    {
        //
        if(! \PermissionChecker::is_permitted('update payroll'))
            return \PermissionChecker::display();

        $payroll = Payroll::findOrFail($payroll);
        $employee = $payroll->employee();//\App\Employees::findOrFail($payroll->employee_id);

        return view('payroll.edit', compact('employee', 'payroll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
        if(! \PermissionChecker::is_permitted('update payroll'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'employee_id' => 'required',
            'hours' => 'required',
            'rate' => 'required',
        ]);

        $p = $payroll;
        $p->employee_id = request('employee_id');
        $p->over_time = null !== request('over_time') ? true : false;
        $p->hours = number_format((float) request('hours'), 2, '.', '');;
        $p->rate = number_format((float) request('rate'), 2, '.', '');;
        $gross = $p->hours * $p->rate;
        $p->gross = $gross;
        $p->save();

        return redirect()->route('payroll.show', request('employee_id'))->with('message', 'Payroll created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
        if(! \PermissionChecker::is_permitted('delete payroll'))
            return \PermissionChecker::display();

        $payroll->delete();
        return redirect()->back()->with('message', 'Payroll was deleted');
    }
}
