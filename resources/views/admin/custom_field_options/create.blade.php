@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.custom_field_option.title_singular') }}
        </div>

        <div class="card-body">
            <form id="myForm" method="POST" action="{{ route("admin.custom_field_options.store") }} " enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="required" for="products">{{ trans('cruds.custom_field_option.fields.products') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('products') ? 'is-invalid' : '' }}" name="products[]" id="products" multiple required>
                        @foreach($products as $id => $products)
                            <option value="{{ $id }}" {{ in_array($id, old('products', [])) ? 'selected' : '' }}>{{ $products }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('products'))
                        <div class="invalid-feedback">
                            {{ $errors->first('products') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.custom_field_option.fields.products_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="custom_fields">{{ trans('cruds.custom_field_option.fields.custom_fields') }}</label>

                    <select class="form-control select2 {{ $errors->has('custom_fields') ? 'is-invalid' : '' }}" name="custom_field_id" id="custom_field_id"  required>
                        @foreach($custom_fields as $id => $custom_fields)
                            <option value="{{ $id }}" {{ in_array($id, old('custom_fields', [])) ? 'selected' : '' }}>{{ $custom_fields }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('custom_fields'))
                        <div class="invalid-feedback">
                            {{ $errors->first('custom_fields') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.custom_field_option.fields.custom_fields_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="value">{{ trans('cruds.custom_field_option.fields.value') }}</label>
                    <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" value="text" name="value"
                           id="value" value="{{ old('value', '') }}" required>
                    @if($errors->has('value'))
                        <div class="invalid-feedback">
                            {{ $errors->first('value') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.custom_field_option.fields.value_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="additional_price">{{ trans('cruds.custom_field_option.fields.additional_price') }}</label>
                    <input class="form-control {{ $errors->has('additional_price') ? 'is-invalid' : '' }}" additional_price="text" name="additional_price"
                           id="additional_price" value="{{ old('additional_price', '') }}" required>
                    @if($errors->has('additional_price'))
                        <div class="invalid-feedback">
                            {{ $errors->first('additional_price') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.custom_field_option.fields.additional_price_helper') }}</span>
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
