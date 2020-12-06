<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Http\Resources\Admin\SubCategoryResource;
use App\Models\SubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCategoriesApiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request['type'];

        //abort_if(Gate::denies('sub_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($type)) {
            return new SubCategoryResource(SubCategory::whereHas('category',function ($q) use($type){
                $q->where('type', $type);
            })->get());
        }

        return new SubCategoryResource(SubCategory::all());
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $sub_category = SubCategory::create($request->all());

        return (new SubCategoryResource($sub_category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $sub_category)
    {
        //abort_if(Gate::denies('sub_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubCategoryResource(SubCategory::findOrFail($sub_category));
    }

    public function update(UpdateSubCategoryRequest $request, SubCategory $sub_category)
    {
        $sub_category->update($request->all());

        return (new SubCategoryResource($sub_category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubCategory $sub_category)
    {
        //abort_if(Gate::denies('sub_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * it's for ajax request in view/admin/departments/create.blade.php
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubCategoryAjax($id)
    {
        $sub_categories = SubCategory::select('id', 'name')->where('category_id', $id)->get();

        return \response()->json([
             $sub_categories,
        ]);
    }
}
