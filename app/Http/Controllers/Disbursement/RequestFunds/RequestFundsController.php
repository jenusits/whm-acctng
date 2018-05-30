<?php

namespace App\Http\Controllers\Disbursement\RequestFunds;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

use App\Request_funds;
use App\Charts;

class RequestFundsController extends Controller
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
        if(! \PermissionChecker::is_permitted('view request_funds'))
            return \PermissionChecker::display();

        $request_funds = Request_funds::orderby('id','desc')->get();
        $charts = new Charts;
        
        if (null !== request('approved'))
            $request_funds = Request_funds::orderby('id','desc')->where('approved', '=', 1)->get();
        elseif (null !== request('pending'))
            $request_funds = Request_funds::orderby('id','desc')->where('approved', '=', 0)->get();
        elseif (null !== request('notapproved'))
            $request_funds = Request_funds::orderby('id','desc')->where('approved', '=', 2)->get();
        
        // dd($request_funds->get()[0]->approved);
        return view('disbursement.request_funds.index', compact('request_funds', 'charts'));
        // return view('request_funds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if(! \PermissionChecker::is_permitted('create request_funds'))
            return \PermissionChecker::display();

        $categories = Charts::all();
        // dd(request('multi'));
        if (null !== request('multi') && request('multi') > 0 )
            return view('disbursement.request_funds.multi-create', compact('categories'));
        else
            return view('disbursement.request_funds.create', compact('categories'));
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
        if (null !== request('multi')) {
            $rfs = new Request_funds();
            $rfs->author = Auth::id();
            $rfs->save();
            $ref_number = $rfs->id;
            // dd($ref_number);
            $particulars = request('request_funds');
            foreach ($particulars as $key => $p) {
                $particulars[$key]['request_funds_id'] = $ref_number;
                $particulars[$key]['rfindex'] += 1;
            }

            \App\Request_funds_meta::insert($particulars);
            session()->flash('message', 'Request submitted successfully');
            return redirect(route('request_funds.index'));
        }

        $this->validate($request,[
            'particulars' => 'required',
            'amount' => 'required',
            'category' => 'required'
        ]);
        // $rf->particulars = nl2br(htmlentities(request('particulars'), ENT_QUOTES, 'UTF-8'));//nl2br(request('particulars'));
        // $rf->amount = request('amount');
        // $rf->category = request('category');
        $rf = new Request_funds;
        $rf->author = Auth::id();
        $rf->save();
        $ref_number = $rf->id;
        
        $rfm = new \App\Request_funds_meta;
        $rfm->particulars = nl2br(htmlentities(request('particulars'), ENT_QUOTES, 'UTF-8'));//nl2br(request('particulars'));
        $rfm->amount = request('amount');
        $rfm->category = request('category');
        $rfm->request_funds_id = $ref_number;
        $rfm->save();

        session()->flash('message', 'Request submitted successfully');
        return redirect(route('request_funds.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function show(Request_funds $request_fund)
    {
        //
        if(! \PermissionChecker::is_permitted('view request_funds'))
            return \PermissionChecker::display();

        $charts = new Charts;
        $rfm = Request_funds::findOrFail($request_fund->id);
        $particulars = $rfm->particulars()->orderby('rfindex', 'asc')->get();
        $user = \App\User::find($rfm->author);

        $current_user = \App\User::find(Auth::id());

        return view('disbursement.request_funds.show', compact('request_fund', 'charts', 'particulars', 'user', 'current_user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function edit(Request_funds $request_fund)
    {
        //
        if(! \PermissionChecker::is_permitted('update request_funds'))
            return \PermissionChecker::display();

        $charts = Charts::all();
        $categories = Charts::all();

        // dd($request_fund->particulars);

        return view('disbursement.request_funds.edit', compact('request_fund', 'charts', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd(request()->all());
        if(! \PermissionChecker::is_permitted('update request_funds'))
            return \PermissionChecker::display();

        if (null !== $request->get('approved')) {
            $request_funds = Request_funds::find($id);
            $bool = "approved";
            if ($request->get('approved') == 2)
                $bool = "disapproved";

            $request_funds->approved = $request->get('approved');
            $request_funds->approved_by = Auth::id();
            $request_funds->approved_on = \Carbon\Carbon::now();
            $request_funds->save();
            session()->flash("message", "Fund request has been $bool.");
        } else {
            $ids = [];
            foreach (request('request_funds') as $key => $rf) {
                if (isset($rf['id'])) {
                    array_push($ids, $rf['id']);
                    $update = \App\Request_funds_meta::find($rf['id']);
                    $update->rfindex = $rf['rfindex'];
                    $update->particulars = $rf['particulars'];
                    $update->amount = $rf['amount'];
                    $update->category = $rf['category'];
                    $update->save();
                } else {
                    unset($rf['id']);
                    $rfm = new \App\Request_funds_meta;
                    $rfm->rfindex = $rf['rfindex'];
                    $rfm->particulars = $rf['particulars'];
                    $rfm->amount = $rf['amount'];
                    $rfm->category = $rf['category'];
                    $rfm['request_funds_id'] = $id;
                    $rfm->save();
                    
                    array_push($ids, $rfm->id);
                }
            }
            \App\Request_funds_meta::whereNotIn('id', $ids)->where('request_funds_id', $id)->delete();
            session()->flash('message','Fund request has been updated successfully!');
            return redirect(route('request_funds.show', $id));
        }
        return redirect(route('request_funds.show', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Request_funds  $request_funds
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request_funds $request_funds, $id)
    {
        //
        if(! \PermissionChecker::is_permitted('delete request_funds'))
            return \PermissionChecker::display();

        $request_fund = $request_funds::find($id);
        $request_fund->delete();
        
        $particulars = \App\Request_funds_meta::where('request_funds_id', $id);
        // dd($particulars->get());
        $particulars->delete();
        return redirect(route('request_funds.index'))->with('message','Fund request has been deleted');
    }
}
