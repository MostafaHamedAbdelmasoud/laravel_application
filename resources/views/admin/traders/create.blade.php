@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.trader.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.traders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="images">{{ trans('cruds.trader.fields.images') }}</label>
                <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                </div>
                @if($errors->has('images'))
                    <div class="invalid-feedback">
                        {{ $errors->first('images') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.images_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.trader.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.trader.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.trader.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}">
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="details">{{ trans('cruds.trader.fields.details') }}</label>
                <input class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="text" name="details" id="details" value="{{ old('details', '') }}">
                @if($errors->has('details'))
                    <div class="invalid-feedback">
                        {{ $errors->first('details') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.details_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facebook_url">{{ trans('cruds.trader.fields.facebook_url') }}</label>
                <input class="form-control {{ $errors->has('facebook_url') ? 'is-invalid' : '' }}" type="text" name="facebook_url" id="facebook_url" value="{{ old('facebook_url', '') }}">
                @if($errors->has('facebook_url'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facebook_url') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.facebook_url_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp">{{ trans('cruds.trader.fields.whatsapp') }}</label>
                <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', '') }}">
                @if($errors->has('whatsapp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.whatsapp_helper') }}</span>
            </div>



            <div class="form-group">
                <label for="activeness">{{ trans('cruds.trader.fields.activeness') }}</label>
                <input class="form-control {{ $errors->has('activeness') ? 'is-invalid' : '' }}" type="text" name="activeness" id="activeness" value="{{ old('activeness', '') }}">
                @if($errors->has('activeness'))
                    <div class="invalid-feedback">
                        {{ $errors->first('activeness') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.trader.fields.activeness_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.traders.storeMedia') }}',
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
@if(isset($trader) && $trader->images)
      var files = {!! json_encode($trader->images) !!}
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
