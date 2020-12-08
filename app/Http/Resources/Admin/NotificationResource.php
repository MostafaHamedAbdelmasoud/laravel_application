<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [parent::toArray(array_merge($request->except('city_id')), ['city' => $request->city?$request->city->name:""])];
    }
}
