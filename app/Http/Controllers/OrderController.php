<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderDetails = DB::table('Orders')->get();
        return view('admin.order.index', compact('orderDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->item_id = request('item_id');
        $order->quantity = request('quantity');
        $item = DB::table('item')
            ->select('price')
            ->where('id','=',$order->item_id)
            ->value('price');
        $order->price = $order->quantity * $item->price;
        $order->loyalty_points = $order->price / 10;
        $order->save();
        $orderSave = $order->save();
        if($orderSave) {
            return redirect('/order')->with("status", "The record has been stored");
        } else {
            return redirect('/order')->with("error", "There is an error");
        }
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
        $order = Order::find($id);
        $items = Item::get();
        return view('admin.order.edit', compact('order','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $order->user_id = Auth::user()->id;
        $order->item_id = request('item_id');
        $order->quantity = request('quantity');
        $item = DB::table('item')
            ->select('price')
            ->where('id','=',$order->item_id)
            ->value('price');
        $order->price = $order->quantity * $item->price;
        $order->loyalty_points = $order->price / 10;
        $order->save();
        $orderSave = $order->save();
        if($orderSave) {
            return redirect('/order')->with("status", "The record has been updated");
        } else {
            return redirect('/order')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id)->delete();
        return redirect('/order')->with('status','Deleted Successfully');
    }
}
