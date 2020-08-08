<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

     protected $table = 'message';



     protected $fillable = ['title', 'message', 'deal','customer'];


    
}
