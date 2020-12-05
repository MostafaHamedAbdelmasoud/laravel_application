<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'product_variant' => [
                'array',
                'required',
            ],
            'product_variant.*' => [
                'string',
                'exists:product_variant,id',
            ],
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'coupon_id' => [
                'nullable',
                'exists:users,id',
            ],
            'subtotal' => [
                'required',
            ],
            'total' => [
                'required',
            ],
            
        ];
    }
}
