<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreOrderRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return $request->expectsJson() ? true : Gate::allows('order_create');
    }

    public function rules()
    {
        return [
            'order_products' => [
                'required',
                'array'
            ],
            'order_products.*.product_variant_id' => [
                'exists:product_variant,id'
            ],
//            'user_id' => [
////                'required',
//                'exists:users,id',
//            ],
            'coupon_id' => [
                'nullable',
                'exists:coupons,id',
            ],
            'address' => [
                'required',
            ],
            'phone_number' => [
                'required',
            ],
            'subtotal' => [
                'required',
                'numeric',
            ],
            'details' => [
                'required',
            ],
            'discount' => [
                'numeric',
            ],
        ];
    }
}
