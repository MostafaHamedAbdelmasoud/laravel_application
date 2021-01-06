@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.order.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                            id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.user_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="coupon_id">{{ trans('cruds.order.fields.coupon') }}</label>
                    <select class="form-control select2 {{ $errors->has('coupon') ? 'is-invalid' : '' }}"
                            name="coupon_id" id="coupon_id">
                        @foreach($coupons as $id => $coupon)
                            <option
                                value="{{ $id }}" {{ old('coupon_id') == $id ? 'selected' : '' }}>{{ $coupon }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('coupon'))
                        <div class="invalid-feedback">
                            {{ $errors->first('coupon') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.coupon_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required"
                           for="product_variant">{{ trans('cruds.order.fields.product_variant') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('product_variant') ? 'is-invalid' : '' }}"
                            name="product_variant[]" id="product_variant" multiple required>
                        @foreach($product_variants as $product_variant)
                            <option
                                value="{{ $product_variant->id }}" {{ in_array($product_variant->id , old('product_variant', [])) ? 'selected' : '' }}>
                                {{ $product_variant->product->name .' - '.$product_variant->variant->color .' - '.$product_variant->variant->size .' - '. $product_variant->variant->price}}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('product_variant'))
                        <div class="invalid-feedback">
                            {{ $errors->first('product_variant') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.product_variant_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="subtotal">{{ trans('cruds.order.fields.subtotal') }}</label>
                    <input class="form-control {{ $errors->has('subtotal') ? 'is-invalid' : '' }}" type="number"
                           name="subtotal" id="subtotal" value="{{ old('subtotal', '') }}" required>
                    @if($errors->has('subtotal'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subtotal') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.subtotal_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="address">{{ trans('cruds.order.fields.address') }}</label>
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                           name="address" id="address" value="{{ old('address', '') }}" required>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.address_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="phone_number">{{ trans('cruds.order.fields.phone_number') }}</label>
                    <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text"
                           name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}" required>
                    @if($errors->has('phone_number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone_number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.phone_number_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="discount">{{ trans('cruds.order.fields.discount') }}</label>
                    <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number"
                           name="discount" id="discount" value="{{ old('discount', '') }}" required>
                    @if($errors->has('discount'))
                        <div class="invalid-feedback">
                            {{ $errors->first('discount') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.discount_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="total">{{ trans('cruds.order.fields.total') }}</label>
                    <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }}" type="number"
                           name="total" id="total" value="{{ old('total', '') }}" required>
                    @if($errors->has('total'))
                        <div class="invalid-feedback">
                            {{ $errors->first('total') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.total_helper') }}</span>
                </div>


                <div class="form-group">
                    <label class="required" for="details">{{ trans('cruds.order.fields.details') }}</label>
                    <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : '' }}" type="number"
                              name="details" id="details" required>{{ old('details', '') }}</textarea>
                    @if($errors->has('details'))
                        <div class="invalid-feedback">
                            {{ $errors->first('details') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.details_helper') }}</span>
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
