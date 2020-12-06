<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMainProductServiceTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('main_product_service_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ]
        ];
    }
}
