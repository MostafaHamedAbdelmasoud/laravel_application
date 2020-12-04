@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.coupon.title_singular') }}
        </div>

        <div class="card-body">
            <form id="myForm" method="POST" action="{{ route("admin.coupons.update", [$coupon->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="code">{{ trans('cruds.coupon.fields.code') }}</label>
                    <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code"
                           id="code" value="{{ old('code', $coupon->code) }}" required>
                    @if($errors->has('code'))
                        <div class="invalid-feedback">
                            {{ $errors->first('code') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.code_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required"
                           for="max_usage_per_user">{{ trans('cruds.coupon.fields.max_usage_per_user') }}</label>
                    <input class="form-control {{ $errors->has('max_usage_per_user') ? 'is-invalid' : '' }}"
                           type="number"
                           name="max_usage_per_user" id="max_usage_per_user"
                           value="{{ old('max_usage_per_user', $coupon->max_usage_per_user) }}"
                           required>
                    @if($errors->has('max_usage_per_user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('max_usage_per_user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.max_usage_per_user_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="min_total">{{ trans('cruds.coupon.fields.min_total') }}</label>
                    <input class="form-control {{ $errors->has('min_total') ? 'is-invalid' : '' }}" type="number"
                           name="min_total" id="min_total" value="{{ old('min_total', $coupon->min_total) }}">
                    @if($errors->has('min_total'))
                        <div class="invalid-feedback">
                            {{ $errors->first('min_total') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.min_total_helper') }}</span>
                </div>


                <div class="form-group">
                    @php($type = $coupon->fixed_discount ?'fixed_discount': 'percentage_discount')
                    <label class="required">{{ trans('cruds.coupon.fields.type') }}</label>
                    @foreach(App\Models\Coupon::TYPE_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('type') ? 'is-invalid' : '' }}">
                            <input class="form-check-input type" type="radio" id="type_{{ $key }}" name="type"
                                   value="{{ $key }}"
                                   {{ old('type', $type) === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="type_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('type'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.type_helper') }}</span>
                </div>


                <div class="form-group percentage_discount" style="display: none;">
                    <label class="required"
                           for="percentage_discount">{{ trans('cruds.coupon.fields.percentage_discount') }}</label>
                    <input class="form-control {{ $errors->has('percentage_discount') ? 'is-invalid' : '' }}"
                           type="text" name="percentage_discount" id="percentage_discount"
                           value="{{ old('percentage_discount', $coupon->percentage_discount??0) }}">
                    @if($errors->has('percentage_discount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('percentage_discount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.percentage_discount_helper') }}</span>
                </div>


                <div class="form-group fixed_discount" style="display: none;">
                    <label class="required"
                           for="fixed_discount">{{ trans('cruds.coupon.fields.fixed_discount') }}</label>
                    <input class="form-control {{ $errors->has('fixed_discount') ? 'is-invalid' : '' }}" type="text"
                           name="fixed_discount" id="fixed_discount"
                           value="{{ old('fixed_discount', $coupon->fixed_discount??0) }}">
                    @if($errors->has('fixed_discount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('fixed_discount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.coupon.fields.fixed_discount_helper') }}</span>
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

@include('admin.coupons.components.form_scripts')
