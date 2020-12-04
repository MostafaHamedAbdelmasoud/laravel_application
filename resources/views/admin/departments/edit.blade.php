@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.department.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.departments.update", [$department->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.department.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="logo">{{ trans('cruds.department.fields.logo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('logo') ? 'is-invalid' : '' }}" id="logo-dropzone">
                </div>
                @if($errors->has('logo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('logo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.logo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="about">{{ trans('cruds.department.fields.about') }}</label>
                <textarea class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{{ old('about', $department->about) }}</textarea>
                @if($errors->has('about'))
                    <div class="invalid-feedback">
                        {{ $errors->first('about') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.about_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="city_id">{{ trans('cruds.department.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id" required>
                    @foreach($cities as $id => $city)
                        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $department->city->id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone_number">{{ trans('cruds.department.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $department->phone_number) }}" required>
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="category_id">{{ trans('cruds.department.fields.category') }}</label>
                <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category_id" id="category_id">
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ (old('category_id') ? old('category_id') : $department->category->id ?? '') == $id ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.category_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="category_id">{{ trans('cruds.department.fields.sub_category') }}</label>
                <select class="form-control select2 {{ $errors->has('sub_category') ? 'is-invalid' : '' }}"
                        name="sub_category_id" id="sub_category_id">
                    {{--                        @foreach($categories as $id => $sub_category)--}}
                    {{--                            <option--}}
                    {{--                                value="{{ $id }}" {{ old('sub_category_id') == $id ? 'selected' : '' }}>{{ $sub_category }}</option>--}}
                    {{--                        @endforeach--}}
                </select>
                @if($errors->has('sub_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sub_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.department.fields.sub_category_helper') }}</span>
            </div>


            <div class="form-group">
                <label for="trader_id">{{ trans('cruds.offer.fields.trader') }}</label>
                <select class="form-control select2 {{ $errors->has('trader') ? 'is-invalid' : '' }}" name="trader_id" id="trader_id">
                    @foreach($traders as $id => $trader)
                        <option value="{{ $id }}" {{ (old('trader_id') ? old('trader_id') : $offer->trader->id ?? '') == $id ? 'selected' : '' }}>{{ $trader }}</option>
                    @endforeach
                </select>
                @if($errors->has('trader'))
                    <div class="invalid-feedback">
                        {{ $errors->first('trader') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.offer.fields.trader_helper') }}</span>
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

@php
    $user = \Illuminate\Support\Facades\Auth::User();
    $token = $user->createToken($user->email.'-'.now());
    $token = $token->accessToken;
@endphp

@include('admin.departments.components.form_scripts',['token'=>$token,'sub_category_id'=>$department->sub_category_id])

@section('scripts')

<script>



    Dropzone.options.logoDropzone = {
    url: '{{ route('admin.departments.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="logo"]').remove()
      $('form').append('<input type="hidden" name="logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($department) && $department->logo)
      var file = {!! json_encode($department->logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}
</script>
@endsection
