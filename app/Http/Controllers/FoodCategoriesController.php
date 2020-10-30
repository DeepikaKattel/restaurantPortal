<?php

namespace App\Http\Controllers;

use App\Models\FoodCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foodCategories = DB::table('food_categories')->get();
        return view('admin.foodCategories.index', compact('foodCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.foodCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $foodCategories = new FoodCategories();
        $foodCategories->name = request('name');
        $foodCategories->save();
        $food = $foodCategories->save();
        if($food) {
            return redirect('/foodCategories')->with("status", "The record has been stored");
        } else {
            return redirect('/foodCategories')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function show(FoodCategories $foodCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $foodCategories = FoodCategories::find($id);
        return view('admin.foodCategories.edit', compact('foodCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $foodCategories = FoodCategories::find($id);
        $foodCategories->name = request('name');
        $foodCategories->save();
        $food = $foodCategories->save();
        if ($food) {
            return redirect('/foodCategories')->with("status", "The record has been updated");
        } else {
            return redirect('/foodCategories')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodCategories  $foodCategories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foodCategories = FoodCategories::find($id)->delete();
        return redirect('/foodCategories')->with('status','Deleted Successfully');
    }
}
