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
use App\Http\Models\Chatroom;
use App\Http\Models\Chatuser;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;




class ChatController extends Controller
{
    
    public function get(Request $request,$room){

        //

        $messages =  Chat::join('customer','customer.id','=','chatbox.customer')->where('room',$room)
        ->orderby('chatbox.id','desc')->limit(25)->get();
        
        $data = array();
        foreach ($messages as $message) {
            $user = array(
                '_id' => $message->customer,
                'name' => $message->name
            );
            $data[] = array(
                'text' => $message->message,
                '_id' => $message->chatid,
                'sent' => true,
                'createdAt' => $message->chattimeat,
                'user' => $user

            );
        }

       




        return response()
            ->json(compact('data'));

    }

    public function rooms(){
        $rooms = Chatroom::get();

        return response()->json(compact('rooms'));
    }

    public function chatuser(Request $request){
         $resp = json_decode($request->getContent(), true);
         $data = array();
         $data['room'] = $resp['room'];
         $data['customer'] = $resp['customer'];
         $data['status'] = 1;

         $chatuser =Chatuser::where('room',$data['room'])->where('customer',$data['customer']);

         if($chatuser->count() > 0 ){
            $user = $chatuser->first();
            //check for bend 
            if($user->status == 2){
                $fail = 1;
                return response()->json(compact('fail'));
            } else {
                $pass = 1;
                return response()->json(compact('pass'));
            }
            
         } else {

            $chat = Chatuser::create($data);
            $pass = 1;
            return response()->json(compact('pass'));

         }
        
    }

    public function apiPost(Request $request,$room){
        $resp = json_decode($request->getContent(), true);
       
        $data = array();

        $chat = new Chat;
        $chat->chatid = $resp['_id'];
        $chat->customer = $resp['user']['_id'];
        $chat->message = mb_strtolower($resp['text']);
        $chat->room = $room;
        $chat->chattimeat = $resp['createdAt'];
        $chat->save();



        //echo $chat = Chat::create($data);


    }

}
