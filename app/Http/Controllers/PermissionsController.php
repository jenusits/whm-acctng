<?php

namespace App\Http\Controllers;

use App\Permissions;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;

class PermissionsController extends Controller
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
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();

        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();
        return view('permissions.create');
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
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();

        $this->validate($request, [
            'name' => 'required'
        ]);

        Permission::create(['name' => $request['name']]);

        $role = Role::find(1); // Sync New Permissions to Super Admin
        $role->syncPermissions(Permission::all());

        session()->flash('message', 'Permission was added successfully');
        return redirect(route('permissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function show(Permissions $permissions)
    {
        //
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function edit(Permissions $permissions)
    {
        //
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permissions $permissions)
    {
        //
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permissions $permissions)
    {
        //
        if(! \App\Checker::is_permitted('permissions'))
            return \App\Checker::display();
    }
}
