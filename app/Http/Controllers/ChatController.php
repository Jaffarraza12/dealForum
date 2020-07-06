<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Companies;
use App\Http\Models\Admin\Category;
use App\Http\Requests\CompaniesStoreRequest;
use App\Http\Requests\CompaniesUpdateRequest;
use Illuminate\Support\Facades\Gate;
use App\User;
use App\Http\Models\Chat;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;




class ChatController extends Controller
{
    
    public function get(Request $request){

        return response()
            ->json(compact('companies'));

    }

    public function apiPost(Request $request,$room){
        $resp = json_decode($request->getContent(), true);
        print_r($resp);
        $data = array();
        $data['chatid'] = $resp['_id'];
        $data['customer'] = $resp['user']['_id'];
        $data['message'] = $resp['text'];
        $data['room'] = $room;

        $chat = Chat::create($data);

    }

}
