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
                'required',
            ],
            'main_product_type_id' => [
//                'required',
                'required_without:main_product_service_type_id',
//                'exists:main_product_types,id',
            ],
            'sub_product_type_id' => [
//                'required',
                'required_with:main_product_type_id',
                'exists:sub_product_types,id',
            ],
            'main_product_service_type_id' => [
//                'required',
                'required_without:main_product_type_id',
//                'exists:main_product_service_types,id',
            ],
            'sub_product_service_type_id' => [
//                'required',
                'required_with:main_product_service_type_id',
                'exists:sub_product_service_types,id',
            ],
        ];
    }
}
