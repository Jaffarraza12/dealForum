@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ 'Category'}}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.category.update", [$category->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('put')
            <table class="table">
                 <tr>
              @foreach($languages as $lang)
                    <td>
                        <div class="form-group {{ $errors->has('name.'.$lang->code) ? 'has-error' : '' }} ">
                            <label for="name'[{{ $lang->code}}]">{{ trans('cruds.user.fields.name').' in '.$lang->code }}*</label>
                            <input type="text" id="name'[{{ $lang->code}}]" name="name[{{ $lang->code}}]" class="form-control" value="{{ old('name.'.$lang->code, isset($categoryDetail[$lang->code]) ? $categoryDetail[$lang->code]['name'] : '')  }}" >
                           @if($errors->has('name.'.$lang->code)) 
                                <em class="invalid-feedback">
                                    {{ $errors->first('name.'.$lang->code) }}
                                </em>
                            @endif
                            <p class="helper-block">    {{ trans('cruds.user.fields.name_helper') }} </p>
                           
                        </div>
                      </td>  
                   
            @endforeach
            </tr> 
            </table>
            
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">Slug*</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($category) ? $category->slug : '') }}" >
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
               
            </div>


          <div class="form-group {{ $errors->has('icontype') ? 'has-error' : '' }}">
                <label for="slug">Icon is Image</label>
                <input type="checkbox"   id="icontype" value="1"  name="icontype"  value="1"  {{ ($category->icontype ==  1) ? 'checked="checked"' : '' }} style="margin-left:10px;" />
                @if($errors->has('icontype'))
                    <em class="invalid-feedback">
                        {{ $errors->first('icontype') }}
                    </em>
                @endif
               
            </div>   



             <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="slug">Image</label>
                  <a ><img  data-input="input-image"  id="thumb-image" class="img-thumbnail"  width="100" height="auto" id="img-image"  src="{{  ($category->image) ?   'https://deal-forum.com/asset'.$category->image  : 'https://deal-forum.com/asset'.$img_thumb }}" alt="" title="" data-placeholder="{{ 'Image' }}" /></a>
                <input type="hidden" name="image" value="{{ (old('image')) ? old('image') : $category->image }}" id="input-image" />

                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>
           
         
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection