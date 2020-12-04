@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.custom_field.title_singular') }}
        </div>

        <div class="card-body">
            <form id="myForm" method="POST" action="{{ route("admin.custom_fields.store") }} " enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="type">{{ trans('cruds.custom_field.fields.type') }}</label>
                    <input class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" type="text" name="type"
                           id="type" value="{{ old('type', '') }}" required>
                    @if($errors->has('type'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.custom_field.fields.type_helper') }}</span>
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
