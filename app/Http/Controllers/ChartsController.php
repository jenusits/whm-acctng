<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use App\Charts;
use Auth;
use DB;

class ChartsController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $charts = Charts::orderby('id','asc')->get();

        return view('charts.index', compact('charts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Charts $chart)
    {

        return view('charts.show', compact('chart'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Charts $chart){
        if (! Auth::check()) {
            session()->flash('message', 'You must log in first');
            return redirect('/login');
        }
        return view('charts.edit',compact('chart'));
    }

    public function create(){

        return view('charts.create');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Charts $chart){

        $chart->delete();

        return redirect('/charts')->with('message','Chart account has been deleted');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Charts $chart){

        $this->validate($request,[
            'account_name' => 'required'
        ]);

        $chart->account_name = $request->account_name;
        $chart->save();
        session()->flash('message','Account has been updated successfully!');
        return redirect()->back();
    }

    public function store(Request $request){

        $this->validate($request,[
            'account_name' => 'required'
        ]);


        Charts::create([
            'account_name' => $request->account_name
        ]);

        session()->flash('message','Account has been added.');
        return redirect(route('charts.index'));
    }


}
