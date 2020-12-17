<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubProductServiceTypeRequest;
use App\Http\Requests\UpdateMainProductServiceTypeRequest;
use App\Http\Resources\Admin\SubProductServiceTypeResource;
use App\Models\SubProductServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubProductServiceTypesApiController extends Controller
{
    public function index(Request $request)
    {
        $SubProductServiceTypeQuery = new SubProductServiceType;
        $main_product_service_type_id = $request['main_product_service_type_id'];

        if ($main_product_service_type_id) {
            $SubProductServiceTypeQuery= $SubProductServiceTypeQuery->where('main_product_service_type_id', $main_product_service_type_id);
        }
        return new SubProductServiceTypeResource($SubProductServiceTypeQuery->get());
    }

    public function store(StoreSubProductServiceTypeRequest $request)
    {
        $sub_product_service_type = SubProductServiceType::create($request->all());

        return (new SubProductServiceTypeResource($sub_product_service_type))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($sub_product_service_type)
    {
        //abort_if(Gate::denies('$sub_product_service_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubProductServiceTypeResource(SubProductServiceType::findOrFail($sub_product_service_type));
    }

    public function update(UpdateMainProductServiceTypeRequest $request, SubProductServiceType $sub_product_service_type)
    {
        $sub_product_service_type->update($request->all());

        return (new SubProductServiceTypeResource($sub_product_service_type))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubProductServiceType $sub_product_service_type)
    {
        //abort_if(Gate::denies('$sub_product_service_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_product_service_type->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * it's for ajax request in view/admin/departments/create.blade.php
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function SubProductServiceTypeAjax($id)
    {
        $sub_product_service_types = SubProductServiceType::select('id', 'name')->where('main_product_service_type_id', $id)->get();

        return \response()->json([
             $sub_product_service_types,
        ]);
    }
}
