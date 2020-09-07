<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Models\Admin\Setting;
use App\Http\Models\Companies;
use App\Http\Models\Deal;
use App\Http\Models\Customer;
use Auth;


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
        $dealCount = Deal::join('companies', 'deals.company_id', '=', 'companies.id');
        $customerCount = Customer::where('id','>',0)->count();

       
        if (!Gate::allows('users_manage')) { 
            $companiesCount  =  $companiesCount->where('user',Auth::user()->id);
            $dealCount = $dealCount->where('companies.user',Auth::user()->id);
            $customerCount = Customer::->whereIn('deal',function($qry){
                $qry->select('deals.id')->from('deals')->join('companies','companies.id','=','deals.company_id')->where('companies.user',Auth::user()->id);   
            })->count();
        }
        $companiesCount = $companiesCount->count();
        $dealCount = $dealCount->count();
      
        return view('home',compact('companiesCount','dealCount','customerCount'));
    }


}
