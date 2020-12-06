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
        return new NewsSubCategoryResource(NewsSubCategory::all());
    }

    public function store(StoreNewsSubCategoryRequest $request)
    {
        $sub_category = NewsSubCategory::create($request->all());

        return (new NewsSubCategoryResource($sub_category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $sub_category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsSubCategoryResource(NewsSubCategory::findOrFail($sub_category));
    }

    public function update(UpdateNewsSubCategoryRequest $request, NewsSubCategory $sub_category)
    {
        $sub_category->update($request->all());

        return (new NewsSubCategoryResource($sub_category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NewsSubCategory $sub_category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_category->delete();

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
