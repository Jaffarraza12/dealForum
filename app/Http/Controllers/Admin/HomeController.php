<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Models\Admin\Setting;
use App\Http\Models\Companies;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companiesCount = Companies::where('status',0);

       
        if (!Gate::allows('users_manage')) { 
            $companiesCount =  $companiesCount->count();
        }
        print_r($companiesCount);
        exit();

        return view('home',compact('companiesCount'));
    }


}
