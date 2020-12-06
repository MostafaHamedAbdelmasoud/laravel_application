<?php

namespace App\Http\Requests;

use App\Models\Job;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreJobRequest extends FormRequest
{
    public function authorize(Request $request)
    {
         return $request->expectsJson()?true: Gate::allows('job_create');
    }

    public function rules()
    {
        return [
            'name'              => [
                'string',
                'required',
            ],
            'image'             => [
                'required',
            ],
            'whats_app_number'  => [
                'required',
            ],
            'email' => [
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
