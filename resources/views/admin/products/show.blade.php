@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.product.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.id') }}
                        </th>
                        <td>
                            {{ $product->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.image') }}
                        </th>
                        <td>
                            @if($product->image)
                                <a href="{{ $product->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $product->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.name') }}
                        </th>
                        <td>
                            {{ $product->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.brand') }}
                        </th>
                        <td>
                            {{ $product->brand }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.detailed_title') }}
                        </th>
                        <td>
                            {{ $product->detailed_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.details') }}
                        </th>
                        <td>
                            {{ $product->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.price_after_discount') }}
                        </th>
                        <td>
                            {{ $product->price_after_discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.product_code') }}
                        </th>
                        <td>
                            {{ $product->product_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.price') }}
                        </th>
                        <td>
                            {{ $product->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.trader') }}
                        </th>
                        <td>
                            {{ $product->trader->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.city_name') }}
                        </th>
                        <td>
                            {{ $product->city?$product->city->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.department_name') }}
                        </th>
                        <td>
                            {{ $product->department?$product->department->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.MainProductType') }}
                        </th>
                        <td>
                            {{ $product->MainProductType?$product->MainProductType->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.SubProductType') }}
                        </th>
                        <td>
                            {{ $product->SubProductType?$product->SubProductType->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.MainProductServiceType') }}
                        </th>
                        <td>
                            {{ $product->MainProductServiceType?$product->MainProductServiceType->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.SubProductServiceType') }}
                        </th>
                        <td>
                            {{ $product->SubProductServiceType?$product->SubProductServiceType->name : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.show_trader_name') }}
                        </th>
                        <td>
                            {{ $product->show_trader_name?'نعم' : 'لا' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.show_in_trader_page') }}
                        </th>
                        <td>
                            {{ $product->show_in_trader_page?'نعم' : 'لا' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.show_in_main_page') }}
                        </th>
                        <td>
                            {{ $product->show_in_main_page?'نعم' : 'لا' }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" >
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.products.variants.index',$product)}}" role="tab" >
                    {{ trans('cruds.variant.title') }}
                </a>
            </li>
        </ul>

    </div>



@endsection
