<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMainProductTypeRequest;
use App\Http\Requests\UpdateMainProductTypeRequest;
use App\Http\Resources\Admin\SubProductTypeResource;
use App\Models\MainProductType;
use App\Models\SubProductType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubProductTypesApiController extends Controller
{
    public function index(Request $request)
    {
        return new SubProductTypeResource(MainProductType::all());
    }

    public function store(StoreMainProductTypeRequest $request)
    {
        $sub_product_type = MainProductType::create($request->all());

        return (new SubProductTypeResource($sub_product_type))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $sub_product_type)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubProductTypeResource(MainProductType::findOrFail($sub_product_type));
    }

    public function update(UpdateMainProductTypeRequest $request, MainProductType $sub_product_type)
    {
        $sub_product_type->update($request->all());

        return (new SubProductTypeResource($sub_product_type))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MainProductType $sub_product_type)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_product_type->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * it's for ajax request in view/admin/departments/create.blade.php
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMainProductTypeAjax($id)
    {
        $sub_product_types = SubProductType::select('id', 'name')->where('main_product_type_id', $id)->get();

        return \response()->json([
             $sub_product_types,
        ]);
    }
}
