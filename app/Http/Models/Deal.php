<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    //
      protected $table = 'deals';


       public function company()
    {
        return $this->hasOne('App\Http\Models\Companies','id','company_id');
    }
}
