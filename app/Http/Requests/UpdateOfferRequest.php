<?php

namespace App\Http\Requests;

use App\Models\Offer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('offer_edit');
    }

    public function rules()
    {
        return [
            'name'         => [
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
