<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

     protected $table = 'customer';



     protected $fillable = ['name', 'email', 'fbid','goid','phone','status'];


    
}
