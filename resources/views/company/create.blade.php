@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ 'New Company'}}
    </div>

    <div class="card-body">
        <form action="{{ route("companies.store") }}" method="POST" enctype="multipart/form-data">
            @csrf 
           

           <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="slug">Name*</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', isset($company) ? $company->name : '') }}" >
                @if($errors->has('name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </em>
                @endif
               
            </div>

            
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="slug">Slug*</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', isset($company) ? $company->slug : '') }}" >
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
               
            </div>


            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="slug">Image</label>
                <input type="text" id="Image" name="image" class="form-control" value="{{ old('slug', isset($category) ? $category->image : '') }}" >
                @if($errors->has('image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.email_helper') }}
                </p>
            </div>


            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control select2" >
                    <option>Select Options</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['category_id'] }}" {{ old('category', isset($company) ? 'selected="selected"' : '') }}>{{ $category['name'] }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>

             <div class="form-group {{ $errors->has('users') ? 'has-error' : '' }}">
                <label for="category">Users </label>
                <select name="user" id="user" class="form-control select2" onchange=ShowUserForm() >
                    <option value="">Select Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"  >{{ $user->name.' <'.$user->email.'>' }}</option>
                    @endforeach
                </select>
                <em style="color:red;cursor:pointer;;" onclick="ShowUserForm();">Add New User</em>
                @if($errors->has('category'))
                    <em class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.user.fields.roles_helper') }}
                </p>
            </div>

            <div id="NewUsers" style="  @if($errors->has('user-name') || $errors->has('email') || $errors->has('password'))display:block;@else display:none;@endif border:1px solid #000;margin:20px;padding:20px 50px;" >
                <h2>New Users</h2>

                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    <label for="username">Name</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('userName') }}" >
                    @if($errors->has('username'))
                        <em class="invalid-feedback">
                            {{ $errors->first('username') }}
                        </em>
                    @endif
                 
                </div>


                 <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" value="{{ old('password') }}" >
                    @if($errors->has('password'))
                        <em class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.email_helper') }}
                    </p>
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" >
                    @if($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.user.fields.email_helper') }}
                    </p>
                </div>
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
    $(function(){
        ShowUserForm();
    })
 function ShowUserForm(){
    if($('#user').val()){
        $('#NewUsers').hide()   
    } else {
        $('#NewUsers').show() 
    }
   
 }


</script>
@endsection