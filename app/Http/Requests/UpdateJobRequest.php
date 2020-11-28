<?php

namespace App\Http\Requests;

use App\Models\Job;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJobRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_edit');
    }

    public function rules()
    {
        return [
            'name'              => [
                'string',
                'required',
            ],
            'city_id'           => [
                'required',
                'integer',
            ],
            'add_date'          => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'details'           => [
                'required',
            ],
            'specialization_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
