<?php
<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //

     protected $table = 'contact';



     protected $fillable = ['name', 'email', 'customer','message'];


    
}
