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
use Mail;


class ContactController extends Controller
{


    function mailer(){
        $contact =  Contact::where('id',1)->first();
        $data = array(
            'name'=> $contact->name,
            'email'=> $contact->email,
            'text'=> $contact->message
        );
       

         $sent = Mail::send('email.contact', $data, function($message) use($data) {
            $message->to('jaffaraza@gmail.com');
            $message->subject('Contact Message from APP');
        });

        if(!$sent) dd('Something wrong');
        
      

    }
  

    public function Api(Request $request){

        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['name'] = $resp['name'];
        $data['email'] = $resp['email'];
        $data['message'] = $resp['message'];
        $data['customer'] = $resp['uid'];
       

        $query = Contact::create($data);
        $success = true;


         $lastInsertedId = $query->id;
         $contact =  Contact::where('id',$lastInsertedId)->first();
         $data = array(
            'name'=> $contact->name,
            'email'=> $contact->email,
            'text'=> $contact->message
         );
       

         $sent = Mail::send('email.contact', $data, function($message) use($data) {
            $message->to('jaffaraza@gmail.com');
            $message->subject('Contact Message from APP');
        });
    
         return response()
            ->json(compact('success'));

    }

   
 }
