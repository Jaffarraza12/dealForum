<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Deal;
use App\Http\Models\Companies;
use App\Http\Models\Rating;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DealStoreRequest;
use Auth;



class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    var $image_thumb ;
    public function __construct(Request $request) {

        if($request->getHttpHost() == 'localhost') { 
            $this->image_thumb = '/dealForum/public/images.png';
        } else {
            $this->image_thumb = '/Image/images.png';
       
        }

    }
    public function index()
    {
        //
        $deals = Deal::with('company');
         if(Gate::allows(['company_manage'])) {
                $deals = $deals->wherein('company_id',Companies::select('id')->where('user',Auth::user()->id)->get());

        }
        $deals = $deals->orderby('deals.id','desc')->get();
        return view('deals.index',compact('deals'));
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
        $img_thumb =  $this->image_thumb ;
        return view('deals.create',compact('companies','img_thumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealStoreRequest $request)
    {
        //
        if (!Gate::allows('users_manage') && !Gate::allows('company_manage')){
            return abort(401);
        } 

        $deal = new Deal;
        $deal->name = $request->name;
        $deal->description = $request->description;
        $deal->image = $request->image;
        $deal->discount = $request->discount;
        $deal->company_id =  $request->company;
        $deal->status = $request->status;
        $deal->consumer = $request->consumer;
        $deal->starting_date = $request->starting_date;
        $deal->ending_date = $request->ending_date;
        $deal->save();

        return redirect()->route('deals.index');
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
        $companies = Companies::orderby('id','desc');
        if(Gate::allows(['company_manage'])) {
                $companies = $companies->where('user',Auth::user()->id);

        }
        $companies = $companies->get();
        $deal = Deal::where('id',$id)->first();
      
        if(!isset($deal->image) || empty($deal->image)  || $deal->image ==' '){
            $img_thumb =   $this->image_thumb ;    
        } else {
            $img_thumb = $deal->image; 
        }


        return view('deals.edit',compact('companies','deal','img_thumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealStoreRequest $request, $id)
    {
        //
       if (!Gate::allows('users_manage') && !Gate::allows('company_manage')){
            return abort(401);
        } 

        $deal = Deal::find($id);
        $deal->name = $request->name;
        $deal->description = $request->description;
        $deal->image = $request->image;
        $deal->discount = $request->discount;
        $deal->company_id =  $request->company;
        $deal->status = $request->status;
        $deal->consumer = $request->consumer;
        $deal->starting_date = $request->starting_date;
        $deal->ending_date = $request->ending_date;
        $deal->save();

        return redirect()->route('deals.index');
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
        $deal = Deal::findOrFail($id);
        $deal->delete();
      
        return redirect()->route('deals.index');
    }    

     public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Deal::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }

     public function api(Request $request){

        $deals = Deal::select('deals.*','companies.name AS company')
        ->join('companies', 'deals.company_id', '=', 'companies.id')      
        ->where('deals.id','!=',0);
        if($request->get('company') <> ''){
            $deals = $deals->where('company_id',$request->get('company'));

        }
        $deals =  $deals->get();
       
        return response()
            ->json(compact('deals'));

    }

    public function detailapi(Request $request){
        $deal = Deal::where('id','!=',0);
        $rating = 0;
        if($request->get('id') <> ''){
            $deal = $deal->where('id',$request->get('id'));
            $rating = Rating::where('deal',$request->get('id'))->avg('vote');

        }
        $deal =  $deal->first();
       

        return response()
            ->json(compact('deal','rating'));

    }

     function DoRating(Request $request){

        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['customer'] = $resp['customer'];
        $data['deal'] = $resp['deal'];
        $data['vote'] = $resp['vote'];
       
        
        $rate = Rating::create($data);
        $lastInsertedId = $rate->id; 
        return response()
            ->json(Rating::where('deal',$data['deal'])->avg('vote'));

    }
}
