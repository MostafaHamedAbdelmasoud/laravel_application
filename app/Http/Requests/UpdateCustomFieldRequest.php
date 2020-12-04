<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCustomFieldRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_edit');
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
