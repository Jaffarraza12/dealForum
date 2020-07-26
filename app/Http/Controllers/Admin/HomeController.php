<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Setting;


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
        return view('home');
    }


    public function getSliders(){

         $slider =Setting::where('key','slider_content')->first();

         $slider_content = $slider->value;

         return response()
            ->json(compact('slider_content'));
    }


     public function getHelp(){

         $help =Setting::where('key','help_content')->first();

         $help_content = $help->value;

         return response()
            ->json(compact('help_content'));
    }
}
