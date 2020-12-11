<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Carts;

class Checkout extends Model
{
    public function cart() {
        return $this->hasOne(Carts::class);
    }
}
