<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('categories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::where('id',Auth::user()->id)
            ->where('user_type','normal')
            ->value('id');
        $count = Item::where('user_id', $user)
            ->count();
        return view('admin.categories.create',compact('count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = new Categories();
        $categories->name = request('name');
        if ($request->hasFile('image')) {
            $image = $request->image;
            $fileName = rand() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("categoryImage/");
            $image->move($destination_path, $fileName);
            $categories->image = $fileName;
        }
        $categories->user_id = Auth::user()->id;
        $categories->save();
        $category = $categories->save();
        if($category) {
            return redirect('/categories')->with("status", "The record has been stored");
        } else {
            return redirect('/categories')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Categories::find($id);
        return view('admin.categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categories = Categories::find($id);
        $categories->name = request('name');
        if ($request->hasFile("image")) {
            if ($categories->image) {
                File::delete(public_path($categories->image));
            }
            $image = $request->image;
            $fileName = time() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("categoryImage/");
            $image->move($destination_path, $fileName);

            $categories->image = 'categoryImage/' . $fileName;
        }
        $categories->save();
        $category = $categories->save();
        if ($category) {
            return redirect('/categories')->with("status", "The record has been updated");
        } else {
            return redirect('/categories')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Categories::find($id)->delete();
        return redirect('/categories')->with('status','Deleted Successfully');
    }
}
