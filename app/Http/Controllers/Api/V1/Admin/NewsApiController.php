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
use Spatie\MediaLibrary\Models\Media;
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
        $news_query_builder = News::with('news_category', 'city')->where('approved', 1)->whereNull('deleted_at')->filter($this->filter);

        $news_category_id = $request['news_category_id'];

        $details = $request['details'];

        $news_sub_category_id = $request['news_sub_category_id'];


        $city_id = $request['city_id'];


        if (isset($city_id)) {
            $news_query_builder = $news_query_builder->where('city_id', $city_id);
        }
        if (isset($news_sub_category_id)) {
            $news_query_builder->where('news_sub_category_id', $news_sub_category_id);
        }
        if (isset($news_category_id)) {
            $news_query_builder->where('news_category_id', $news_category_id);
        }
        if (isset($details)) {
            $news_query_builder->where('details', 'like', "%$details%");
        }
        return new NewsResource($news_query_builder->latest()->get());
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());

        if ($request->input('image', false)) {
            foreach ($request->input('image') as $image) {
                $news->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('image');
            }
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $news->id]);
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

//        $news->update($request->all());
//        if ($request->file('image')) {
//            if (!$news->image || $request->file('image') !== $news->image->file_name) {
//                if ($news->image) {
//                    $news->image->delete();
//                }
//
//                $news->addMedia($request->file('image'))->toMediaCollection('image');
//            }
//        } elseif ($news->image) {
//            $news->image->delete();
//        }


        if ($request->input('image', false)) {
            foreach ($request->input('image') as $image) {
                if (!$news->image || $image !== $news->image->file_name) {
                    if ($news->image) {
                        $news->image->delete();
                    }

                    $news->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('image');
                }
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
