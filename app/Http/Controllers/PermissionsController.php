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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();

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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();
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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'name' => 'required|unique:permissions'
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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();
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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();
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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();
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
        if(! \PermissionChecker::is_permitted('permissions'))
            return \PermissionChecker::display();
    }
}
