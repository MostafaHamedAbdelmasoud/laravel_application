<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsSubCategoryRequest;
use App\Http\Requests\UpdateNewsSubCategoryRequest;
use App\Http\Resources\Admin\NewsSubCategoryResource;
use App\Models\NewsSubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsSubCategoriesApiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request['type'];

        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($type)) {
            return new NewsSubCategoryResource(NewsSubCategory::where('type', $type)->get());
        }
        return new NewsSubCategoryResource(NewsSubCategory::all());
    }

    public function store(StoreNewsSubCategoryRequest $request)
    {
        $category = NewsSubCategory::create($request->all());

        return (new NewsSubCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(NewsSubCategory $category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsSubCategoryResource($category);
    }

    public function update(UpdateNewsSubCategoryRequest $request, NewsSubCategory $category)
    {
        $category->update($request->all());

        return (new NewsSubCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NewsSubCategory $category)
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
    public function getNewsSubCategoryAjax($id)
    {
        $news_sub_categories = NewsSubCategory::select('id', 'name')->where('news_category_id', $id)->get();

        return \response()->json([
             $news_sub_categories,
        ]);
    }
}
