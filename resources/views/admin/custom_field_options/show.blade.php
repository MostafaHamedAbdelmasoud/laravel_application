@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.custom_field_option.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.custom_field_options.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field_option.fields.id') }}
                        </th>
                        <td>
                            {{ $custom_field_option->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field_option.fields.value') }}
                        </th>
                        <td>
                            {{ $custom_field_option->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field_option.fields.product_id') }}
                        </th>
                        <td>
                            @if($custom_field_option->product)
                            <a href="{{route('admin.products.show',$custom_field_option->product->id)}}">

                            {{ $custom_field_option->product_name }}
                            </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field_option.fields.custom_field_id') }}
                        </th>
                        <td>
                            @if($custom_field_option->customField)
                            <a href="{{route('admin.custom_fields.show',$custom_field_option->customField->id)}}">
                            {{ $custom_field_option->custom_field_type }}
                            </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.custom_field_options.index') }}">
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
{{--            <a class="nav-link" href="#custom_field_option_product" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.product.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#custom_field_option_custom_field" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.custom_field.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="custom_field_option_product">--}}
{{--            @includeIf('admin.custom_field_options.relationships.customField', ['product' => $custom_field_option->product])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="custom_field_option_custom_field">--}}
{{--            @includeIf('admin.custom_field_options.relationships.custom_field_optionOffers', ['offers' => $custom_field_option->custom_field])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
