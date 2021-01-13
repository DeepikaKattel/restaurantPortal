<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carts;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Checkout;
use Auth;

class CartsController extends Controller
{
    public function getCart(Request $request){
        if (Auth::check()) {
            $cart = Carts::where([
                ['user_id', '=', Auth::id()],
                ['checkout', '=', 0]
            ])->get();
            if ($cart[0] ?? '') {
                $grand_total = $cart[0]->grand_total;
                $carts = CartItem::where('cart_id', $cart[0]->id)->get();
            } else {
                $grand_total = 0;
                return response()->json(array('view' => view('partial.cart_items', compact('grand_total'))->render()));
            }
            return response()->json(array('view' => view('partial.cart_items', compact('carts', 'grand_total'))->render()));
        }else {
            return response()->json(array('auth' => 0));
        }
    }

    public function addToCart(Request $request){
        if (Auth::check()) {
            $cart = Carts::where([
                ['user_id', '=', Auth::id()],
                ['checkout', '=', 0]
            ])->get();
            $item = Item::find($request->input('item'));
            if ($cart[0] ?? '') {
                $this->createCartItem($item->id, $cart[0]['id']);
                $cart[0]->grand_total += $item->price;
                $cart[0]->save();                
            } else {
                $cart = new Carts();
                $cart->user_id = Auth::id();
                $cart->save();
                $this->createCartItem($item->id, $cart->id);
                $cart->grand_total += $item->price;
                $cart->save();                
            }            
            return $this->getCart($request);            
        }else {
            return response()->json(array("error" => "Unauthorized error"), 401);
        }
    }
    
    public function createCartItem($p_id, $id) {
        $cartItem = CartItem::where([
            ['cart_id', '=', $id],
            ['item_id', '=', $p_id],
            ])->get();
        if ($cartItem[0] ?? ''){
            $cartItem[0]->quantity += 1;
            $cartItem[0]->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $id;
            $cartItem->item_id = $p_id;
            $cartItem->quantity = 1;
            $cartItem->save();
        }
    }
        
    public function getCartList(Request $request) {
        $cart = Carts::where([
                ['user_id', '=', Auth::id()],
                ['checkout', '=', 0]
            ])->get();
        $grand_total = $cart[0]->grand_total;
        $cartItems = CartItem::where('cart_id', '=', $cart[0]->id)->get();
        return response()->json(array(
            'view' => view('partial.checkout_list', compact('cartItems', 'grand_total'))->render(),
            'grand_total' => $grand_total
        ));
    }

    public function RemoveFromCart(Request $request){
        if (Auth::check()) {
            $item = CartItem::find($request->input('cartItem'));
            if ($item === null) {
                return response()->json(array("error" => "Cart not found"), 404);
            } else {
                if ($item->quantity == 1) {
                    $item->delete();
                } else {
                    $item->quantity -= 1;
                    $item->save();
                }
                $item->cart->grand_total -= $item->item->price;
                $item->cart->save();
            }
            return $this->getCart($request);
        } else {
            return response()->json(array("error" => "Unauthorized error"), 401);
        }
    }

    public function showProduct($id) {
        $item = Item::find($id);
        $category = Categories::all();       
    }
    
    public function checkoutForm() {
        $cart = Carts::where([
                ['user_id', '=', Auth::id()],
                ['checkout', '=', 0]
            ])->get();
        return view('main.checkout', ['cart_id' => $cart[0]->id]);
    }

    public function checkout(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'phone_no' => 'required'
        ]);

        $checkout = new Checkout();
        $checkout->name = $request->input('name');
        $checkout->email = $request->input('email');
        $checkout->address = $request->input('address');
        $checkout->phone_no = $request->input('phone_no');
        $checkout->cart_id = $request->input('cart_id');
        
        $cart = Carts::find($request->input('cart_id'));
        $cart->checkout = 1;

        if ($cart->grand_total < 10) {
            return redirect('/checkout');
        } else {
            $checkout->save();
            $cart->save();
           
        }
    }
}
