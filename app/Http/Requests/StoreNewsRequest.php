<?php

namespace App\Http\Requests;

use App\Models\News;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreNewsRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return $request->expectsJson()?true: Gate::allows('news_create');
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'required',
            ],
            'image'        => [
                'required',
            ],
            'details'      => [
                'required',
            ],
            'detailed_title'      => [
                'required',
            ],
            'news_category_id'  => [
                'required',
                'integer',
                'exists:news_categories,id'
            ],
            'news_sub_category_id'  => [
                'required',
                'integer',
                'exists:news_sub_categories,id'
            ],
            'city_id'      => [
                'required',
                'integer',
                'exists:cities,id',
            ],
            'add_date'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'phone_number' => [
                'string',
                'required',
            ],
        ];
    }
}
