<?php

namespace App\Http\Requests;

use App\Models\Advertisement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdvertisementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('advertisement_create');
    }

    public function rules()
    {
        return [
            'images.*' => [
                'required',
            ],
        ];
    }
}
