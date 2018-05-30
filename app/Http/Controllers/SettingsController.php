<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use anlutro\LaravelSettings\SettingStore;

class SettingsController extends Controller
{
    public function __construct() {
        // Resrict this controller to Authenticated users only
        ;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
        if(! \PermissionChecker::is_permitted('update settings'))
            return \PermissionChecker::display();

        $settings = \Setting::all();

        return view('settings.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
        $settings = $request->except('_token', '_method');
        foreach ($settings as $key => $value) {
            \Setting::set($key, $value, null, true);
        }

        session()->flash('message', 'Settings has been saved');
        return redirect(route('settings.index' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
