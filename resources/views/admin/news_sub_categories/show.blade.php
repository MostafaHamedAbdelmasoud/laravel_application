@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.news_sub_category.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.news_sub_categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.news_sub_category.fields.id') }}
                        </th>
                        <td>
                            {{ $news_sub_category->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news_sub_category.fields.name') }}
                        </th>
                        <td>
                            {{ $news_sub_category->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news_sub_category.fields.category_id') }}
                        </th>
                        <td>
                            {{ $news_sub_category->category ? $news_sub_category->category->name: '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.news_sub_categories.index') }}">
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
{{--            <a class="nav-link" href="#news_sub_category_departments" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.department.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#news_sub_category_offers" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.offer.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#news_sub_category_news" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.news.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="news_sub_category_departments">--}}
{{--            @includeIf('admin.news_sub_categories.relationships.news_sub_categoryDepartments', ['departments' => $news_sub_category->news_sub_categoryDepartments])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="news_sub_category_offers">--}}
{{--            @includeIf('admin.news_sub_categories.relationships.news_sub_categoryOffers', ['offers' => $news_sub_category->news_sub_categoryOffers])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="news_sub_category_news">--}}
{{--            @includeIf('admin.news_sub_categories.relationships.news_sub_categoryNews', ['news' => $news_sub_category->news_sub_categoryNews])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
