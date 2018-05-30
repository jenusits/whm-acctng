<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct() {
        // Resrict this controller to Authenticated users only
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(! \PermissionChecker::is_permitted('view bank'))
            return \PermissionChecker::display();

        $banks = Bank::all();
        return view('bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bank.create');
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
        if(! \PermissionChecker::is_permitted('create bank'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required|numeric'
        ]);

        // dd($request->description);
        $bank = new Bank;
        $bank->name = $request->name;
        $bank->balance = $request->balance;
        $bank->description = $request->description;
        $bank->save();

        session()->flash('message','Bank has been added.');
        return redirect(route('bank.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
        return redirect(route('bank.edit', $bank->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
        if(! \PermissionChecker::is_permitted('update bank'))
            return \PermissionChecker::display();

        return view('bank.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
        if(! \PermissionChecker::is_permitted('create bank'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'name' => 'required',
            'balance' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        $bank->name = $request->name;
        $bank->balance = $request->balance;
        $bank->description = $request->description;
        $bank->save();

        session()->flash('message','Bank was updated.');
        return redirect(route('bank.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
        if(! \PermissionChecker::is_permitted('delete bank'))
            return \PermissionChecker::display();

        $bank->delete();

        return redirect(route('bank.index'))->with('message','Bank has been deleted');
    }
}
