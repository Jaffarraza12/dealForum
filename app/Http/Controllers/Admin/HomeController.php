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
use App\Http\Models\Coupon;
use App\Http\Models\Message;
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
        $customer = Customer::where('id','>',0);
        $coupon = Coupon::select('customer.name AS customer',
            'deals.name','deals.discount',
            'coupon.code')->join('deals','deals.id','coupon.deal')->leftjoin('customer','customer.id','coupon.customer');

        $messages = Message::select('message.title',
            'deals.name','message.id',
            'message.email','message.message')->join('deals','deals.id','message.deal');


       
        if (!Gate::allows('users_manage')) { 
            $companiesCount  =  $companiesCount->where('user',Auth::user()->id);
            $dealCount = $dealCount->where('companies.user',Auth::user()->id);
            /*$customer = $customer->whereIn('deal',function($qry){
                $qry->select('deals.id')->from('deals')->join('companies','companies.id','=','deals.company_id')->where('companies.user',Auth::user()->id);   
            });*/
            $coupon = $coupon->whereIn('deal',function($qry){
                $qry->select('deals.id')->from('deals')->join('companies','companies.id','=','deals.company_id')->where('companies.user',Auth::user()->id);   
            });
            $messages = $messages->whereIn('deal',function($qry){
                $qry->select('deals.id')->from('deals')->join('companies','companies.id','=','deals.company_id')->where('companies.user',Auth::user()->id);   
            });
        }
        $companiesCount = $companiesCount->count();
        $dealCount = $dealCount->count();
        $customerCount = $customer->count();
        $couponCount = $coupon->count();
        $coupons = $coupon->orderby('coupon.id','desc')->limit(10)->get();
        $messages = $messages->orderby('message.id','desc')->limit(10)->get();
      
        return view('home',compact('companiesCount','dealCount','customerCount','couponCount',
            'messages','coupons'));
    }


}
