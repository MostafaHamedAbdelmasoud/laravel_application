<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSubCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
        ];
    }
}
