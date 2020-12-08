<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    //
    protected $table = 'report-user';

    protected $fillable = ['user_for', 'user_by', 'message'];
}
