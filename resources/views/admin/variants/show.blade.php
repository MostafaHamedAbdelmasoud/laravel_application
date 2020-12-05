@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.variant.title') }}
        </div>

        <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.show',$product) }}">
                    مشاهدة المنتج     {{$product->name }}
                    </a>
                </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.variants.index',$product) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.id') }}
                        </th>
                        <td>
                            {{ $variant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.color') }}
                        </th>
                        <td>
                            {{ $variant->color }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.image') }}
                        </th>
                        <td>
                            @if($variant->image)
                                <a href="{{ $variant->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $variant->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.size') }}
                        </th>
                        <td>
                            {{ $variant->size ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.count') }}
                        </th>
                        <td>
                            {{ $variant->count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.variant.fields.price') }}
                        </th>
                        <td>
                            {{ $variant->price }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.variants.index',$product) }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
