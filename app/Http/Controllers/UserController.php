<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


use Spatie\Permission\Models\Role;
use Auth;

class UserController extends Controller
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
        if(! \PermissionChecker::is_permitted('users'))
            return \PermissionChecker::display();

        $users = \App\User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(! \PermissionChecker::is_permitted('users'))
            return \PermissionChecker::display();

        $roles = Role::all();
        $user = \App\User::find(Auth::id());
        // $current_role = $user->roles->pluck('name');
        return view('user.create', compact('roles', 'user', 'current_role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(Request $request)
    {
        //$user = new App\User;
        if(! \PermissionChecker::is_permitted('users'))
            return \PermissionChecker::display();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = \App\User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => \Hash::make($request['password']),
        ]);
        $user->assignRole($request['user_role']);
        
        session()->flash('message', 'User was added successfully');
        return redirect(route('users.index'));
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
        // if(! \PermissionChecker::is_permitted('users'))
        //     return \PermissionChecker::display();

        $u = \App\User::find(Auth::id());
        $cr = $u->roles->pluck('name');
        if (isset($cr[0]))
            $cr = $cr[0];
        else
            $cr = '';

        if ($id != Auth::id() && ! \PermissionChecker::is_permitted('users'))
            return \PermissionChecker::display();

        $current_user = $u;

        $roles = Role::all();
        $user = \App\User::findOrFail($id);
        $current_role = $user->roles->pluck('name');
        if (isset($current_role[0]))
            $current_role = $current_role[0];
        else
            $current_role = '';
        return view('user.edit', compact('roles', 'user', 'current_role', 'current_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\User $user)
    {
        //
        if(! \PermissionChecker::is_permitted('users') && $user->id != \Auth::id())
            return \PermissionChecker::display();


        $fields = [];

        if (isset($request['name']) || isset($request['email'])) {
            $fields['name'] = 'required|string|max:255';
            $fields['email'] = [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)            
            ];
            $this->validate($request, $fields);
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->save();
            session()->flash('message', 'User was updated successfully');
        }

        if (isset($request['password'])) {
            $fields['password'] = 'required|string|min:6|confirmed';
            $this->validate($request, $fields);
            $user->password = \Hash::make($request['password']);
            $user->save();
            session()->flash('message', 'Password was updated successfully');
        }

        // $current_role = $user->roles->pluck('name');
        if (isset($request['user_role']) && $user->id != \Auth::id()) {
            $roles = Role::all();
            foreach ($roles as $key => $role) {
                $user->removeRole($role);
            }
            $user->assignRole($request['user_role']);
        }

        return redirect(route('users.edit', $user->id));
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
    }
}
