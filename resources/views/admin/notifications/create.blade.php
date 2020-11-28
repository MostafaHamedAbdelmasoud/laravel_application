@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.notification.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.notifications.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.notification.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                           id="title" value="{{ old('title', '') }}" required>
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.notification.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="content">{{ trans('cruds.notification.fields.content') }}</label>
                    <input class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" type="text"
                           name="content" id="content" value="{{ old('content', '') }}" required>
                    @if($errors->has('content'))
                        <div class="invalid-feedback">
                            {{ $errors->first('content') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.notification.fields.content_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="content">{{ trans('cruds.notification.fields.city_id') }}</label>
                    <select name="city_id[]" class="form-control" multiple>
                        <option></option>
                        @if(isset($cities))
                            @forelse($cities as $city)
                                <option value="{{$city->id}}">{{$city->name}}</option>
                            @empty

                            @endforelse
                        @endif
                    </select>
                    @if($errors->has('city_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.notification.fields.city_id_helper') }}</span>
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
