<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Categories extends Model
{
    use HasFactory,notifiable;
    protected $table='categories';

    protected $fillable = ([
        'name','image',
    ]);

    public function item()
    {
        return $this->hasMany('App\Models\Item');
    }
}
