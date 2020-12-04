<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        //abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news = Order::all();

        return view('admin.news.index', compact('news', 'news_categories', 'news_sub_categories', 'cities'));
    }

    public function create()
    {
        //abort_if(Gate::denies('news_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_categories = OrderCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.news.create', compact('news_categories', 'cities'));
    }

    public function store(StoreOrderRequest $request)
    {
        $news = Order::create($request->all());

        if ($request->input('image', false)) {
            foreach ($request->input('image') as $image) {
                $news->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('image');
            }
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $news->id]);
        }

        return redirect()->route('admin.news.index');
    }

    public function edit(Order $news)
    {
        //abort_if(Gate::denies('news_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_categories = OrderCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $news_sub_categories = OrderSubCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $news->load('news_category', 'city');

        return view('admin.news.edit', compact('news_categories', 'cities', 'news', 'news_sub_categories'));
    }

    public function update(UpdateOrderRequest $request, Order $news)
    {
        $request['approved'] = $request['approved']?1:0;

        $news->update($request->all());

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

        return redirect()->route('admin.news.index');
    }

    public function show(Order $news)
    {
        //abort_if(Gate::denies('news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->load('news_category', 'city');

        $news_medias = $news->getMedia('image');
        return view('admin.news.show', compact('news', 'news_medias'));
    }

    public function destroy(Order $news)
    {
        //abort_if(Gate::denies('news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('news_create') && Gate::denies('news_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Order();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
