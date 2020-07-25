@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Settings
    </div>

    <div class="card-body">
        <form action="{{ route("admin.setting") }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @foreach($settings as $setting)
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name" style="text-transform: capitalize;">{{ str_replace('-',' ',$setting->key)  }}*</label>
                <input type="{{ $setting->type }}" id="{{ $setting->key }}" name="{{ $setting->key }}" class="form-control" value="{{ old( $setting->key ,  $setting->value) }}" required>
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.name_helper') }}
                </p>
            </div>
            @endforeach
            <div class="card-header">
               Slider For Mobile App
            </div>
           <div class="container " >
              <div class="row sliderContent">
                <div class="col-sm">
                    <div class="form-group">
                          <label>Image</label>
                          <a ><img  data-input="input-image"  id="thumb-image" class="img-thumbnail"  width="100" height="auto" id="img-image"  src="{{  (old('image')) ?   'https://deal-forum.com/asset'.old('image')  : 'https://deal-forum.com/asset'.$img_thumb }}" alt="" title="" data-placeholder="{{ 'Image' }}" /></a>
                         <input type="hidden" name="silderImage[]" value="" />
                        </div>
                    </div>
                <div class="col-sm">
                    <div class="form-group">
                          <label>Title</label>
                          <input type="text"  name="silderTitle[]" class="form-control" value="" >
                     </div>
                </div>
                <div class="col-sm">
                 <div class="form-group">
                          <label>Links</label>
                          <input type="text"  name="silderLink[]" class="form-control" value="" >
                     </div>
                </div>
              </div>
              <a style="float:right;text-align: right;">Add Slide</a>
            </div>
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>


        </form>

        



    </div>
    



</div>
@endsection