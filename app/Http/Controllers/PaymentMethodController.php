<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
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
        if(! \App\Checker::is_permitted('view payment_method'))
            return \App\Checker::display();

        $payment_methods = PaymentMethod::all();
        return view('payment_method.index', compact('payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \App\Checker::is_permitted('create payment_method'))
            return \App\Checker::display();

        return view('payment_method.create');
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
        if(! \App\Checker::is_permitted('create payment_method'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required'
        ]);

        // dd($request->description);
        $payment_method = new PaymentMethod;
        $payment_method->name = $request->name;
        $payment_method->description = $request->description;
        $payment_method->save();

        session()->flash('message','Payment Method has been added.');
        return redirect(route('payment_method.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        //
        if(! \App\Checker::is_permitted('update payment_method'))
            return \App\Checker::display();

        $payment_method = $paymentMethod;
        return view('payment_method.edit', compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        //
        if(! \App\Checker::is_permitted('create payment_method'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required'
        ]);

        $paymentMethod->name = $request->name;
        $paymentMethod->description = $request->description;
        $paymentMethod->save();

        session()->flash('message','Payment Method was updated.');
        return redirect(route('payment_method.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
        if(! \App\Checker::is_permitted('delete payment_method'))
            return \App\Checker::display();

        $paymentMethod->delete();

        return redirect(route('payment_method.index'))->with('message','Payment Method has been deleted');
    }
}
