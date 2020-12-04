<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreNewsSubCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'news_category_id' => [
                'required',
                'exists:news_categories,id',
            ],
        ];
    }
}
