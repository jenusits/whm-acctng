<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if(! \App\Checker::is_permitted('create bank'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required'
        ]);

        Bank::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

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
        if(! \App\Checker::is_permitted('update bank'))
            return \App\Checker::display();

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
        if(! \App\Checker::is_permitted('create bank'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required'
        ]);

        $bank->name = $request->name;
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
        if(! \App\Checker::is_permitted('delete bank'))
            return \App\Checker::display();

        $bank->delete();

        return redirect(route('bank.index'))->with('message','Bank has been deleted');
    }
}
