<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function dishes()
    {
      return $this->belongsToMany('App\Dish')
                  ->withPivot('id', 'quantity')
                  ->withTimestamps();
    }
}
