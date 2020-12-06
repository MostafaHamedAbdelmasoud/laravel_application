<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubProductTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sub_product_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'main_product_type_id' => [
                'required',
                'exists:main_product_types,id',
            ],
        ];
    }
}
