<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';


     public function info()
    {
        return $this->hasMany('App\Http\Models\Admin\CategoryDetail');
    }
}
