<?php

namespace App\Http\Requests;

use App\Models\Trader;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTraderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('trader_edit');
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'nullable',
            ],
            'address'      => [
                'string',
                'nullable',
            ],
            'phone_number' => [
                'string',
                'nullable',
            ],
            'details'      => [
                'string',
                'nullable',
            ],
            'facebook_url' => [
                'string',
                'nullable',
            ],
            'whatsapp'     => [
                'string',
                'nullable',
            ],
        ];
    }
}
