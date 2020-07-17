<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Deal;
use App\Http\Models\Companies;
use App\Http\Models\Customer;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DealStoreRequest;
use Auth;



class CustomerController extends Controller
{
  

    public function CustomerApi(Request $request){


        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['name'] = $resp['name'];
        $data['email'] = ($resp['email'] == 'null') ? $this->makeTempEmail() : $resp['email'];
        $data['fbid'] = $resp['fbid'];
        $data['goid'] = $resp['goid'];


        if( Customer::where('email',$data['email'])->count() > 0){
            $type = 'old';
            //login from google
            if($resp['goid'] != 0 ){
                   unset($data['fbid']); 
            }

            //login from fbid
            if($resp['fbid'] != 0 ){
                   unset($data['goid']); 
            }

            print_r($data);

            Customer::where('email',$data['email'])->update($data);
            $user = Customer::update($data)->where('email',$data['email'])->first();
            print_r($user);

            return response()
            ->json(compact('user','type'));

        }

         if( $data['fbid'] != 0 && Customer::where('fbid',$data['fbid'])->count() > 0){
             $type = 'old';
            $user = Customer::where('fbid',$data['fbid'])->first();
            return response()
            ->json(compact('user','type'));
         
         }

         if( $data['goid'] != 0 && Customer::where('goid',$resp['goid'])->count() > 0){
            $type = 'old';
            $user = Customer::where('goid',$data['goid'])->first();
            return response()
            ->json(compact('user','type'));
         
         }

       

        $user = Customer::create($data);
        $lastInsertedId = $user->id;
        $type = 'new';
        $user = Customer::where('id',$lastInsertedId)->first(); 
         return response()
            ->json(compact('user','type'));

    }

    public function Edit(Request $request){
        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['name'] = $resp['name'];
        $data['id'] = $resp['id'];
        $data['phone'] = (!empty($resp['phone'])) ? $resp['phone'] : '';
        $data['password'] = (!empty($resp['password'])) ?  md5($resp['password']) : ''; 

        $user = Customer::where('id',$data['id'])->update($data);
        $user = Customer::where('id',$data['id'])->first();

        return response()
            ->json(compact('user'));
        

    }
     public function show($id)
     { 
        $customer = Customer::where('id',$id)->get();
        return response()
            ->json(compact('customer'));


            //
     }

     private function makeTempEmail(){
        $string = substr(md5(time()), 0, 7);
        $email = $string.'@deal-forum.com';
        return $email;




     }
 }
