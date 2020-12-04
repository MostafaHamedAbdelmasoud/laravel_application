<?php

namespace App\Http\Requests;

use App\Models\Department;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_create');
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'required',
            ],
            'logo'         => [
                'required',
            ],
            'city_id'      => [
                'required',
                'integer',
            ],
            'trader_id'      => [
                'required',
                'exists:traders,id',
            ],
            'phone_number' => [
                'string',
                'required',
            ],
        ];
    }
}
