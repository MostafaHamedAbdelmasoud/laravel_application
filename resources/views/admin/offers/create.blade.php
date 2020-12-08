@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.offer.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.offers.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.offer.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="description">{{ trans('cruds.offer.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description" value="{{ old('description', '') }}" required></textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.description_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="category_id">{{ trans('cruds.offer.fields.category') }}</label>
                    <select class="form-control select2 {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            name="category_id" id="category_id" required>
                        @foreach($categories as $id => $category)
                            <option
                                value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.category_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="sub_category_id">{{ trans('cruds.offer.fields.sub_category') }}</label>
                    <select class="form-control select2 {{ $errors->has('sub_category') ? 'is-invalid' : '' }}"
                            name="sub_category_id" id="sub_category_id" required>

                    </select>
                    @if($errors->has('sub_category'))
                        <div class="invalid-feedback">
                            {{ $errors->first('sub_category') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.sub_category_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="add_date">{{ trans('cruds.offer.fields.add_date') }}</label>
                    <input class="form-control date {{ $errors->has('add_date') ? 'is-invalid' : '' }}" type="text"
                           name="add_date" id="add_date" value="{{ old('add_date') }}" required>
                    @if($errors->has('add_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('add_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.add_date_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date_end">{{ trans('cruds.offer.fields.date_end') }}</label>
                    <input class="form-control date {{ $errors->has('date_end') ? 'is-invalid' : '' }}" type="text"
                           name="date_end" id="date_end" value="{{ old('date_end') }}" required>
                    @if($errors->has('date_end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_end') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.date_end_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone_number">{{ trans('cruds.offer.fields.phone_number') }}</label>
                    <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text"
                           name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}" required>
                    @if($errors->has('phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.phone_number_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="location">{{ trans('cruds.offer.fields.location') }}</label>
                    <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text"
                           name="location" id="location" value="{{ old('location', '') }}" required>
                    @if($errors->has('location'))
                        <div class="invalid-feedback">
                            {{ $errors->first('location') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.location_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="price">{{ trans('cruds.offer.fields.price') }}</label>
                    <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number"
                           name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                    @if($errors->has('price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.price_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="trader_id">{{ trans('cruds.offer.fields.trader') }}</label>
                    <select class="form-control select2 {{ $errors->has('trader') ? 'is-invalid' : '' }}"
                            name="trader_id" id="trader_id">
                        @foreach($traders as $id => $trader)
                            <option
                                value="{{ $id }}" {{ old('trader_id') == $id ? 'selected' : '' }}>{{ $trader }}</option>
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
                    <label for="city_id">{{ trans('cruds.offer.fields.city') }}</label>
                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"
                            name="city_id" id="city_id">
                        @foreach($cities as $id => $city)
                            <option
                                value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.city_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="images">{{ trans('cruds.offer.fields.images') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}"
                         id="images-dropzone">
                    </div>
                    @if($errors->has('images'))
                        <div class="invalid-feedback">
                            {{ $errors->first('images') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.offer.fields.images_helper') }}</span>
                </div>


                <div class="form-group">
                    <div class="form-check {{ $errors->has('show_in_main_page') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="show_in_main_page" id="show_in_main_page"
                               value="1"
                            {{ old('show_in_main_page', 0) == 1 ? 'checked' : '' }}>
                        <label class="required form-check-label"
                               for="show_in_main_page">{{ trans('cruds.product.fields.show_in_main_page') }}</label>
                    </div>
                    @if($errors->has('show_in_main_page'))
                        <div class="invalid-feedback">
                            {{ $errors->first('show_in_main_page') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.show_in_main_page_helper') }}</span>
                </div>

                <div class="form-group">
                    <div class="form-check {{ $errors->has('show_in_trader_page') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="show_in_trader_page"
                               id="show_in_trader_page" value="1"
                            {{ old('show_in_trader_page', 0) == 1 ? 'checked' : '' }}>
                        <label class="required form-check-label"
                               for="show_in_trader_page">{{ trans('cruds.product.fields.show_in_trader_page') }}</label>
                    </div>
                    @if($errors->has('show_in_trader_page'))
                        <div class="invalid-feedback">
                            {{ $errors->first('show_in_trader_page') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.product.fields.show_in_trader_page_helper') }}</span>
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
    @include('admin.offers.components.form_scripts',['token'=>$token,'sub_category_id'=>isset($offer)?$offer->sub_category_id:'0'])
    <script>
        var uploadedImagesMap = {}
        Dropzone.options.imagesDropzone = {
            url: '{{ route('admin.offers.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
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
                $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                uploadedImagesMap[file.name] = response.name
            },
            removedfile: function (file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedImagesMap[file.name]
                }
                $('form').find('input[name="images[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($offer) && $offer->images)
                var files =
                {!! json_encode($offer->images) !!}
                    for (var i in files) {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
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
