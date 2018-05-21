<?php

namespace App\Http\Controllers;

use App\Payee;
use Illuminate\Http\Request;

class PayeeController extends Controller
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
        if(! \App\Checker::is_permitted('view payee'))
            return \App\Checker::display();

        $payees = \App\Payee::all();
        return view('payee.index', compact('payees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \App\Checker::is_permitted('create payee'))
            return \App\Checker::display();

        return view('payee.create');
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
        if(! \App\Checker::is_permitted('create payee'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required'
        ]);

        $payee = new Payee;
        $payee->name = $request['name'];
        $payee->description = $request['description'];
        $payee->category = $request['category'];
        $payee->save();

        return redirect(route('payee.index'))->with('message','Payee has been saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payee  $payee
     * @return \Illuminate\Http\Response
     */
    public function show(Payee $payee)
    {
        //
        if(! \App\Checker::is_permitted('view payee'))
            return \App\Checker::display();
        
        return view('payee.show', compact('payee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payee  $payee
     * @return \Illuminate\Http\Response
     */
    public function edit(Payee $payee)
    {
        //
        if(! \App\Checker::is_permitted('update payee'))
            return \App\Checker::display();
        
        return view('payee.edit', compact('payee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payee  $payee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payee $payee)
    {
        //
        if(! \App\Checker::is_permitted('update payee'))
            return \App\Checker::display();
        
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required'
        ]);
        
        $payee->name = $request['name'];
        $payee->description = $request['description'];
        $payee->category = $request['category'];
        $payee->save();
            
        return redirect(route('payee.index'))->with('message','Payee has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payee  $payee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payee $payee)
    {
        //
        if(! \App\Checker::is_permitted('delete payee'))
            return \App\Checker::display();

            
        $payee->delete();

        return redirect(route('payee.index'))->with('message','Payee has been deleted');
    }
}
