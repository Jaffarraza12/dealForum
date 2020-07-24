<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Admin\Category;
use App\Http\Models\Admin\CategoryDetail;
use App\Http\Models\Language;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;

use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    var $image_thumb ;
    public function __construct(Request $request) {

        if($request->getHttpHost() == 'localhost') { 
            $this->image_thumb = '/dealForum/public/images.png';
        } else {
            $this->image_thumb = '/Image/images.png';
       
        }

    }
    public function index()
    {
        //
        $categories = Category::Orderby('id','desc')->get();
        $detail =  array();
        foreach ($categories as $cat) {
              foreach (Language::get() as $lang){
                   $detail [$cat->id][$lang->code] = Category::find($cat->id)->info()->where('language',$lang->code)->first();
   
            }
        }
        return view('admin.category.index',compact('categories','detail'));

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $languages = Language::get();
         $img_thumb =  $this->image_thumb ;
         return view('admin.category.create',compact('languages','img_thumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

        $category = new Category;
        $category->slug =  $request->slug; 
        $category->image =  $request->image;
        $category->icontype =  (int)$request->icontype;
       
        if ($category->save()) {
             response()->json(array('success' => true, 'last_insert_id' => $category->id), 200);
        }
        foreach ($request->name as $key => $value) {
                   $categoryDetail = new CategoryDetail;
                   $categoryDetail->category_id = $category->id;
                   $categoryDetail->name = $value;
                   $categoryDetail->language = $key;
                   $categoryDetail->save();
            }    
        return redirect()->route('admin.category.index');;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }

         $category = Category::where('id',$id)->first();
         $categoryDetail = array();
         foreach (Language::get() as $lang){
                   $categoryDetail[$lang->code] = Category::find($category->id)->info()->where('language',$lang->code)->first();
   
          }
          if(!isset($category->image) || empty($category->image)  || $category->image ==' '){
            $img_thumb =   $this->image_thumb ;    
        } else {
            $img_thumb = $category->image; 
        }
        
         $languages = Language::get();
         

         return view('admin.category.edit',compact('category','categoryDetail','languages','img_thumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        //
         if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $category = Category::find($id);
        $category->slug =  $request->slug; 
        $category->image =  $request->image;
        $category->icontype = (int) $request->icontype;
        $category->save();
        foreach ($request->name as $key => $value) {
                   $categoryDetail = CategoryDetail::where('category_id',$id)->where('language',$key)->first();
                   $categoryDetail->category_id = $category->id;
                   $categoryDetail->name = $value;
                   $categoryDetail->language = $key;
                   $categoryDetail->save();
            }    
        return redirect()->route('admin.category.index');;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $category = Category::findOrFail($id);
        $category->delete();
        $categoryDetail = CategoryDetail::where('category_id',$id)->delete();
      
        return redirect()->route('admin.category.index');
    }    

     public function massDestroy(Request $request)
    {
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        Category::whereIn('id', request('ids'))->delete();
        CategoryDetail::whereIn('category_id', request('ids'))->delete();

        return response()->noContent();
    }

    public function api(Request $request){
        $category = Category::join('category-detail', 'category.id', '=', 'category-detail.category_id')->where('language','en')->get();
        return response()
            ->json(compact('category'));


    }
}

    
