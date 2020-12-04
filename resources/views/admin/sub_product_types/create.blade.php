@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sub_product_type.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sub_product_types.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.sub_product_type.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sub_product_type.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="main_product_type_id">{{ trans('cruds.sub_product_type.fields.main_product_type_id') }}</label>

                <select class="form-control select2 {{ $errors->has('main_product_type_id') ? 'is-invalid' : '' }}" name="main_product_type_id" id="main_product_type_id"  required>
                    @foreach($main_product_types as $id => $value)
                        <option value="{{ $id }}" {{ in_array($id, old('value', [])) ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if($errors->has('main_product_type_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('main_product_type_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sub_product_type.fields.main_product_type_id_helper') }}</span>
            </div>


            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
