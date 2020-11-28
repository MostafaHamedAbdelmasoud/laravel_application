<?php

namespace App\Http\Requests;

use App\Models\Notification;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreNotificationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('notification_create');
    }

    public function rules()
    {
        return [
            'title'   => [
                'string',
                'required',
            ],
            'content' => [
                'string',
                'required',
            ],
            'city_id' => [
                'required',
                'exists:cities,id',
            ],
        ];
    }
}
