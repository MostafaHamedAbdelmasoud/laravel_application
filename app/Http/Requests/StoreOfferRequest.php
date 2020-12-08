<?php

namespace App\Http\Requests;

use App\Models\Offer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOfferRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('offer_create');
    }

    public function rules()
    {
        return [
            'name'         => [
                'string',
                'required',
            ],
            'category_id'  => [
                'required',
                'integer',
            ],
            'sub_category_id'  => [
                'required',
                'integer',
            ],
            'add_date'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'date_end'     => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'phone_number' => [
                'string',
                'required',
            ],
            'location'     => [
                'string',
                'required',
            ],
            'price'        => [
                'numeric',
                'required',
            ],
        ];
    }
}
