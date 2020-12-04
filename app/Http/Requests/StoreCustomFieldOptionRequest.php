<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomFieldOptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('custom_field_option_create');
    }

    public function rules()
    {
        return [
            'products.*' => [
                'integer',
            ],
            'products'   => [
                'required',
                'array',
                'exists:products,id',
            ],
            'custom_field_id.*' => [
                'integer',
            ],
            'custom_field_id'   => [
                'required',
                'exists:custom_fields,id',
            ],
            'value' => [
                'required',
                'string',
            ],
            'additional_price' => [
                'required',
                'numeric'
            ],
        ];
    }
}
