<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    public function ingredients()
    {
      return $this->belongsToMany('App\Ingredient')
                  ->withPivot('id', 'quantity')
                  ->withTimestamps();
    }

    public function orders()
    {
      return $this->belongsToMany('App\Order')
                  ->withPivot('id', 'quantity', 'amount')
                  ->withTimestamps();
    }

}
