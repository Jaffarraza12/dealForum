@extends('layouts.model')

@section('css')
    <link href="{{asset('assets/css/component.css')}}" />
    <style>
        body{
            background: #eeeaf2 !important;
        }
        .header_container {
            min-height:30px;
            margin-top:20px;
            margin-bottom:20px;
        }
        .header_container .btn-default{
            color: #262626 !important;
        }
        .header_container .btn-default:hover {
            background: transparent;
        }
        .header_container .btn-file,.header_container .btn-danger {
            color:#fff !important;
        }
        .header_container .btn-file{
            background: #1878cf;
            border:1px solid  #1878cf;
        }
        hr{
            background: #878787;
            height:2px;
        }
        .directory i{color:#ff920b}
        li{list-style:none;}
        a.directory{
            font-size:72px;
            color: #ff920b;
            cursor:pointer;

        }.file a{
            font-size:72px;
            color: #000;
            cursor:pointer;


        }

         a.directory:hover,.file a:hover{
            text-decoration:none;
        }
        .directory span,.file span{
            font-size:16px;
            display:block;
            color:#000;


        }
        .box{
            /*/ #dfc8ca;*/
            background-color: #d9534f;
            padding:4px 10px;
            display:inline-block;
            color:#fff;
            text-align:center;
            width:150px;
            border-radius:6%;
        }
        input[type="checkbox"]{
            float:left !important;
            margin-right:10px;
            width: 20px;
            margin-top: -6px;

        }
        .createDIR{
            position:absolute;
            width:585px;
            padding:10px 0px;
            display: none;
        }

        .createDIR input[name="dirname"]{
            width:70%;
            float:left;
        }
        .createDIR button{
            float:left;
            width:10%;
            dislay:inline-block
        }

    </style>
  {{--  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
--}}@endsection

<div class="container">
    <div class="header_container" style="posotion:relative">
         <a class="btn btn-default" @if($URL) href="{{$URL}}" @endif >BACK</a>
         <a class="btn btn-file" id="createDirectory" onclick="$('.createDIR').show()">CREATE DIRECTORY</a>
         <div class="createDIR" >
             <div class="form-group">
                 <input type="text" name="dirname" class="form-control" /><button type="button" class="btn btn-file createDIRAction"  >SAVE</button>
             </div>
             <div class="clearfix"></div>
             <a style="pointer:cursor;" onclick="$('.createDIR').hide()"><small>Close this</small></a>
         </div>
         <div class="box">
             <form name="fileinfo" id="fileinfo" enctype="multipart/form-data" style="height:13px;">
                 {!! csrf_field() !!}
            <input style="width:0px;height:0px;" type="file" name="file-1[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
            <label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Choose a file&hellip;</span></label>

             </form>
         </div>
        <a id="delete_button" class="btn btn-danger" disabled="disabled">Remove</a>
        @if($request->multiple)
        <a id="delete_button" class="btn btn-danger multi" >Select Muiltiple</a>
        @endif

    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <div class="alert-text">{{ Session::get('success') }}</div>
            </div>
        @endif
        @if(Session::has('failed'))
            <div class="alert alert-danger" role="alert">
                <div class="alert-text">{{ Session::get('failed') }}</div>
            </div>
        @endif
            @if(Session::has('warning'))
            <div class="alert alert-warning" role="alert">
                <div class="alert-text">{{ Session::get('warning') }}</div>
            </div>
        @endif
    </div>
</div>

@section('content')

    @foreach($directories as $directory)
        <li class="col-sm-3 " > <a data-dir="{!! basename($directory) !!}" class="directory"> <i class="fa fa-folder"></i>  </a><div style="margin-top:15px;"><input value="{!! basename($directory) !!}" class="form-control" type="checkbox" name="rmvfolders[]" > <span>{!! basename($directory) !!}</span></div></li>
    @endforeach

    @foreach($images as $file)
        <li class="col-sm-3 file" style="min-height:100px;padding:10px 5px;margin:10px 0px; overflow:hidden;"> <a   > <img data-dir="{{$dir}}" data-file="{!! basename($file) !!}" class="img"  src="{{$file}}" width="56" />  </a> <div style="margin-top:15px;"><input value="{!! basename($file) !!}" class="form-control" type="checkbox" name="delete[]" data-dir="{{$dir}}" data-file="{!! basename($file) !!}" data-src="{{$file}}" > <span>{!! basename($file) !!}</span></div></li>
    @endforeach
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('input[name="delete[]"],input[name="rmvfolders[]"]').click(function () {
                    if($('input[name="delete[]"]:checked').length > 0 || $('input[name="rmvfolders[]"]:checked').length >0 )   $('#delete_button').removeAttr('disabled')
                    else  $('#delete_button').attr('disabled','disabled')
              });


            $('#delete_button').click(function () {
              if (confirm('Are you sure you want to remove selected files ')) {
                        var data = {'images[]': []};
                        $('input[name="delete[]"]:checked').each(function (i) {
                            data['images[' + i + ']'] = $(this).val();
                        });
                        $('input[name="rmvfolders[]"]:checked').each(function (i) {
                             data['folders[' + i + ']'] = $(this).val();
                         });
                        data['_method'] = 'delete'
                        data['_token'] = $('input[name="_token"]').val()
                        data['directory'] = '{{$dir}}'
                        $.ajax({
                            method: 'POST',
                            url: '{{URL('/file-manager-remove')}}',
                            data: data,
                            dataType: 'json',
                            success: function (resp) {
                                window.location.reload()
                            },
                            error: function () {
                            }
                        })
                    }
            })

            $('.createDIRAction').click(function(){
                if($('input[name="dirname"]').val()){
                    $.ajax({
                        method: 'POST',
                        url: '{{URL('/file-manager-folder')}}',
                        data: { '_token': $('input[name="_token"]').val(),'folder':$('input[name="dirname"]').val(),'directory':'{{$dir}}'},
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.redirect) {
                                window.location.reload()
                            }
                        },
                        error: function () {
                        }
                    })

                }else {
                    alert('DIR name should not be empty;')
                }
            })



            $('.directory').click(function () {
                var dir = $(this).data('dir');

                if(window.location.href.indexOf("&dir") > 0) {
                    window.location = window.location.href+'/'+dir

                } else {
                     window.location = window.location.href+'&dir='+dir

                }
                });


            $('.img').click(function () {
                @if($request->multiple != 0)
                    alert('Select with Muiltiple Button')
                @else
                parent.$('#{{$request->elem}}').val($(this).data('dir')+'/'+$(this).data('file'))
                parent.$('#{{$request->show}}').attr('src',$(this).attr('src'))
                parent.$('#jr_modal').modal('toggle');
                @endif

            });
            $('.multi').click(function () {
                var html = ''
                parent.$('#product-image-row').html(html)
                $('input[name="delete[]"]:checked').each(function (ind) {
                      html = '<tr><td><a><img data-multiple="'+ind+'"  data-input="input-product-image-'+ind+'"  id="thumb-product-image-'+ind+'" class="img-thumbnail"  width="100" height="auto" id="img-image"  src="'+$(this).data('src')+'" alt="" title="" data-placeholder="{{ 'Image' }}" /></a>'
                    html +='<input id="input-product-image-'+ind+'" type="hidden" name="product_images[]" value="'+$(this).data('dir')+'/'+$(this).data('file')+'"  /></td>'
                    html +='<td><br/><input type="number" class="form-control"  name="product_images_sort_order[]" value="0"  /></td></tr>';
                    parent.$('#product-image-row').append(html)
                    parent.$('#jr_modal').modal('toggle')
                })
            });
        });



        'use strict';

        ;( function ( document, window, index )
        {

            var inputs = document.querySelectorAll( '.inputfile' );
            Array.prototype.forEach.call( inputs, function( input )
            {
                var label	 = input.nextElementSibling,
                    labelVal = label.innerHTML;

                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else
                        fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName;
                    else
                        label.innerHTML = labelVal;

                    event.preventDefault();
                    var image_upload = new FormData();
                    var TotalImages = $('#file-1')[0].files.length;  //Total Images
                    var images = $('#file-1')[0];

                    for ( i = 0; i < TotalImages; i++) {
                        image_upload.append('images[' + i +']', images.files[i]);
                    }
                    image_upload.append('TotalImages', TotalImages);
                    image_upload.append('_token', $('input[name="_token"]').val());
                    image_upload.append('directory','{{$dir}}');

                    $.ajax({
                        method: 'POST',
                        url: '{{URL('/file-manager')}}',
                        data: image_upload,
                        contentType: false,
                        dataType: 'json',
                        processData: false,
                        success: function (resp) {
                            window.location.reload()
                        },
                        error: function () {
                        }
                    })


                });

                // Firefox bug fix
                input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
                input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
            });
        }( document, window, 0 ));
    </script>
@endsection