<?php

namespace App\Http\Controllers\Disbursement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Charts;
use App\Expenses;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(! \PermissionChecker::is_permitted('view purchase_order'))
            return \PermissionChecker::display();
        $expenses = \App\Expenses::getExpenses('purchase_order');
        return view('disbursement.expenses.purchase-order.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \PermissionChecker::is_permitted('create purchase_order'))
            return \PermissionChecker::display();

        $categories = \App\Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::where('category', '=', 'supplier')->get();
        $customers = \App\Payee::where('category', '=', 'customer')->get();
        return view('disbursement.expenses.purchase-order.create', compact('categories', 'banks', 'payment_methods', 'payees', 'customers'));
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

        if(! \PermissionChecker::is_permitted('create purchase_order'))
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

        $metas['supplier'] = request('payee');
        $metas['email'] = request('email');
        $metas['mailing_address'] = request('mailing_address');
        $metas['ship_to'] = request('customer');
        $metas['mailing_address'] = request('mailing_address');
        $metas['purchase_order_date'] = \Carbon\Carbon::parse(request('purchase_order_date'))->format('Y-m-d H:i:s');
        $metas['shipping_address'] = request('shipping_address');
        $metas['ship_via'] = request('ship_via');
        $metas['purchase_order_status'] = request('purchase_order_status') == 1 ? 1 : 0;

        $metas['message_to_supplier'] = request('message_to_supplier');

        $metas['type'] = 'purchase_order';

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

        session()->flash('message', 'purchase_order was saved');
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
        if(! \PermissionChecker::is_permitted('view purchase_order'))
            return \PermissionChecker::display();

        $charts = new Charts;
        $expense = Expenses::findOrFail($id);
        $particulars = $expense->particulars()->orderby('rfindex', 'asc')->get();
        $user = \App\User::find($expense->author);

        $current_user = \App\User::find(Auth::id());
        $attachments = $expense->attachments()->orderby('id', 'desc')->get();
        $expense_meta = $expense->getExpenseMeta();
        
        if ($expense->getExpenseMeta('type') != 'purchase_order')
            abort(404);

        return view('disbursement.expenses.purchase-order.show', compact('expense', 'charts', 'particulars', 'user', 'current_user', 'attachments', 'expense_meta'));
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
        if(! \PermissionChecker::is_permitted('update purchase_order'))
            return \PermissionChecker::display();

        $charts = Charts::all();
        $categories = Charts::all();
        $banks = \App\Bank::all();
        $payment_methods = \App\PaymentMethod::all();
        $payees = \App\Payee::where('category', '=', 'supplier')->get();
        $expense = Expenses::findOrFail($id);
        $expense_meta = $expense->getExpenseMeta();
        $customers = \App\Payee::where('category', '=', 'customer')->get();
        
        if ($expense->getExpenseMeta('type') != 'purchase_order')
            abort(404);

        return view('disbursement.expenses.purchase-order.edit', compact('expense', 'charts', 'categories', 'banks', 'payment_methods', 'payees', 'expense_meta', 'customers'));
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
        if(! \PermissionChecker::is_permitted('update purchase_order'))
            return \PermissionChecker::display();

        if (null !== $request->get('approved')) {
            $expenses = Expenses::findOrFail($id);
            $bool = "approved";
            if ($request->get('approved') == 2)
                $bool = "disapproved";

            $expenses->approved = $request->get('approved');
            $expenses->approved_by = Auth::id();
            $expenses->approved_on = \Carbon\Carbon::now();
            $expenses->save();
            session()->flash("message", "Purchase Order has been $bool.");
        } else {
            $ids = [];
            $expenses = Expenses::findOrFail($id);
            $expenses->memo = request('memo');
            $expenses->save();

            $metas['supplier'] = request('payee');
            $metas['email'] = request('email');
            $metas['mailing_address'] = request('mailing_address');
            $metas['ship_to'] = request('ship_to');
            $metas['mailing_address'] = request('mailing_address');
            $metas['purchase_order_date'] = \Carbon\Carbon::parse(request('purchase_order_date'))->format('Y-m-d H:i:s');
            $metas['shipping_address'] = request('shipping_address');
            $metas['ship_via'] = request('ship_via');
            $metas['purchase_order_status'] = request('purchase_order_status') == 1 ? 1 : 0;
    
            $metas['message_to_supplier'] = request('message_to_supplier');
            
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
            session()->flash('message','Purchase Oorder has been updated successfully!');
            return redirect(route('purchase_order.show', $id));
        }
        return redirect(route('purchase_order.show', $id));
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
        if(! \PermissionChecker::is_permitted('delete purchase_order'))
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
        return redirect(route('expenses.index'))->with('message', 'Purchase Order has been deleted');
    }
}
