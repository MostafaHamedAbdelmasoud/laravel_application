<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Filters\NewsFilter;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\Admin\NewsResource;
use App\Models\News;
use Gate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class NewsApiController extends Controller implements ShouldQueue
{
    use MediaUploadingTrait;

    protected $filter;

    /**
     * NewsApiController constructor.
     * @param NewsFilter $filter
     */
    public function __construct(NewsFilter $filter)
    {
        $this->filter = $filter;
    }

    public function index(Request $request)
    {
        //abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $details = $request['details'];
        $news_query_builder = News::with(['news_category', 'city'])->where('approved', 1)->whereNull('deleted_at')->filter($this->filter);

        if (isset($details)) {
            $news_query_builder->where('details', 'like', "%$details%");
        }
        return new NewsResource($news_query_builder->latest()->get());
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());

        if ($request->file('image')) {
            $news->addMedia($request->file('image'))->toMediaCollection('image');
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($news)
    {
        //abort_if(Gate::denies('news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NewsResource(News::findOrFail($news)->load(['news_category', 'city']));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
//        return \response()->json($request);
        $news->update($request->all());
        if ($request->file('image')) {
            if (!$news->image || $request->file('image') !== $news->image->file_name) {
                if ($news->image) {
                    $news->image->delete();
                }

                $news->addMedia($request->file('image'))->toMediaCollection('image');
            }
        } elseif ($news->image) {
            $news->image->delete();
        }

        return (new NewsResource($news))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(News $news)
    {
        //abort_if(Gate::denies('news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
