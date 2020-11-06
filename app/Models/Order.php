<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';

    protected $fillable = ([
        'user_id','food_id','loyalty_points'
    ]);

    public function user()
    {
        return $this->hasOne(User::class,'user_id');
    }
    public function food()
    {
        return $this->hasOne(Food::class,'food_id');
    }
}
