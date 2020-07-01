<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Deal;
use App\Http\Models\Companies;
use App\Http\Models\Customer;
use App\Http\Models\Contact;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DealStoreRequest;
use Auth;



class ContactController extends Controller
{
  

    public function Api(Request $request){

        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['name'] = $resp['name'];
        $data['email'] = $resp['email'];
        $data['message'] = $resp['message'];
        $data['customer'] = $resp['uid'];
       

        $user = Contact::create($data);
        $success = true;
    
         return response()
            ->json(compact('success'));

    }

   
 }