<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomFieldOptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('custom_field_option_edit');
    }

    public function rules()
    {
        return [
            'custom_field_id' => [
                'required',
                'exists:custom_fields,id',
            ],
            'product_id' => [
                'required',
                'exists:products,id',
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
