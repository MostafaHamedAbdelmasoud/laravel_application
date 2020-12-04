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
        $category = MainProductServiceType::create($request->all());

        return (new MainProductServiceTypeResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MainProductServiceType $category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MainProductServiceTypeResource($category);
    }

    public function update(UpdateMainProductServiceTypeRequest $request, MainProductServiceType $category)
    {
        $category->update($request->all());

        return (new MainProductServiceTypeResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MainProductServiceType $category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
