@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.news_sub_category.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.news_sub_categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.news_sub_category.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.news_sub_category.fields.name_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="category_id">{{ trans('cruds.news_sub_category.fields.news_category_id') }}</label>

                <select class="form-control select2 {{ $errors->has('news_category_id') ? 'is-invalid' : '' }}" name="news_category_id" id="news_category_id"  required>
                    @foreach($news_categories as $id => $value)
                        <option value="{{ $id }}" {{ in_array($id, old('value', [])) ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @if($errors->has('news_category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('news_category_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.news_sub_category.fields.news_category_id_helper') }}</span>
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
