<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Companies;
use App\Http\Models\Admin\Category;
use App\Http\Requests\CompaniesStoreRequest;
use App\Http\Requests\CompaniesUpdateRequest;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Http\Models\Deal;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;




class CompanyController extends Controller
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
       
       $companies = Companies::orderby('id','desc');
        if(Gate::allows(['company_manage'])) {
                $companies = $companies->where('user',Auth::user()->id);

       }
         $companies = $companies->get();
        return view('company.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if(!Gate::allows(['users_manage'])) {
            return abort(401);
          }
        //
        $categories =  array();
        foreach (Category::Orderby('id','desc')->get() as $cat) {
                   $categories[] = Category::find($cat->id)->info()->where('language','en')->first();
        }

         $users =User::join('assigned_roles', 'assigned_roles.entity_id', '=', 'users.id')
         ->where('assigned_roles.role_id',2);

         $users = $users->get();
         $img_thumb =  $this->image_thumb ;

     
       
        return view('company.create',compact('categories','users','img_thumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompaniesStoreRequest $request)
    {
        //
          if(!Gate::allows(['users_manage'])) {
            return abort(401);
           }

         if((int) $request->user == 0){
           $userRequest['name'] = $request->username; 
           $userRequest['email'] = $request->email; 
           $userRequest['password'] = $request->password; 

           $validator = Validator::make($userRequest,[
                'name' => 'required',
                'email' => 'email|unique:users',
                'password' => 'required',
            ]);
            if (!$validator->fails()) {
                $user = User::create($userRequest);
                $user->assign('company');
                $request->user = $user->id;
            
            } else {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }
        $company = new Companies;
        $company->name =  $request->name; 
        $company->slug =  $request->slug; 
        $company->category_id =  $request->category; 
        $company->image =  $request->image;
        $company->icontype =  $request->icontype;
        $company->user =  $request->user; 
        $company->save();
       
        return redirect()->route('companies.index');;

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
        if (! Gate::allows('users_manage') && ! Gate::allows('company_manage')) {
            return abort(401); 
        }

         $company = Companies::where('id',$id)->first();
         $categories =  array();
            foreach (Category::Orderby('id','desc')->get() as $cat) {
                       $categories[] = Category::find($cat->id)->info()->where('language','en')->first();
            }

         $users =User::join('assigned_roles', 'assigned_roles.entity_id', '=', 'users.id')
         ->where('assigned_roles.role_id',2)->get();
          if(!isset($company->image) || empty($company->image)  || $company->image ==' '){
            $img_thumb =   $this->image_thumb ;    
        } else {
            $img_thumb = $company->image; 
        }
        


         return view('company.edit',compact('company','categories','users','img_thumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompaniesUpdateRequest $request, $id)
    {
        //
        if (! Gate::allows('users_manage') && ! Gate::allows('company_manage') ) {
            return abort(401);
        }

        if((int) $request->user == 0){
           $userRequest['name'] = $request->username; 
           $userRequest['email'] = $request->email; 
           $userRequest['password'] = $request->password; 

           $validator = Validator::make($userRequest,[
                'name' => 'required',
                'email' => 'email|unique:users',
                'password' => 'required',
            ]);
            if (!$validator->fails()) {
                $user = User::create($userRequest);
                $user->assign('company');
                $request->user = $user->id;
            
            } else {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
        }


        $company = Companies::where('id',$id)->first();
        $company->name =  $request->name; 
        $company->slug =  $request->slug; 
        $company->category_id =  $request->category; 
        $company->icontype =  $request->icontype;
        if ( Gate::allows('users_manage') ){
            $company->user =  $request->user; 
        }
        $company->image =  $request->image;
        $company->save();
       
        return redirect()->route('companies.index');;
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
        $company = Companies::findOrFail($id);
        $company->delete();
      
        return redirect()->route('companies.index');
    }    

     public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Companies::whereIn('id', request('ids'))->delete();
        return response()->noContent();
    }


    public function api(Request $request){

        $companies = Companies::select([
            'companies.*',
            DB::raw('(SELECT count(*) from deals where company_id = companies.id) as TOTAL')
        ])->where('status',0);
        if($request->get('category') <> ''){
            $companies = $companies->where('category_id',$request->get('category'));

        }
        $companies =  $companies->get();

        return response()
            ->json(compact('companies'));

    }

}
