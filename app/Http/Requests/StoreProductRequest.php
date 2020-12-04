<?php

namespace App\Http\Requests;

use App\Models\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_create');
    }

    public function rules()
    {
        return [
            'name'  => [
                'string',
                'nullable',
            ],
            'price' => [
                'string',
                'nullable',
            ],
            'main_product_type_id' => [
                'required',
                'exists:main_product_types,id',
            ],
            'sub_product_type_id' => [
                'required',
                'exists:sub_product_types,id',
            ],
        ];
    }
}
