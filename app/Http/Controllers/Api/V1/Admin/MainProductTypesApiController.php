<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMainProductTypeRequest;
use App\Http\Requests\UpdateMainProductTypeRequest;
use App\Http\Resources\Admin\MainProductTypeResource;
use App\Models\MainProductType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainProductTypesApiController extends Controller
{
    public function index(Request $request)
    {
        return new MainProductTypeResource(MainProductType::all());
    }

    public function store(StoreMainProductTypeRequest $request)
    {
        $main_product_type = MainProductType::create($request->all());

        return (new MainProductTypeResource($main_product_type))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($main_product_type)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MainProductTypeResource(MainProductType::findOrFail($main_product_type));
    }

    public function update(UpdateMainProductTypeRequest $request, MainProductType $main_product_type)
    {
        $main_product_type->update($request->all());

        return (new MainProductTypeResource($main_product_type))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MainProductType $main_product_type)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_type->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
