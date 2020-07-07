<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Chatuser extends Model
{
    //

     protected $table = 'chatuser';

      protected $fillable = ['room', 'customer', 'status'];


    
}
