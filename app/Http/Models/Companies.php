<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    //

    protected $table = 'companies';


     public function info()
    {
        return $this->hasMany('App\Http\Models\Admin\Category');
    }
}
