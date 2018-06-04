<?php

namespace App\Http\Controllers\Employees;

use App\Employees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employees = Employees::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Checks if an Employee ID is existing
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        //
        $this->validate($request, [
            'employee_id' => 'required'
        ]);
        $emp = Employees::where('employee_id', $request['employee_id'])->first();

        if ($emp == null)
            session()->flash('warning', 'Employee ID "' . $request['employee_id'] . '" doesn\'t exists.');
        else {
            session()->flash('message', 'Employee ID ' . $request['employee_id'] . ' exists.');
            session()->flash('employee', $emp);
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('employees.create');
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
        // dd($request);
        $this->validate($request, [
            'employee_id' => 'required|unique:employees',
        ]);

        $emp = new Employees;
        $emp->employee_id = $request['employee_id'];
        $emp->save();
        $emp_id = $emp->id;

        $metas = $request->except(['_method', '_token', 'employee_id']);
        foreach($metas as $key => $meta) {
            $emp_meta = new \App\EmployeeMeta;
            $emp_meta->employee_id = $emp_id;
            $emp_meta->meta_key = $key;
            $emp_meta->meta_value = json_encode($meta);
            $emp_meta->save();
        }
        
        $emp_meta = new \App\EmployeeMeta;
        $emp_meta->employee_id = $emp_id;
        $emp_meta->meta_key = 'login_status';
        $emp_meta->meta_value = json_encode(0);
        $emp_meta->save();

        return redirect()->route('employees.index')->with('message', 'Successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function show(Employees $employee)
    {
        //

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function edit(Employees $employee)
    {
        //
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employees $employee)
    {
        //
        $this->validate($request, [
            'employee_id' => [
                'required',
                Rule::unique('employees')->ignore($employee->id),
            ],
        ]);

        $emp = $employee;
        $emp->employee_id = $request['employee_id'];
        $emp->save();
        $emp_id = $emp->id;

        $metas = $request->except(['_method', '_token', 'employee_id']);
        foreach($metas as $key => $meta) {
            $emp_meta = \App\EmployeeMeta::where('employee_id', $emp_id)->where('meta_key', $key)->first();
            if (! $emp_meta)
                continue;
            $emp_meta->meta_value = json_encode($meta);
            $emp_meta->save();
        }

        return redirect()->route('employees.index')->with('message', 'Successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employees  $employees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employees $employee)
    {
        //
        $employee->delete();
        return redirect()->route('employees.index')->with('message', 'Successfully deleted.');
    }
}
