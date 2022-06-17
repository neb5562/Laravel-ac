<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $users = User::where('name', 'LIKE', "%".$q."%")
            ->orWhere('username', 'LIKE', "%".$q."%")
            ->orWhere('email', 'LIKE', "%".$q."%")
            ->paginate(10);
        $users->appends(['q' => $q]);
        return view('admin.users', ['users' => $users]);
    }

    public function edit($username)
    {
        $guser = User::where('username','=',$username)->firstOrFail();
        return view('admin.editUserForm', ['guser' =>$guser]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'role_id' => 'required|numeric',
            'user_id' => 'required',
        ]);

       $user =  User::where('id','=',$request->user_id)->firstOrFail();

       $user->name = $request->name;
       $user->email = $request->email;

       Role::where('user_id','=',$request->user_id)->update(['role_id' => $request->role_id]);

       $user->save();

        \Session::flash('status', 'მომხმარებელი განახლდა' );

        return redirect()->back();
    }
}
