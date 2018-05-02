<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Spatie\Permission\Models\Role;
use Auth;

class UserController extends Controller
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
        if(! \App\Checker::is_permitted('roles'))
            return \App\Checker::display();

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
        if(! \App\Checker::is_permitted('roles'))
            return \App\Checker::display();

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
        if(! \App\Checker::is_permitted('roles'))
            return \App\Checker::display();

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
        // if(! \App\Checker::is_permitted('roles'))
        //     return \App\Checker::display();

        $u = \App\User::find(Auth::id());
        $cr = $u->roles->pluck('name');
        if (isset($cr[0]))
            $cr = $cr[0];
        else
            $cr = '';

        if ($id != Auth::id() && ! \App\Checker::is_permitted('users'))
            return \App\Checker::display();

        $roles = Role::all();
        $user = \App\User::findOrFail($id);
        $current_role = $user->roles->pluck('name');
        if (isset($current_role[0]))
            $current_role = $current_role[0];
        else
            $current_role = '';
        return view('user.edit', compact('roles', 'user', 'current_role'));
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
        if(! \App\Checker::is_permitted('roles'))
            return \App\Checker::display();
        
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = \Hash::make($request['password']);
        $user->save();
        
        $roles = Role::all();
        foreach ($roles as $key => $role) {
            $user->removeRole($role);
        }

        $user->assignRole($request['user_role']);
        
        session()->flash('message', 'User was updated successfully');
        return redirect(route('users.index'));
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
