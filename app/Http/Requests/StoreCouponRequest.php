<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCouponRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
            ],
            'max_usage_per_user' => [
                'required',
                'numeric',
                'min:1',
            ], 'percentage_discount' => [
                'numeric',
                'max:100',
                'min:0'
            ],
        ];
    }
}
