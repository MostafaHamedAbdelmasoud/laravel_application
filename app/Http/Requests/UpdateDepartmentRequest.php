<?php

namespace App\Http\Requests;

use App\Models\Department;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_edit');
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'required',
            ],
            'city_id'      => [
                'required',
                'integer',
            ],
            'phone_number' => [
                'string',
                'required',
            ],
            'sub_category_id' => [
                'required',
                'exists:departments_sub_categories,id',
            ],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
        ];
    }
}
