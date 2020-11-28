<?php

namespace App\Http\Requests;

use App\Models\News;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreNewsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('news_create');
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
            'category_id'  => [
                'required',
                'integer',
            ],
            'city_id'      => [
                'required',
                'integer',
            ],
            'add_date'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'phone_number' => [
                'string',
                'required',
            ],
            'approved'     => [
                'required',
            ],
        ];
    }
}
