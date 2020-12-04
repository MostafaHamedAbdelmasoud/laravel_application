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
        $type = $request['type'];

        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if (isset($type)) {
            return new NewsCategoryResource(NewsCategory::where('type', $type)->get());
        }
        return new NewsCategoryResource(NewsCategory::all());
    }

    public function store(StoreNewsCategoryRequest $request)
    {
        $category = NewsCategory::create($request->all());

        return (new NewsCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(NewsCategory $category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsCategoryResource($category);
    }

    public function update(UpdateNewsCategoryRequest $request, NewsCategory $category)
    {
        $category->update($request->all());

        return (new NewsCategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(NewsCategory $category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
