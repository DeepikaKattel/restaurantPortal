<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewUser;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function unapproved()
    {
        $users = User::whereNull('approved_at')->get();
        $usersCount = count($users);

        return view('admin.unapproved', compact('users','usersCount'));
    }

    public function approve($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update(['approved_at' => now()]);

        return redirect()->route('admin.unapproved')->withMessage('User approved successfully');
    }
    public function index()
    {
        $users = DB::table('users')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make($request['password']);
        $user->save();
        $usersave = $user->save();

        if ($usersave) {
            return redirect('/users')->with("status", "The record has been stored");
        } else {
            return redirect('/users')->with("error", "There is an error");
        }
    }


    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }



    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->save();
        $userSave = $user->save();
        if ($userSave) {
            return redirect('/users')->with("status", "The record has been updated");
        } else {
            return redirect('/users')->with("error", "There is an error");
        }
    }


    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }
}
