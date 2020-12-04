@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.custom_field.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.custom_fields.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field.fields.id') }}
                        </th>
                        <td>
                            {{ $custom_field->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.custom_field.fields.type') }}
                        </th>
                        <td>
                            {{ $custom_field->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.custom_fields.index') }}">
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
{{--            <a class="nav-link" href="#custom_field_departments" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.department.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#custom_field_offers" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.offer.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#custom_field_news" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.news.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="custom_field_departments">--}}
{{--            @includeIf('admin.custom_fields.relationships.custom_fieldDepartments', ['departments' => $custom_field->custom_fieldDepartments])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="custom_field_offers">--}}
{{--            @includeIf('admin.custom_fields.relationships.custom_fieldOffers', ['offers' => $custom_field->custom_fieldOffers])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="custom_field_news">--}}
{{--            @includeIf('admin.custom_fields.relationships.custom_fieldNews', ['news' => $custom_field->custom_fieldNews])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
