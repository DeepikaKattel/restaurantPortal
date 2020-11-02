<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Food extends Model
{
    use HasFactory,notifiable;
    protected $table='food';

    protected $fillable = ([
        'name','description','price','image','category_id',
    ]);

    public function category()
    {
        return $this->belongsTo('App\Models\FoodCategories','category_id');
    }
}
