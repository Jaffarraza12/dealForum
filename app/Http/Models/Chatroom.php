<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    //

     protected $table = 'chatroom';

     protected $fillable = ['chatid', 'room', 'customer','status'];


    
}
