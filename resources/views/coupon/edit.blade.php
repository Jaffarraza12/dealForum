@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ 'Edit Coupon'}}
    </div>

    <div class="card-body">
        <form action="{{ route("coupons.update",$coupon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')
           

            <div class="form-group {{ $errors->has('company') ? 'has-error' : '' }}">
                 <label for="company">Company*</label>
                 <select name="company" id="company" class="form-control select2"  onchange="LoadDeals(this.value)">
                    <option>Select Options</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{  (  $companyS == $company->id ) ? 'selected="selected"' : '' }}>{{ $company->name }}</option>
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



            <div class="form-group {{ $errors->has('deal') ? 'has-error' : '' }}">
                 <label for="deal">Deal*</label>
                 <select name="deal" id="deal" class="form-control select2" >
                    <option>Select Options</option>
                     @foreach($deals as $deal)
                        <option value="{{ $deal->id }}" {{  ($coupon->deal == $deal->id) ? 'selected="selected"' : '' }}>{{ $deal->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('deal'))
                    <em class="invalid-feedback">
                        {{ $errors->first('deal') }}
                    </em>
                @endif
             </div>

            <div class="form-group {{ $errors->has('limit') ? 'has-error' : '' }}">
                <label for="slug">Limit</label>
                <input type="number" id="limit" name="limit" class="form-control" value="{{ old('limit', isset($coupon) ? $coupon->limit : '') }}" >
                @if($errors->has('limit'))
                    <em class="invalid-feedback">
                        {{ $errors->first('limit') }}
                    </em>
                @endif
               
            </div>

           <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                <label for="slug">Code*</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', isset($coupon) ? $coupon->code : '') }}" size="5">
                @if($errors->has('code'))
                    <em class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </em>
                @endif
                <em onclick="generateCode()" style="cursor: pointer;color:red;">Generate Code</em>
               
            </div>


             <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">Status</label>
               
            </div>



         

           
         
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
  
    function LoadDeals(id){
       $.get('../coupon-deal?id='+id, function(data, status){
            if(status == 'success'){
                option = ''
               $.each(data,function(ind,val){
                  option += '<option value="'+val.id+'">'+val.name+'</option>'


               })
               $('#deal').html('') 
               $('#deal').html(option) 
           }
           }); 
            
    }

    function generateCode(){
           len = 5
           var result           = '';
           var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
           var charactersLength = characters.length;
           for ( var i = 0; i < len; i++ ) {
              result += characters.charAt(Math.floor(Math.random() * charactersLength));
           }
          $('#code').val(result);
    }
            
        
</script>

@endsection