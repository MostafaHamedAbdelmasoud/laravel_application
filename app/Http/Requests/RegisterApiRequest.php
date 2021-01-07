<?php

namespace App\Http\Requests;

use App\Models\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class RegisterApiRequest extends FormRequest
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
//                'unique:users'
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
        ];
    }
}
