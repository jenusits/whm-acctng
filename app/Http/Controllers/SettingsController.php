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

        $settings = \App\Settings::all();

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

        // dd($settings);
        // 
        // $image = request()->has('attachments') ? request('attachments') : false;

        // if ($files) {
        //     $path = request('my_file')->store('public/storage/');
        //     // $path = str_replace('public/', '/storage/', $path);

        //     // $file_name = \Storage::disk('logo')->put('expenses/' . $ref_number, $file);
        //     // $att = new \App\Attachments;
        //     // $att->filename = $file_name;
        //     // $att->original_filename = $file->getClientOriginalName();
        //     // $att->attached_to = 'expenses';
        //     // $att->reference_id = $ref_number;
        //     // $att->save();
        // }

        foreach ($settings as $key => $setting) {
            if ($setting['data_type'] == 'image') {
                if (isset($setting['value'])) {
                    \Storage::disk('public')->delete(\Setting::get($key));
                    $file_name = \Storage::disk('public')->put('settings/logo', $setting['value']);
                    \Setting::set($key, $file_name, null, true);
                }
            } else {
                $value = isset($setting['value']) ? $setting['value'] : null;
                \Setting::set($key, $value, null, true);
            }
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
