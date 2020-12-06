<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMainProductServiceTypeRequest;
use App\Http\Requests\UpdateMainProductServiceTypeRequest;
use App\Http\Resources\Admin\MainProductServiceTypeResource;
use App\Models\MainProductServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainProductServiceTypesApiController extends Controller
{
    public function index(Request $request)
    {
        return new MainProductServiceTypeResource(MainProductServiceType::all());
    }

    public function store(StoreMainProductServiceTypeRequest $request)
    {
        $main_product_service_type = MainProductServiceType::create($request->all());

        return (new MainProductServiceTypeResource($main_product_service_type))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $main_product_service_type)
    {
        //abort_if(Gate::denies('main_product_service_type'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MainProductServiceTypeResource(MainProductServiceType::findOrFail($main_product_service_type));
    }

    public function update(UpdateMainProductServiceTypeRequest $request, MainProductServiceType $main_product_service_type)
    {
        $main_product_service_type->update($request->all());

        return (new MainProductServiceTypeResource($main_product_service_type))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MainProductServiceType $main_product_service_type)
    {
        //abort_if(Gate::denies('main_product_service_type'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_service_type->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
