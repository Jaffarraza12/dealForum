<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Models\Admin\Setting;

class SettingController extends Controller
{
    //



     protected $redirectTo = '/admin/setting';
     var $image_thumb ;


     public function __construct()
    {
        $this->middleware('auth');
        if($request->getHttpHost() == 'localhost') { 
            $this->image_thumb = '/dealForum/public/images.png';
        } else {
            $this->image_thumb = '/Image/images.png';
       
        }
    }

    public function index()
    {
    	 if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $settings =Setting::get();
        return view('admin.setting.edit',compact('settings'));
    }

    public function save(Request $request){
    	if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        foreach ($request->all() as $key => $value) {
        	if($key == '_method' || $key == '_token'){
        		continue;
        	} else {
        		Setting::where('key',$key)->update(['value' => $value]);
        		
        	}
        	
        }
        return redirect($this->redirectTo)->with('message', 'Setting have been saved!');

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    }

}
