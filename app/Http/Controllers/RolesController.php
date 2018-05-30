<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
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
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();

        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
        
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
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
        // $this->validate($request, [
        //     'name' => 'required'
        // ]);

        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
            
        Role::create(['name' => $request['name']]);

        session()->flash('message', 'Role was added successfully');
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Role $roles)
    {
        //
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
            
        $permissions = Permission::all();
        // $permitted = \DB::select("SELECT * FROM `permissions` where permissions.id in (select permission_id from role_has_permissions where role_id = $role->id)");
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
            
        $this->validate($request, [
            'permissions' => 'required'
        ]);

        $role = Role::find($role->id);
        $role->syncPermissions($request['permissions']);

        session()->flash('message', 'Role was updated');
        return redirect(route('roles.edit', $role->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $roles)
    {
        //
        if(! \PermissionChecker::is_permitted('roles'))
            return \PermissionChecker::display();
            
    }
}
