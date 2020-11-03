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
        return view('admin.dashboard',compact('foodCategories','users','foodCategory'));
    }
    public function profile()
    {
        return view('admin.profile');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
