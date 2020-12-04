<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use App\Models\SubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCategoriesApiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request['type'];

        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($type)) {
            return new CategoryResource(Category::where('type', $type)->get());
        }
        return new CategoryResource(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Category $category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * it's for ajax request in view/admin/departments/create.blade.php
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryAjax($id)
    {
        $sub_categories = SubCategory::select('id', 'name')->where('category_id', $id)->get();

        return \response()->json([
             $sub_categories,
        ]);
    }
}
