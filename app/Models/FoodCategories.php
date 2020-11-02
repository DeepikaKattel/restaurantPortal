<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FoodCategories extends Model
{
    use HasFactory,notifiable;
    protected $table='food_categories';

    protected $fillable = ([
        'name','image',
    ]);

    public function food()
    {
        return $this->hasMany('App\Models\Food');
    }
}
