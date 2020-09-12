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
use Mail;

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

    public function api(Request $request){
        $resp = json_decode($request->getContent(), true);
        $start = date('Y-m-d').' 00:00:00';
        $end = date('Y-m-d').' 23:59:59';
        


        if(Coupon::where('customer',$resp['uid'])->whereBetween('created_at',[$start,$end])->count() == 3){
             $fail = 'You have reached the daily limit for getting more coupons.';   
             return  response()->json(compact('fail'));
        }

        if(Coupon::where('customer',$resp['uid'])->where('deal',$resp['deal'])->count() > 0){
             $fail = 'You have already subscribe this deal.';   
             return  response()->json(compact('fail'));

        }
        
        $data = array();
        $data['deal'] = $resp['deal'];
        $data['code'] = $this->generateCoupon();
        $data['status'] = 1;
        $data['customer'] = $resp['uid'];

        $query = Coupon::create($data);
        $success = true;

        $lastInsertedId = $query->id;
        $contact =  Coupon::select('deals.name as DEAL','customer.name','customer.email','coupon.code','companies.name as COMPANY','deals.discount')
        ->join('customer','customer.id','=','coupon.customer')
        ->join('deals','deals.id','=','coupon.deal')
        ->join('companies','deals.company_id','=','companies.id')
        ->where('coupon.id',$lastInsertedId)->first();
        $data = array(
            'name'=> $contact->name,
            'email'=> $contact->email,
            'coupon' => $contact->code,
            'discount' => $contact->discount,
            'deal' => $contact->DEAL,
            'company' => $contact->COMPANY
            
         );
       

         $sent = Mail::send('email.coupon-customer', $data, function($message) use($data) {
            $message->to($data['email']);
            $message->subject('Congragulation you get discount on '.$data['deal']);
        });

        return  response()->json(compact('success'));

    }

    public function getCoupon($customer) {

        $coupons =  Coupon::select('deals.name as DEAL','deals.image','customer.name','customer.email','coupon.code','companies.name as COMPANY','deals.discount')
        ->join('customer','customer.id','=','coupon.customer')
        ->join('deals','deals.id','=','coupon.deal')
        ->join('companies','deals.company_id','=','companies.id')
        ->where('customer.id',$customer)->orderby('coupon.id','desc')->get();


        return  response()->json(compact('coupons'));
    

    }

    private function generateCoupon() {
    $length = 5;    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }



    public function ValidateCoupon(Request $request){

        $coupon = '';
        $code = '';
        if ($request->isMethod ('post')) { 
              $code =  $request->coupon;
              $coupon =  Coupon::select('deals.name as DEAL','deals.image','customer.name','customer.email','customer.phone','coupon.code','companies.name as COMPANY','deals.discount')
            ->join('deals','deals.id','=','coupon.deal')
            ->join('companies','deals.company_id','=','companies.id')
            ->leftjoin('customer','customer.id','=','coupon.customer')
            ->where('coupon.code',$code)->first();
        }


          return view('coupon.validate-coupon',compact('coupon','code'));





    }
}
