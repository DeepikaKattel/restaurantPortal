<?php

namespace App\Http\Controllers;

use App\Models\FoodCategories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $users = User::all()->count();
        $foodCategories = FoodCategories::all()->pluck('name')->tojson();
        $foodCategory = FoodCategories::all()->pluck('name')->tojson();
        $usersUnapproved = User::whereNull('approved_at')->get();
        $usersCount = count($usersUnapproved);
        return view('admin.dashboard',compact('foodCategories','users','foodCategory','usersUnapproved','usersCount'));
    }
    public function profile()
    {
        return view('admin.profile');
    }
    public function approval()
    {
        return view('approval');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
