<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Coupon;
use App\Http\Models\Companies;
use App\Http\Models\Deal;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use Illuminate\Support\Facades\Gate;
use Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $coupons = Coupon::select('coupon.*')->join('deals', 'deals.id', '=', 'coupon.deal')
        ->join('companies', 'deals.company_id', '=', 'companies.id');
        if ( Gate::allows('company_manage')) {
            $coupons=$coupons->where('companies.user',Auth::user()->id);
        }

        $coupons=$coupons->orderby('coupon.id','desc')->get();
      

        return view('coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $companies = Companies::orderby('id','desc');
        if(Gate::allows(['company_manage'])) {
                $companies = $companies->where('user',Auth::user()->id);

       }
       $companies = $companies->get();
       return view('coupon.create',compact('companies'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    {
        //

        $coupon = new Coupon;
        $coupon->deal = $request->deal;
        $coupon->code = $request->code;
        $coupon->limit = $request->limit;
        $coupon->consumed = 0;
        $coupon->save();
        return redirect()->route('coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $companies = Companies::orderby('id','desc');
        if(Gate::allows(['company_manage'])) {
                $companies = $companies->where('user',Auth::user()->id);

       }
        $companies = $companies->get();
        $coupon = Coupon::where('id',$id)->first();
        $deal = Deal::where('id',$coupon->deal)->first();
        $companyS = $deal->company_id;
        $deals = Deal::where('company_id',$companyS)->get();
        return view('coupon.edit',compact('companies','coupon','deal','companyS','deals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponUpdateRequest $request, $id)
    {
       
        $coupon = Coupon::where('id',$id);
        $coupon->deal = $request->deal;
        $coupon->code = $request->code;
        $coupon->limit = $request->limit;
        $coupon->save();
        return redirect()->route('coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
      
        return redirect()->route('coupons.index');
    }    

     public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Coupon::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }

    public function deal(){
        if(!isset($_GET['id'])){
            return abort('404');
            
        }  
        $id = $_GET['id'];
        if(!$id){
            return abort('404');
            
        }   
        $deals =  Deal::where('company_id',$id);
   
        if($deals->count() <= 0 ){
            return abort('404');
        }


        return  response()->json($deals->get(),200);
 


    }
}
