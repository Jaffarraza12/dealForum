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
use App\Http\Models\ReportUser;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;




class ChatController extends Controller
{


    public function index($room)
    {
        if (!Gate::allows(['users_manage'])) {
            return abort(401);
        }
        $rooms = Chatroom::get();
        $chatMessages = Chat::join('customer', 'customer.id', 'chatbox.customer')->where('room', $room)->get();
        $users = Chatuser::select('customer.name', 'customer.email', 'customer.id', 'chatuser.status')->join('customer', 'customer.id', 'chatuser.customer')->where('room', $room)->get();
        $roomId = $room;
        return view('chat.index', compact('rooms', 'chatMessages', 'users', 'roomId'));
    }

    public function get(Request $request, $room)
    {

        //

        $messages =  Chat::join('customer', 'customer.id', '=', 'chatbox.customer')->where('room', $room)
            ->orderby('chatbox.id', 'desc')->limit(25)->get();

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

    public function rooms()
    {
        $rooms = Chatroom::get();

        return response()->json(compact('rooms'));
    }

    public function chatuser(Request $request)
    {
        $resp = json_decode($request->getContent(), true);
        $data = array();
        $data['room'] = $resp['room'];
        $data['customer'] = $resp['customer'];
        $data['status'] = 1;

        $chatuser = Chatuser::where('room', $data['room'])->where('customer', $data['customer']);

        if ($chatuser->count() > 0) {
            $user = $chatuser->first();
            //check for bend 
            if ($user->status == 2) {
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

    public function apiPost(Request $request, $room)
    {
        $resp = json_decode($request->getContent(), true);
        $data = array();
        $chat = new Chat;
        $chat->chatid = $resp['_id'];
        $chat->customer = $resp['user']['_id'];
        $chat->message = $resp['text'];
        $chat->room = $room;
        $chat->chattimeat = $resp['createdAt'];
        $chat->save();
    }


    public function reportUser(Request $request)
    {
        $resp = json_decode($request->getContent(), true);
        $data = array();
        $check_report = ReportUser::where('user_for', $resp['_id'])
            ->where('user_by', $resp['user_id'])
            ->where('room', $resp['room'])
            ->first();
        if ($check_report) {
            $status = 'error';
            $message = 'You have already report this user before .This suppose to mean we have already take certain measure to prevent this heppenning.';
            return response()->json(compact('status', 'message'));
        }
        $report_user = new ReportUser;
        $report_user->user_for = $resp['_id'];
        $report_user->user_by = $resp['user_id'];
        $report_user->room = $resp['room'];
        $report_user->message = $resp['message'];;
        if ($report_user->save()) {
            $status = 'pass';
            $message = 'Thank you for report this . We will do further investigate and get back to you soon.';
            return response()->json(compact('status', 'message'));
        }
    }


    public function changeStatus(Request $request)
    {

        Chatuser::where('room', $request->room)
            ->where('customer', $request->customer)
            ->update(['status' => $request->status]);

        $success = true;
        return response()->json(compact('success'));
    }
}
