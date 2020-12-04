@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coupon.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.id') }}
                        </th>
                        <td>
                            {{ $coupon->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.code') }}
                        </th>
                        <td>
                            {{ $coupon->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.type') }}
                        </th>
                        <td>
                            @php($indx = $coupon->fixed_discount?'fixed_discount':'percentage_discount')
                            {{ App\Models\Coupon::TYPE_RADIO[$indx]  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.value') }}
                        </th>
                        <td>
                            {{ $coupon->fixed_discount??$coupon->percentage_discount  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.max_usage_per_user') }}
                        </th>
                        <td>
                            {{ $coupon->max_usage_per_user  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.number_of_usage') }}
                        </th>
                        <td>
                            {{ $coupon->number_of_usage  }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coupon.fields.min_total') }}
                        </th>
                        <td>
                            {{ $coupon->min_total  }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupons.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

{{--<div class="card">--}}
{{--    <div class="card-header">--}}
{{--        {{ trans('global.relatedData') }}--}}
{{--    </div>--}}
{{--    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#coupon_departments" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.department.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#coupon_offers" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.offer.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#coupon_news" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.news.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="coupon_departments">--}}
{{--            @includeIf('admin.coupons.relationships.couponDepartments', ['departments' => $coupon->couponDepartments])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="coupon_offers">--}}
{{--            @includeIf('admin.coupons.relationships.couponOffers', ['offers' => $coupon->couponOffers])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="coupon_news">--}}
{{--            @includeIf('admin.coupons.relationships.couponNews', ['news' => $coupon->couponNews])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
