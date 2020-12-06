<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsCategoryRequest;
use App\Http\Requests\UpdateNewsCategoryRequest;
use App\Http\Resources\Admin\NewsCategoryResource;
use App\Models\NewsCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsCategoriesApiController extends Controller
{
    public function index(Request $request)
    {
        return new NewsCategoryResource(NewsCategory::all());
    }

    public function store(StoreNewsCategoryRequest $request)
    {
        $news_category = NewsCategory::create($request->all());

        return (new NewsCategoryResource($news_category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $news_category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsCategoryResource(NewsCategory::findOrFail($news_category));
    }

    public function update(UpdateNewsCategoryRequest $request, NewsCategory $news_category)
    {
        $news_category->update($request->all());

        return (new NewsCategoryResource($news_category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NewsCategory $news_category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
