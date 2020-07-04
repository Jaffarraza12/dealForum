<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //

     protected $table = 'coupon';

     protected $fillable = ['deal', 'customer', 'status','code'];



    public function dealing()
    {
        return $this->hasOne('App\Http\Models\Deal','id','deal');
    }
}
