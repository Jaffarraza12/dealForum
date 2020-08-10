<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Auth;
use App;

class FileManager extends Controller
{
    var $HTTPS_CATALOG;
    var $DIR_IMAGE;

     public function __construct(Request $request)
    {
     
        if($request->getHttpHost() == 'localhost') {
            $this->HTTPS_CATALOG = 'http://localhost/carve/resources/catalog';
            $this->DIR_IMAGE = 'C:\xampp\htdocs\carve\resources\catalog';
        } else {
            if (Gate::allows('users_manage') {
                $this->HTTPS_CATALOG = 'https://deal-forum.com/asset';
                $this->DIR_IMAGE = '/home/dealforum/public_html/asset';
            } else {

            $this->HTTPS_CATALOG = 'https://deal-forum.com/asset/users/'.Auth::user()->id;
            $this->DIR_IMAGE = '/home/dealforum/public_html/asset/users/'.Auth::user()->id;

            }
        }
    }

    public function index( Request $request) {
        $dir = '';
        $search = '';
        if ($request->dir) {
            $dir =     '/'.$request->dir ;
        } else {
        }

        // Parent
        $URL = '';
        if (isset($request->dir)) {
            $pos = strrpos($request->dir, '/');

            if ($pos) {
                $URL .= URL('file-manager?elem='.$request->elem.'&show='.$request->show.'&multiple='.$request->multiple).'&dir=' . urlencode(substr($request->dir, 0, $pos));
            }else {
                $URL = URL('file-manager?elem='.$request->elem.'&show='.$request->show.'&multiple='.$request->multiple);
            }
        }



        // Make sure we have the correct directory

         $files = glob($this->DIR_IMAGE.$dir."/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}", GLOB_BRACE );
         $images = array();
         $i =0 ;
         foreach ($files as $file){
            $images[$i] =  $this->HTTPS_CATALOG .$dir.'/'.basename($file);
            $i++;
         }




        $directories = glob($this->DIR_IMAGE.$dir.'/*', GLOB_ONLYDIR);

        return view('admin.fileManager',compact('directories','images','dir','URL','request'));

    }

    public function upload(Request $request) {
        $json = array();
        if($request->hasFile('images')) {
            $allowedfileExtension = ['jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF'];
            $files = $request->file('images');
            $i=0;
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                $filepath = $this->DIR_IMAGE.'/';
                if($request->directory){
                    $filepath = $filepath.$request->directory.'/';
                }

                if ($check) {
                   move_uploaded_file($_FILES['images']['tmp_name'][$i], $filepath.$filename);
                    ++$i;
                    Session::flash('success', 'Files Has been Uploaded.');

                } else {
                    Session::flash('warning', 'Your are trying to upload file which is not as image .');
                }
            }
        }



        echo  json_encode($json);



    }

    public function folder(Request $request) {

        $filepath = $this->DIR_IMAGE.'/';
        $url = '/file-manager';
        if($request->directory){
            $filepath = $filepath.$request->directory.'/';
            $url = $url.'?dir='.$request->directory;
        }


        if (file_exists($filepath.$request->folder)) {
            Session::flash('failed', 'Folder with this name already exist.');
        } else {
            mkdir($filepath.$request->folder, 0777);
            chmod($filepath.$request->folder, 0777);
            Session::flash('success', 'Folder has been created.');
        }

        $json['redirect'] =   URL($url ) ;
        echo json_encode($json);

       /* if (!isset($json['error'])) {
            mkdir($directory . '/' . $folder, 0777);
            chmod($directory . '/' . $folder, 0777);

            @touch($directory . '/' . $folder . '/' . 'index.html');

            $json['success'] = $this->language->get('text_directory');
        }*/


    }

    public function delete(Request $request) {
        $filepath = $this->DIR_IMAGE.'/';
        $url = '/file-manager';
        $error = false;
        if($request->directory){
            $filepath = $filepath.$request->directory.'/';
            $url = $url.'?dir='.$request->directory;
        }
        if($request->images) {
            foreach ($request->images as $img) {
                $path = $filepath . $img;
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }
        if($request->folders) {
            foreach ($request->folders as $folder) {
                $fpath = $filepath . $folder;
                if($this->dir_is_empty($fpath))
                {
                    if (is_dir($fpath)) {
                        rmdir($fpath);
                    }
                } else {
                    Session::flash('failed', 'Folder is not empty.');
                    $error = true;
                    $json['redirect'] = URL($url);
                    echo json_encode($json);



                }

            }
        }
        if(!$error){
            Session::flash('success', 'Files Has been removed.');

            $json['redirect'] = URL($url);
            echo json_encode($json);
        }

    }

    function dir_is_empty($dir) {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                closedir($handle);
                return FALSE;
            }
        }
        closedir($handle);
        return TRUE;
    }



}
