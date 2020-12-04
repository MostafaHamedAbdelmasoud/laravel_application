<?php

namespace App\Http\Requests;

use App\Models\Offer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVariantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('offer_create');
    }

    public function rules()
    {
        return [
            'details'  => [
                '',
            ],
            'count'     => [
                '',
            ],
            'price'     => [
                '',
            ],
            'color' => [
                '',
            ],
        ];
    }
}
