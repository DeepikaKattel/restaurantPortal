<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food = DB::table('food')->get();
        return view('admin.food.index', compact('food'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $foodCategories = FoodCategories::get();
        return view('admin.food.create',compact('foodCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $food = new Food();
        $food->name = request('name');
        $food->description = request('description');
        $food->price = request('price');
        $food->category_id = request('category_id');
        if ($request->hasFile('image')) {
            $image = $request->image;
            $fileName = rand() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("FoodCategoryImage/");
            $image->move($destination_path, $fileName);
            $food->image = 'FoodCategoryImage/' . $fileName;
        }
        $food->save();
        $food = $food->save();
        if($food) {
            return redirect('/food')->with("status", "The record has been stored");
        } else {
            return redirect('/food')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $food = Food::find($id);
        return view('admin.food.edit', compact('food'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $food = Food::find($id);
        $food->name = request('name');
        $food->description = request('description');
        $food->price = request('price');
        $food->category_id = request('category_id');
        if ($request->hasFile("image")) {
            if ($food->image) {
                File::delete(public_path($food->image));
            }
            $image = $request->image;
            $fileName = time() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("foodImage/");
            $image->move($destination_path, $fileName);

            $food->image = 'foodImage/' . $fileName;
        }
        $food->save();
        $food = $food->save();
        if ($food) {
            return redirect('/food')->with("status", "The record has been updated");
        } else {
            return redirect('/food')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id)->delete();
        return redirect('/food')->with('status','Deleted Successfully');
    }
}
