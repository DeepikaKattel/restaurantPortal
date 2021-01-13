<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        if($request->hasFile('image'))
        {
            $FilenameWithExtension1 = $request->file('image')->getClientOriginalName();
            $Filename1 = pathinfo($FilenameWithExtension1, PATHINFO_FILENAME);
            $Extension1 = $request->file('image')->getClientOriginalExtension();
            $FileToStore1 = $Filename1.'_'.time().'.'.$Extension1;
            $path1 = $request->file('image')->storeAs('/public/Images/Items',$FileToStore1);
        }
        if($request->hasFile('image'))
        {
            $item->image = $FileToStore1;
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
        if($request->hasFile('image'))
        {
            $FilenameWithExtension1 = $request->file('image')->getClientOriginalName();
            $Filename1 = pathinfo($FilenameWithExtension1, PATHINFO_FILENAME);
            $Extension1 = $request->file('image')->getClientOriginalExtension();
            $FileToStore1 = $Filename1.'_'.time().'.'.$Extension1;
            $path1 = $request->file('image')->storeAs('/public/Images/Banner',$FileToStore1);

            Storage::delete('public/Images/Items'.$item->image);
        }
        if($request->hasFile('image'))
        {
            $item->image = $FileToStore1;
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
