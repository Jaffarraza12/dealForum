@extends('layouts.admin')
@section('content')

<style>
  .card-header{
    font-size: 20px;
  }  
  .sliderContent{
    padding:20px;
  }
        
</style>

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
           <div class="container sliderContent" >
               @if($slider_content)
                @php $i = 0;@endphp
                @foreach($slider_content as $slider)
              <div  class="row sliderItem">
                <div class="col-sm">
                    <div class="form-group">
                          <label>Image</label>
                          <a ><img  data-input="input-image-{{$i}}"  id="thumb-image-{{$i}}" class="img-thumbnail"  width="100" height="auto" id="img-image"  src="{{  ($slider->image) ?   'https://deal-forum.com/asset'.$slider->image  : 'https://deal-forum.com/asset/Image/images.png' }}" alt="" title="" data-placeholder="{{ 'Image' }}" /></a>
                         <input id="input-image-{{$i}}" type="hidden" name="silderImage[]" value="{{$slider->image}}" />
                        </div>
                    </div>
                <div class="col-sm">
                    <div class="form-group">
                          <label>Title</label>
                          <input type="text"  name="silderTitle[]" class="form-control" value="{{$slider->title}}" >
                     </div>
                </div>
                <div class="col-sm">
                 <div class="form-group">
                          <label>Link</label>
                          <input type="text"  name="silderLink[]" class="form-control" value="{{$slider->link}}" >
                     </div>
                </div>
              </div>
               @php ++$i @endphp
              @endforeach
              @endif
             
            </div>
             <a id="addSlide" style="float:right;text-align: right;cursor: pointer;">Add Slide</a>

             <div style="clear: both"></div>

             <div class="card-header">
               Content for Help Screen 
            </div>
            <div class="container HelpContent" >
                @if($help_content)
                @php $i = 0;@endphp
                @foreach($help_content as $help)
              <div  class="row HelpItem">
                <div class="col-sm">
                    <div class="form-group">
                          <label>Question</label>
                          <input type="text"  name="HelpQuestion[]" class="form-control" value="{{$help->question}}">
                          
                        </div>
                    </div>
                <div class="col-sm">
                 <div class="form-group">
                          <label>Link</label>
                          <textarea name="HelpAnswer[]" class="form-control" value="">{{$help->answer}}</textarea>  
                     </div>
                </div>
              </div>
               @php ++$i @endphp
              @endforeach
              @endif
              
             
            </div>

             <a id="addItem" style="float:right;text-align: right;cursor: pointer;">Add Item</a>

             <div style="clear: both"></div>




            
            
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>

        



    </div>
    



</div>
@endsection
 @section('scripts')
<script>
    $(document).ready(function(){

        $('#addSlide').click(function(){
             sItem = $('.sliderItem').length

             Sliderhtml = '<div  class="row sliderItem"><div class="col-sm"> <div class="form-group"><label>Image</label><a ><img  data-input="input-image-'+sItem+'"  id="thumb-image-'+sItem+'" class="img-thumbnail"  width="100" height="auto" id="img-image-'+sItem+'"  src="https://deal-forum.com/asset/Image/images.png" alt=""  /></a> <input id="input-image-'+sItem+'" type="hidden" name="silderImage[]"  />  </div>                    </div><div class="col-sm"><div class="form-group"><label>Title</label><input type="text"  name="silderTitle[]" class="form-control" value="" ></div> </div><div class="col-sm"><div class="form-group"><label>Link</label><input type="text"  name="silderLink[]" class="form-control" / >                  </div> </div></div>';

                $('.sliderContent').append(Sliderhtml)
                FileManagerLoad()


        });

        $('#addItem').click(function(){
             sItem = $('.HelpItem').length

             Contenthtml = '<div class="row HelpItem"><div class="col-sm"><div class="form-group"> <label>Question</label> <input type="text" name="HelpQuestion[]" class="form-control" value=""></div></div><div class="col-sm"><div class="form-group"> <label>Answer</label><textarea name="HelpAnswer[]" class="form-control" value=""></textarea></div></div>';

                $('.HelpContent').append(Contenthtml)
               


        });
        
    })

    function FileManagerLoad(){
        $('.img-thumbnail').click(function () {
           var elem = $(this).data('input')
            var multiple = $(this).data('multiple')
            var show = $(this).attr('id')
            @if(request()->getHttpHost() == 'localhost')
            var serverPath = '/dealForum/public/file-manager'
            @else 
            var serverPath = '/public/file-manager'
            @endif
            $('.filemanager').attr('src',serverPath+'?elem='+elem+'&show='+show+'&multiple='+multiple)
            $('#jr_modal').modal('show')
        });
    }
</script>
@endsection