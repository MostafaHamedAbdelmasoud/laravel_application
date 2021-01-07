<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class LoginApiRequest extends FormRequest
{
//    public function authorize()
//    {
//        return Gate::allows('coupon_edit');
//    }

    public function rules()
    {
        return [
            'phone_number' => [
                'required',

                Rule::exists('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ]
        ];
    }
}
