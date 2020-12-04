@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.news_sub_category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.news_sub_categories.update", [$news_sub_category->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.news_sub_category.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $news_sub_category->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.news_sub_category.fields.name_helper') }}</span>
            </div>


            <div class="form-group">
                <label class="required" for="category_id">{{ trans('cruds.news_sub_category.fields.category_id') }}</label>

                <select class="form-control select2 {{ $errors->has('category_id') ? 'is-invalid' : '' }}" name="category_id" id="category_id"  required>
                    @foreach($categories as $id => $value)
                        <option value="{{ $id }}" {{ in_array($id, old('value', [$news_sub_category->category->id])) ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if($errors->has('category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.news_sub_category.fields.category_id_helper') }}</span>
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
