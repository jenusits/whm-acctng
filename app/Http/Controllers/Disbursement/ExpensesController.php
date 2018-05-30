<?php

namespace App\Http\Controllers\Disbursement;

use App\Expenses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
// use App\Request_funds;
use App\Charts;

class ExpensesController extends Controller
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
        if(! \PermissionChecker::is_permitted('view expenses'))
            return \PermissionChecker::display();

        $expenses = Expenses::orderby('id','desc')->get();

        if (null !== request('approved'))
            $expenses = Expenses::orderby('id','desc')->where('approved', '=', 1)->get();
        elseif (null !== request('pending'))
            $expenses = Expenses::orderby('id','desc')->where('approved', '=', 0)->get();
        elseif (null !== request('notapproved'))
            $expenses = Expenses::orderby('id','desc')->where('approved', '=', 2)->get();
        
        $categories = Charts::all();
        return view('disbursement.expenses.expense.index', compact('expenses', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \PermissionChecker::is_permitted('create expenses'))
            return \PermissionChecker::display();

        $categories = Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::all();
        return view('disbursement.expenses.expense.create', compact('categories', 'banks', 'payment_methods', 'payees'));
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
        $this->validate($request, [
            'attachments.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $files = request()->has('attachments') ? request('attachments') : false;

        if(! \PermissionChecker::is_permitted('create expenses'))
            return \PermissionChecker::display();

        $expense = new Expenses();
        $expense->author = Auth::id();
        $expense->memo = request('memo');
        $expense->save();
        $ref_number = $expense->id;
        
        $expenses = request('request_funds'); 
        $particulars = $expenses;
        foreach ($particulars as $key => $p) {
            $particulars[$key]['expenses_id'] = $ref_number;
            $particulars[$key]['rfindex'] += 1;
        }
        \App\ExpensesDetails::insert($particulars);

        $metas['bank_credit_account'] = request('bank_credit_account');
        $metas['payment_date'] = \Carbon\Carbon::parse(request('payment_date'))->format('Y-m-d H:i:s');
        $metas['payment_method'] = request('payment_method');
        $metas['payee'] = request('payee');
        $metas['type'] = 'expense';
        foreach ($metas as $key => $meta) {
            $expenses_meta = new \App\ExpensesMeta;
            $expenses_meta->reference_id = $ref_number;
            $expenses_meta->meta_key = $key;
            $expenses_meta->meta_value = json_encode($meta);
            $expenses_meta->save();
        }

        if ($files) {
            foreach($files as $key => $file) {
                $file_name = \Storage::disk('attachments')->put('expenses/' . $ref_number, $file);
                $att = new \App\Attachments;
                $att->filename = $file_name;
                $att->original_filename = $file->getClientOriginalName();
                $att->attached_to = 'expenses';
                $att->reference_id = $ref_number;
                $att->save();
            }
        }

        session()->flash('message', 'Expense was saved');
        return redirect(route('expenses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expense)
    {
        //
        if(! \PermissionChecker::is_permitted('view expenses'))
            return \PermissionChecker::display();

        $charts = new Charts;
        $expm = Expenses::findOrFail($expense->id);
        $particulars = $expm->particulars()->orderby('rfindex', 'asc')->get();
        $user = \App\User::find($expm->author);

        $current_user = \App\User::find(Auth::id());
        $attachments = $expm->attachments()->orderby('id', 'desc')->get();
        $expense_meta = $expm->getExpenseMeta();
        
        if ($expense->getExpenseMeta('type') != 'expense')
            abort(404);

        return view('disbursement.expenses.expense.show', compact('expense', 'charts', 'particulars', 'user', 'current_user', 'attachments', 'expense_meta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expense)
    {
        //
        if(! \PermissionChecker::is_permitted('update expenses'))
            return \PermissionChecker::display();

        $charts = Charts::all();
        $categories = Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::all();
        $expense_meta = $expense->getExpenseMeta();

        if ($expense->getExpenseMeta('type') != 'expense')
            abort(404);

        return view('disbursement.expenses.expense.edit', compact('expense', 'charts', 'categories', 'banks', 'payment_methods', 'payees', 'expense_meta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenses $expenses, $id)
    {
        //
        if(! \PermissionChecker::is_permitted('update expenses'))
            return \PermissionChecker::display();

        if (null !== $request->get('approved')) {
            $expenses = Expenses::find($id);
            $bool = "approved";
            if ($request->get('approved') == 2)
                $bool = "disapproved";

            $expenses->approved = $request->get('approved');
            $expenses->approved_by = Auth::id();
            $expenses->approved_on = \Carbon\Carbon::now();
            $expenses->save();
            session()->flash("message", "Expense has been $bool.");
        } else {
            $ids = [];
            $expenses = Expenses::find($id);
            $expenses->memo = request('memo');
            $expenses->save();

            $metas['payee'] = request('payee');
            $metas['bank_credit_account'] = request('bank_credit_account');
            $metas['payment_method'] = request('payment_method');
            $metas['payment_date'] = \Carbon\Carbon::parse(request('payment_date'))->format('Y-m-d H:i:s');
            
            foreach ($metas as $key => $meta) {
                $expenses_meta = \App\ExpensesMeta::where('reference_id', '=', $expenses->id)->where('meta_key', '=', $key)->first();
                $expenses_meta->meta_value = json_encode($meta);
                $expenses_meta->save();
            }
                        
            $expns = request('request_funds');
            foreach ($expns as $key => $expense) {
                if (isset($expense['id'])) {
                    array_push($ids, $expense['id']);
                    $update = \App\ExpensesDetails::find($expense['id']);
                    $update->rfindex = $expense['rfindex'];
                    $update->particulars = $expense['particulars'];
                    $update->amount = $expense['amount'];
                    $update->category = $expense['category'];
                    $update->save();
                } else {
                    unset($expense['id']);
                    $new_expense = new \App\ExpensesDetails;
                    $new_expense->rfindex = $expense['rfindex'];
                    $new_expense->particulars = $expense['particulars'];
                    $new_expense->amount = $expense['amount'];
                    $new_expense->category = $expense['category'];
                    $new_expense['expenses_id'] = $id;
                    $new_expense->save();
                    
                    array_push($ids, $new_expense->id);
                }
            }
            \App\ExpensesDetails::whereNotIn('id', $ids)->where('expenses_id', $id)->delete();
            session()->flash('message','Expense has been updated successfully!');
            return redirect(route('expenses.show', $id));
        }
        return redirect(route('expenses.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expenses, $id)
    {
        //
        if(! \PermissionChecker::is_permitted('delete expenses'))
            return \PermissionChecker::display();

        $expense = $expenses::find($id);
        $expense->delete();
        
        $expense_meta = \App\ExpensesMeta::where('reference_id', $id);
        $expense_meta->delete();
        
        $particulars = \App\ExpensesDetails::where('expenses_id', $id);
        $particulars->delete();

        $attachments = \App\Attachments::where('reference_id', $id)->where('attached_to', '=', 'expenses')->get();
        foreach ($attachments as $key => $attachment) {
            if (file_exists(public_path('uploads/attachments/' . $attachment->filename)))
                unlink(public_path('uploads/attachments/' . $attachment->filename));
        }
        return redirect(route('expenses.index'))->with('message','Expense has been deleted');
    }

    
    /**
     * Display the specified resource.
     *
     * Displays a page to print
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id) {

        if(! \PermissionChecker::is_permitted('print expense'))
            return \PermissionChecker::display();

        $expense = \App\Expenses::findOrFail($id);
        $particulars = $expense->particulars;

        if ($expense->getExpenseMeta('type') != 'expense')
            abort(404);

        return view('layouts.vouchers.expense-voucher', compact('expense', 'particulars'));
    }
}
