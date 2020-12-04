<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCustomFieldRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('custom_field_create');
    }

    public function rules()
    {
        return [
            'type' => [
                'string',
                'required',
            ],
        ];
    }
}
