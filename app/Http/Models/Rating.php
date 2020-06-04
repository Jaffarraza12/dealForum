<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //

     protected $table = 'rating';



     protected $fillable = ['vote', 'deal', 'customer'];


    
}
