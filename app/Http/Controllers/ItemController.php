<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = DB::table('item')->get();
        return view('admin.item.index', compact('item'));
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
        $itemCategories = Categories::get();
        return view('admin.item.create',compact('itemCategories','count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item();
        $item->name = request('name');
        $item->description = request('description');
        $item->price = request('price');
        $item->isSpecial = request('isSpecial');
        $item->category_id = request('category_id');
        $item->user_id = Auth::user()->id;
        if ($request->hasFile('image')) {
            $image = $request->image;
            $fileName = rand() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("FoodCategoryImage/");
            $image->move($destination_path, $fileName);
            $item->image = 'FoodCategoryImage/' . $fileName;
        }
        $item->save();
        $item = $item->save();
        if($item) {
            return redirect('/item')->with("status", "The record has been stored");
        } else {
            return redirect('/item')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemCategories = Item::find($id);
        return view('admin.item.edit', compact('itemCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        $item->name = request('name');
        $item->description = request('description');
        $item->price = request('price');
        $item->isSpecial = request('isSpecial');
        $item->category_id = request('category_id');
        if ($request->hasFile("image")) {
            if ($item->image) {
                File::delete(public_path($item->image));
            }
            $image = $request->image;
            $fileName = time() . "." . $image->getClientOriginalExtension();
            $destination_path = public_path("itemImage/");
            $image->move($destination_path, $fileName);

            $item->image = 'itemImage/' . $fileName;
        }
        $item->save();
        $item = $item->save();
        if ($item) {
            return redirect('/item')->with("status", "The record has been updated");
        } else {
            return redirect('/item')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id)->delete();
        return redirect('/item')->with('status','Deleted Successfully');
    }
}
