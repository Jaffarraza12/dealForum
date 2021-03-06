@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ 'Edit Deal'}}
    </div>

    <div class="card-body">
        <form action="{{ route("deals.update",$deal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('put')
           

           <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="name">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($deal) ? $deal->name : '') }}" >
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
               
            </div>

            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">Description*</label>
                <textarea name="description" id="description" class="form-control" >{{ (old('description')) ? old('description') : $deal->description }} </textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
               
            </div>

            
            <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                <label for="slug">Discount*</label>
                <input type="number" id="discount" name="discount" class="form-control" value="{{ old('discount', isset($deal) ? $deal->discount : '') }}" >
                @if($errors->has('discount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('discount') }}
                    </em>
                @endif
               
            </div>


             <div class="form-group {{ $errors->has('discount') ? 'has-error' : '' }}">
                <label for="slug">Contact Number*</label>
                <input type="text" id="contact" name="contact" class="form-control" value="{{ old('contact', isset($deal) ? $deal->contact : '') }}" >
                @if($errors->has('discount'))
                    <em class="invalid-feedback">
                        {{ $errors->first('contact') }}
                    </em>
                @endif
               
            </div>


           
             <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                 <label for="company">Company*</label>
                 <select name="company" id="company" class="form-control select2" >
                    <option>Select Options</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ (isset($deal->company_id) && $company->id == $deal->company_id) ? 'selected="selected"' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('company'))
                    <em class="invalid-feedback">
                        {{ $errors->first('company') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>
           




             <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="slug">Image</label>
                <a ><img  data-input="input-image"  id="thumb-image" class="img-thumbnail"  width="100" height="auto" id="img-image"  src="{{  (old('image')) ?   'https://deal-forum.com/asset'.old('image')  : 'https://deal-forum.com/asset'.$img_thumb }}"  alt="" title="" data-placeholder="{{ 'Image' }}" /></a>
                <input type="hidden" name="image" value="{{ old('image') }}" id="input-image" />
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