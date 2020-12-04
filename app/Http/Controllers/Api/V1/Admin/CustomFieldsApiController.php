<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomFieldRequest;
use App\Http\Requests\UpdateCustomFieldRequest;
use App\Http\Resources\Admin\CustomFieldResource;
use App\Models\CustomField ;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomFieldsApiController extends Controller
{
    public function index(Request $request)
    {
        return new CustomFieldResource(CustomField ::all());
    }

    public function store(StoreCustomFieldRequest $request)
    {
        $coupon = CustomField::create($request->all());

        return (new CustomFieldResource($coupon))
            ->additional([
                'success'=>'تمت الإضافة بنجاح'
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomField $coupon)
    {
        //abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomFieldResource($coupon);
    }

    public function update(UpdateCustomFieldRequest $request, CustomField $coupon)
    {
        $coupon->update($request->all());

        return (new CustomFieldResource($coupon))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomField $coupon)
    {
        //abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
