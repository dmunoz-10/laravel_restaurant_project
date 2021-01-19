<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['status'];

    public function dishes()
    {
      return $this->belongsToMany('App\Dish')
                  ->withPivot('id', 'quantity', 'amount')
                  ->withTimestamps();
    }
}
