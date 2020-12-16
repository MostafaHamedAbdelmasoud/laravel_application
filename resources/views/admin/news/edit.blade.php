@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.news.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.news.update", [$news->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.news.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', $news->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="image">{{ trans('cruds.news.fields.image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}"
                         id="image-dropzone">
                    </div>
                    @if($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.image_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="details">{{ trans('cruds.news.fields.details') }}</label>
                    <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" name="details"
                              id="details" required>{{ old('details', $news->details) }}</textarea>
                    @if($errors->has('details'))
                        <div class="invalid-feedback">
                            {{ $errors->first('details') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.details_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="details">{{ trans('cruds.news.fields.detailed_title') }}</label>
                    <textarea class="form-control {{ $errors->has('detailed_title') ? 'is-invalid' : '' }}"
                              name="detailed_title"
                              id="detailed_title" required>{{ old('detailed_title', $news->detailed_title) }}</textarea>
                    @if($errors->has('detailed_title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('detailed_title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.detailed_title_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="category_id">{{ trans('cruds.news.fields.news_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('news_category') ? 'is-invalid' : '' }}"
                            name="news_category_id" id="news_category_id" required>
                        @foreach($news_categories as $id => $news_category)
                            <option
                                value="{{ $id }}" {{ (old('news_category_id') ? old('news_category_id') : $news->news_category->id ?? '') == $id ? 'selected' : '' }}>{{ $news_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('news_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('news_category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.news_category_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="category_id">{{ trans('cruds.news.fields.news_sub_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('news_sub_category') ? 'is-invalid' : '' }}"
                            name="news_sub_category_id" id="news_sub_category_id" required>
                        @foreach($news_sub_categories as $id => $news_sub_category)
                            <option
                                value="{{ $id }}" {{ (old('news_sub_category_id') ? old('news_sub_category_id') : $news->news_sub_category->id ?? '') == $id ? 'selected' : '' }}>{{ $news_sub_category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('news_sub_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('news_sub_category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.news_sub_category_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="city_id">{{ trans('cruds.news.fields.city') }}</label>
                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id"
                            id="city_id" required>
                        @foreach($cities as $id => $city)
                            <option
                                value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $news->city->id ?? '') == $id ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.city_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="add_date">{{ trans('cruds.news.fields.add_date') }}</label>
                    <input class="form-control date {{ $errors->has('add_date') ? 'is-invalid' : '' }}" type="text"
                           name="add_date" id="add_date" value="{{ old('add_date', $news->add_date) }}" required>
                    @if($errors->has('add_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('add_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.add_date_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="phone_number">{{ trans('cruds.news.fields.phone_number') }}</label>
                    <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text"
                           name="phone_number" id="phone_number" value="{{ old('phone_number', $news->phone_number) }}"
                           required>
                    @if($errors->has('phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.phone_number_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.news.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="text"
                           name="price" id="price" value="{{ old('price', $news->price) }}"
                           required>
                    @if($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.price_helper') }}</span>
                </div>

                <div class="form-group">
                    <div class="form-check {{ $errors->has('approved') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="approved" id="approved"
                               value="1" {{ $news->approved || old('approved', 0) === 1 ? 'checked' : '' }} >
                        <label class="required form-check-label"
                               for="approved">{{ trans('cruds.news.fields.approved') }}</label>
                    </div>
                    @if($errors->has('approved'))
                        <div class="invalid-feedback">
                            {{ $errors->first('approved') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.news.fields.approved_helper') }}</span>
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




@section('scripts')
    @include('admin.news.components.form_scripts',['token'=>$token,'sub_category_id'=>isset($news)?$news->news_sub_category_id:'0'])
    <script>
        Dropzone.options.imageDropzone = {
            url: '{{ route('admin.news.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1000,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 4096,
                height: 4096
            },
            success: function (file, response) {
                // $('form').find('input[name="image[]"]').remove()
                $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
            },
            removedfile: function (file) {

                file.previewElement.remove();

                if (file.status !== 'error') {
                    $('form').find('input[value="'  + file.file_name + '"]').remove();
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($news) && $news->image)
                let file = {!! json_encode($news->getMedia('image')) !!};
                for (var i in file) {
                    this.options.addedfile.call(this, file[i])
                    // console.log(file[i]);
                    this.options.thumbnail.call(this, file[i], location.origin + '/storage/' + file[i].id + '/' + file[i].file_name)
                    file[i].previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="image[]" value="' + file[i].file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                }
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
