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
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection