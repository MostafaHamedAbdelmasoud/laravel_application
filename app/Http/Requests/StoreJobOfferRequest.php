<?php

namespace App\Http\Requests;

use App\Models\JobOffer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreJobOfferRequest extends FormRequest
{
    public function authorize(Request $request)
    {
        return $request->expectsJson()?true:  Gate::allows('job_offer_create');
    }

    public function rules()
    {
        return [
            'name'                => [
                'string',
                'required',
            ],
            'email'               => [
                'required',
            ],
            'phone_number'        => [
                'string',
                'required',
            ],
            'details'             => [
                'required',
            ],
            'cv'                  => [
                'required',
            ],
            'approved'            => [
                'required',
            ],
            'add_date'            => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'age'                 => [
                'string',
                'nullable',
            ],
            'years_of_experience' => [
                'string',
                'nullable',
            ],
        ];
    }
}
