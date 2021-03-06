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


     public function __construct(Request $request)
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
        $img_thumb =   $this->image_thumb ;  
        $settings =Setting::where('type','!=','json')->get();
        $slider =Setting::where('key','slider_content')->first();
        $slider_content = json_decode($slider->value);
        $help =Setting::where('key','help_content')->first();
        $help_content = json_decode($help->value);


        return view('admin.setting.edit',compact('settings','img_thumb','slider_content','help_content'));
    }

    public function save(Request $request){
    	if (! Gate::allows('users_manage')) {
            return abort(401);
        }
         foreach ($request->all() as $key => $value) {
            if($key == '_method' || $key == '_token' || $key == 'silderImage' || $key == 'silderTitle' ||  $key == 'silderLink' ||  $key == 'HelpAnswer' ||  $key == 'HelpQuestion'   ){
        		continue;
        	} else {
        		Setting::where('key',$key)->update(['value' => $value]);
        		
        	}
        }
        $i = 0;
        $slider = array();
        foreach($request->silderImage as $img) {
            if(!empty($img)){
                $slider[] = array(
                    'title' => $request->silderTitle[$i] ,
                    'link' => $request->silderLink[$i] ,
                    'image' => $img
                ); 
            }
            ++$i;
          } 
        Setting::where('key','slider_content')->update(['value' => json_encode($slider) ]);


        $i = 0;
        $helpContent = array();
        foreach($request->HelpQuestion as $question) {
            if(!empty($question)){
                $helpContent[] = array(
                    'question' => $question ,
                    'answer' => $request->HelpAnswer[$i] ,
                    
                ); 
            }
            ++$i;
          } 
        Setting::where('key','help_content')->update(['value' => json_encode($helpContent) ]);    
   
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
