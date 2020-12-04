<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomFieldOptionResource extends JsonResource
{
    public function toArray($request)
    {
//        parent::toArray( [
//            'id' => $this->id,
//            'product_id' => $this->product ? $this->product->name : '',
//            'custom_field_id' => $this->customField ? $this->customField->type : '',
//            'additional_price' => $this->additional_price,
//            'value' => $this->value,
//        ]);


//        return parent::toArray(
//            $request->except('product_id'),
//            ['product_id' => $request->product ? $request->product->name : '']
//        );

        return parent::toArray($request);
    }
}
