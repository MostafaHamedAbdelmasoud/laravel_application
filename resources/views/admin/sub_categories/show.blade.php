@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sub_category.title') }}
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
                            {{ trans('cruds.sub_category.fields.id') }}
                        </th>
                        <td>
                            {{ $sub_category->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sub_category.fields.name') }}
                        </th>
                        <td>
                            {{ $sub_category->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sub_category.fields.category_id') }}
                        </th>
                        <td>
                            {{ $sub_category->category ? $sub_category->category->name: '' }}
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
{{--            <a class="nav-link" href="#sub_category_departments" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.department.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#sub_category_offers" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.offer.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#sub_category_news" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.news.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_category_departments">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_categoryDepartments', ['departments' => $sub_category->sub_categoryDepartments])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_category_offers">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_categoryOffers', ['offers' => $sub_category->sub_categoryOffers])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="sub_category_news">--}}
{{--            @includeIf('admin.sub_categories.relationships.sub_categoryNews', ['news' => $sub_category->sub_categoryNews])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
