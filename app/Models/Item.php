<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Item extends Model
{
    use HasFactory,notifiable;
    protected $table='item';

    protected $fillable = ([
        'name','description','price','image','category_id','isSpecial'
    ]);

    public function category()
    {
        return $this->belongsTo('App\Models\Categories','category_id');
    }
    public function cartItem(){
        return $this->hasMany(Carts::class);
    }


}
