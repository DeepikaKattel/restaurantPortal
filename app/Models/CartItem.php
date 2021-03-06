<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    public function item(){
    	return $this->belongsTo(Item::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
}
