<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use App\Models\Carts;
use App\Models\CartItem;
use Auth;
class CheckoutController extends Controller
{
    // public function __construct() {
    //     $this->middleware('role:1,2');
    // }
    
    public function getCheckouts() {
        $carts = Carts::where('checkout','=', 1)->orderBy('created_at', 'desc')->get();
        $carts = $carts->map(function ($item) {
            $cartItems = array();
            $cartItemFlag = false;
            // if (Auth::user()->user_role == 1) {
            if (Auth::user()) {
                foreach ($item->cartItem as $cartItem) {
                    $cartItems[] = $cartItem;
                    $cartItemFlag = true;
                }
            }
            // } else {
            //     foreach ($item->cartItem as $cartItem) {
            //         if ($cartItem->item->vendor_id == Auth::user()->vendor_id) {
            //             $cartItems[] = $cartItem;
            //             $cartItemFlag = true;
            //         }
            //     }
            // }
            if($cartItemFlag){
                $item->cartItems = $cartItems;
                return $item;
            }
        });
        return view('admin.checkout', compact('carts'));
    }
}
