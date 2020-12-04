@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sub_product_type.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub_categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sub_product_type.fields.id') }}
                        </th>
                        <td>
                            {{ $sub_product_type->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sub_product_type.fields.name') }}
                        </th>
                        <td>
                            {{ $sub_product_type->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sub_product_type.fields.category_id') }}
                        </th>
                        <td>
                            {{ $sub_product_type->category ? $sub_product_type->category->name: '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sub_categories.index') }}">
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
{{--            <a class="nav-link" href="#sub_product_type_departments" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.department.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#sub_product_type_offers" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.offer.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#sub_product_type_news" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.news.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_product_type_departments">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_product_typeDepartments', ['departments' => $sub_product_type->sub_product_typeDepartments])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_product_type_offers">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_product_typeOffers', ['offers' => $sub_product_type->sub_product_typeOffers])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_product_type_news">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_product_typeNews', ['news' => $sub_product_type->sub_product_typeNews])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
