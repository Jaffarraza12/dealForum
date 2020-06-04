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

        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['fbid'] = $request->fbid;
        $data['goid'] = $request->goid;
        print_r( $request->all());        
        echo json_encode($data);
        exit;

        if( Customer::where('email',$request->email)->count() > 0){
            return response()
            ->json(Customer::where('email',$request->email)->get());

        }

        $user = Customer::create($data);
        $lastInsertedId = $user->id; 
        return response()
            ->json(Customer::where('id',$lastInsertedId)->get());

    }
}
