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
        if( Customer::where('email',$request->email)->count() > 0){
            return response()
            ->json(Customer::where('email',$request->email)->first());

        }

        $user = Customer::create($request->all());
        $lastInsertedId = $user->id; 
        return response()
            ->json(Customer::where('id',$lastInsertedId)->first());

    }
}
