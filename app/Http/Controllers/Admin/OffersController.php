<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOfferRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Category;
use App\Models\Offer;
use App\Models\SubCategory;
use App\Models\Trader;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OffersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Offer::with(['category', 'trader'])->select(sprintf('%s.*', (new Offer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'offer_show';
                $editGate = 'offer_edit';
                $deleteGate = 'offer_delete';
                $crudRoutePart = 'offers';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });

            $table->editColumn('show_in_trader_page', function ($row) {
                return $row->showInTraderPage();
            });
            $table->editColumn('show_in_main_page', function ($row) {
                return $row->showInMainPage() ;
            });

            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->addColumn('sub_category_name', function ($row) {
                return $row->sub_category ? $row->sub_category->name : '';
            });

            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : "";
            });
            $table->editColumn('location', function ($row) {
                return $row->location ? $row->location : "";
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });
            $table->addColumn('trader_name', function ($row) {
                return $row->trader ? $row->trader->name : '';
            });

            $table->editColumn('images', function ($row) {
                if (!$row->images) {
                    return '';
                }

                $links = [];

                foreach ($row->images as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'trader', 'images']);

            return $table->make(true);
        }

        $categories = Category::get();
        $sub_categories = SubCategory::get();
        $traders = Trader::get();

        return view('admin.offers.index', compact('categories', 'traders', 'sub_categories'));
    }

    public function create()
    {
        //abort_if(Gate::denies('offer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sub_categories = SubCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $traders = Trader::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.offers.create', compact('categories', 'traders', 'sub_categories'));
    }

    public function store(StoreOfferRequest $request)
    {
        $request['show_in_main_page']= $request->has('show_in_main_page')?1:0;

        $request['show_in_trader_page']= $request->has('show_in_trader_page')?1:0;

        $offer = Offer::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $offer->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $offer->id]);
        }

        return redirect()->route('admin.offers.index');
    }

    public function edit(Offer $offer)
    {
        //abort_if(Gate::denies('offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sub_categories = SubCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $traders = Trader::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $offer->load('category', 'trader');

        return view('admin.offers.edit', compact('categories', 'traders', 'offer', 'sub_categories'));
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $request['show_in_main_page']= $request->has('show_in_main_page')?1:0;

        $request['show_in_trader_page']= $request->has('show_in_trader_page')?1:0;

        $offer->update($request->all());


        if (count($offer->images) > 0) {
            foreach ($offer->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $offer->images->pluck('file_name')->toArray();

        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $offer->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.offers.index');
    }

    public function show(Offer $offer)
    {
        //abort_if(Gate::denies('offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offer->load('category', 'trader');

        return view('admin.offers.show', compact('offer'));
    }

    public function destroy(Offer $offer)
    {
        //abort_if(Gate::denies('offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offer->delete();

        return back();
    }

    public function massDestroy(MassDestroyOfferRequest $request)
    {
        Offer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('offer_create') && Gate::denies('offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Offer();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
