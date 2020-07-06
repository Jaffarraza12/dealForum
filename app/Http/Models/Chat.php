<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //

     protected $table = 'chatbox';



     protected $fillable = ['chatid', 'customer', 'message','room','chattimeat'];


    
}
