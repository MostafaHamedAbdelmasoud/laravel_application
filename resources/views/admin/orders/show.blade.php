@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                {{ trans('global.show') }} {{ trans('cruds.order.title') }}
            </div>

            <br>
            <div class="card-body">
                <div class="form-group">
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                        <a class="btn btn-primary" href="{{ route('admin.orders.download_pdf',$order->id) }}">
                            {{ trans('global.download_pdf') }}
                        </a>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.id') }}
                            </th>
                            <td>
                                {{ $order->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.user') }}
                            </th>
                            <td>
                                {{ $order->user? $order->user->name:'' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.coupon') }}
                            </th>
                            <td>
                                {{ $order->coupon? $order->coupon->name:'' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.subtotal') }}
                            </th>
                            <td>
                                {{ $order->subtotal }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.discount') }}
                            </th>
                            <td>
                                {{ $order->discount }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.total') }}
                            </th>
                            <td>
                                {{ $order->total }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.address') }}
                            </th>
                            <td>
                                {{ $order->address }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.phone_number') }}
                            </th>
                            <td>
                                {{ $order->phone_number }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.details') }}
                            </th>
                            <td>
                                {{ $order->details }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.order.fields.product_variant') }}
                            </th>
                            <td>
                                @foreach($order->OrderProducts as  $order_product)
                                    <span class="label label-info">
                                {{ $order_product->ProductVariant->product->name .' - '.  $order_product->ProductVariant->variant->color .' - '.
                                 $order_product->ProductVariant->variant->size .' - '.$order_product->ProductVariant->variant->price }}
                               <br>
                                </span>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.orders.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
