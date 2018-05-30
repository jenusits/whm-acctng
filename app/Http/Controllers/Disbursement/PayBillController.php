<?php

namespace App\Http\Controllers\Disbursement;

use App\PayBill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Request_funds;
use App\Charts;
use App\Expenses;
class PayBillController extends Controller
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
        if(! \PermissionChecker::is_permitted('view bill'))
            return \PermissionChecker::display();
        $expenses = \App\Expenses::getExpenses('bill');

        return view('disbursement.expenses.pay-bills.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  \App\PayBill  $payBill
     * @return \Illuminate\Http\Response
     */
    public function show(PayBill $payBill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayBill  $payBill
     * @return \Illuminate\Http\Response
     */
    public function edit(PayBill $payBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayBill  $payBill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayBill $payBill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayBill  $payBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayBill $payBill)
    {
        //
    }
}
