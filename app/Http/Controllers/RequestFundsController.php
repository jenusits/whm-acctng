<?php

namespace App\Http\Controllers;

use App\Request_funds;
use App\Charts;
use Illuminate\Http\Request;

use Auth;


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
        $request_funds = Request_funds::orderby('id','desc')->get();
        $charts = new Charts;
        
        // dd($request_funds);
        return view('request_funds.index', compact('request_funds', 'charts'));
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
        $categories = Charts::all();
        // dd(request('multi'));
        if (null !== request('multi') && request('multi') > 0 )
            return view('request_funds.multi-create', compact('categories'));
        else
            return view('request_funds.create', compact('categories'));
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
            }

            \App\Request_funds_meta::insert($particulars);
            session()->flash('message', 'Request submitted successfully');
            return redirect(route('request_funds.index'));
        }

        $rf = new Request_funds;
        $this->validate($request,[
            'particulars' => 'required',
            'amount' => 'required',
            'category' => 'required'
        ]);

        $rf->particulars = nl2br(htmlentities(request('particulars'), ENT_QUOTES, 'UTF-8'));//nl2br(request('particulars'));
        $rf->amount = request('amount');
        $rf->category = request('category');
        $rf->author = Auth::id();
        $rf->save();
        session()->flash('message', 'Request submitted successfully');
        return redirect()->back();
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
        $charts = new Charts;
        $rfm = Request_funds::findOrFail($request_fund->id);
        $particulars = $rfm->particulars()->get();
        $author = \App\User::find($rfm->author)->name;

        return view('request_funds.show', compact('request_fund', 'charts', 'particulars', 'author'));
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
        $charts = Charts::all();
        return view('request_funds.edit', compact('request_fund', 'charts'));
    }

    public function approval(Request_funds $request_fund) {
        $request_funds = Request_funds::orderby('id','asc')->get();
        $charts = new Charts;
        return view('request_funds.approval', compact('request_funds', 'charts'));
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
        if (null !== $request->get('approved')) {
            $request_funds = Request_funds::find($id);
            $bool = "approved";
            if ($request->get('approved') == 0)
                $bool = "disapproved";
            $request_funds->approved = $request->get('approved');
            $request_funds->save();
            session()->flash("message", "Fund request has been $bool.");
        } else {
            $this->validate($request,[
                'particulars' => 'required',
                'amount' => 'required',
                'category' => 'required'
            ]);

            $request_funds = Request_funds::find($id);

            $request_funds->particulars = $request->get('particulars');
            $request_funds->amount = $request->get('amount');
            $request_funds->category = $request->get('category');
            $request_funds->save();
            session()->flash('message','Fund request has been updated successfully!');
        }
        return redirect(route('request_funds.show', $request_funds->id));
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
        $request_fund = $request_funds::find($id);
        $request_fund->delete();
        return redirect(route('request_funds.index'))->with('message','Fund request has been deleted');
    }
}
