<?php

namespace App\Http\Controllers\Disbursement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Request_funds;
use App\Charts;
use App\Expenses;

class BillController extends Controller
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
        return view('disbursement.expenses.bill.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \PermissionChecker::is_permitted('create bill'))
            return \PermissionChecker::display();

        $categories = \App\Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::where('category', '=', 'supplier')->get();
        return view('disbursement.expenses.bill.create', compact('categories', 'banks', 'payment_methods', 'payees'));
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

        if(! \PermissionChecker::is_permitted('create bill'))
            return \PermissionChecker::display();

        $expense = new \App\Expenses();
        $expense->author = \Auth::id();
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

        $metas['mailing_address'] = request('mailing_address');
        $metas['bill_date'] = \Carbon\Carbon::parse(request('bill_date'))->format('Y-m-d H:i:s');
        $metas['terms'] = request('terms');
        $metas['due_date'] = \Carbon\Carbon::parse(request('due_date'))->format('Y-m-d H:i:s');
        $metas['supplier'] = request('payee');
        $metas['type'] = 'bill';

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

        session()->flash('message', 'Bill was saved');
        return redirect(route('expenses.index'));
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
        if(! \PermissionChecker::is_permitted('view bill'))
            return \PermissionChecker::display();

        $charts = new Charts;
        $expense = Expenses::findOrFail($id);
        $particulars = $expense->particulars()->orderby('rfindex', 'asc')->get();
        $user = \App\User::find($expense->author);

        $current_user = \App\User::find(Auth::id());
        $attachments = $expense->attachments()->orderby('id', 'desc')->get();
        $expense_meta = $expense->getExpenseMeta();
        
        if ($expense->getExpenseMeta('type') != 'bill')
            abort(404);

        return view('disbursement.expenses.bill.show', compact('expense', 'charts', 'particulars', 'user', 'current_user', 'attachments', 'expense_meta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if(! \PermissionChecker::is_permitted('update bill'))
            return \PermissionChecker::display();

        $charts = Charts::all();
        $categories = Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::all();
        $expense = Expenses::findOrFail($id);
        $expense_meta = $expense->getExpenseMeta();

        
        if ($expense->getExpenseMeta('type') != 'bill')
            abort(404);

        return view('disbursement.expenses.bill.edit', compact('expense', 'charts', 'categories', 'banks', 'payment_methods', 'payees', 'expense_meta'));
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
        if(! \PermissionChecker::is_permitted('update bill'))
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
            session()->flash("message", "Bill has been $bool.");
        } else {
            $ids = [];
            $expenses = Expenses::find($id);
            $expenses->memo = request('memo');
            $expenses->save();

            $metas['supplier'] = request('payee');
            $metas['terms'] = request('terms');
            $metas['bill_date'] = \Carbon\Carbon::parse(request('bill_date'))->format('Y-m-d H:i:s');
            $metas['due_date'] = \Carbon\Carbon::parse(request('due_date'))->format('Y-m-d H:i:s');
            
            foreach ($metas as $key => $meta) {
                $expenses_meta = \App\ExpensesMeta::where('reference_id', '=', $id)->where('meta_key', '=', $key)->first();
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
            session()->flash('message','Bill has been updated successfully!');
            return redirect(route('bill.show', $id));
        }
        return redirect(route('bill.show', $id));
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
        if(! \PermissionChecker::is_permitted('delete bill'))
            return \PermissionChecker::display();

        $expense = Expenses::find($id);
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
        return redirect(route('expenses.index'))->with('message','Bill has been deleted');
    }
}
