<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;


use Illuminate\Validation\Rule;

class AdminSettingsController extends Controller
{
    public function index()
    {
        //
        if(! \PermissionChecker::is_permitted('view settings'))
            return \PermissionChecker::display();

        $settings = \Setting::all();

        return view('admin-settings.index', compact('settings'));
    }

    public function create()
    {
        //
        return view('admin-settings.create');
    }

    public function store(Request $request)
    {
        //
        if(! \PermissionChecker::is_permitted('create settings'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'key' => 'required|unique:settings',
            'data_type' => 'required'
        ]);

        // $settings = new Settings;
        // $settings->key = request('key');
        // $settings->data_type = request('data_type');
        // $settings->show = request('show') || false;
        // $settings->save();

        \Setting::set(request('key'), request('value'), request('data_type'), request('show') || false);

        return redirect()->route('admin-settings.index')->with('message', 'Option has been saved');
    }

    public function show($id)
    {
        //
        return redirect()->route('admin-settings.edit', $id);
    }

    public function edit($id)
    {
        //
        if(! \PermissionChecker::is_permitted('update settings'))
            return \PermissionChecker::display();

        $setting = Settings::findOrFail($id);

        return view('admin-settings.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        //
        if(! \PermissionChecker::is_permitted('update settings'))
            return \PermissionChecker::display();

        $fields['data_type'] = 'required';
        $fields['key'] = [
            'required',
            Rule::unique('settings')->ignore($id)            
        ];
        $this->validate($request, $fields);   

        $settings = Settings::findOrFail($id);
        $settings->key = str_replace(' ', '_', strtolower(request('key')));
        $settings->value = json_encode(request('value'));
        $settings->data_type = request('data_type');
        $settings->show = request('show') || false;
        $settings->save();

        return redirect()->route('admin-settings.index')->with('message', 'Option has been updated');
    }

    public function destroy($id)
    {
        //
        if(! \PermissionChecker::is_permitted('delete settings'))
            return \PermissionChecker::display();

        $settings = Settings::findOrFail($id);

        $settings->delete();
        
        return redirect()->route('admin-settings.index')->with('message', 'Option has been deleted');
    }
}
