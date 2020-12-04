<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyItemAdvertisementRequest;
use App\Http\Requests\StoreItemAdvertisementRequest;
use App\Http\Requests\UpdateItemAdvertisementRequest;
use App\Models\ItemAdvertisement;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ItemAdvertisementsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ItemAdvertisement::query()->select(sprintf('%s.*', (new ItemAdvertisement)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'advertisement_show';
                $editGate      = 'advertisement_edit';
                $deleteGate    = 'advertisement_delete';
                $crudRoutePart = 'item_advertisements';

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

            $table->rawColumns(['actions', 'placeholder', 'images']);

            return $table->make(true);
        }

        return view('admin.item_advertisements.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('advertisement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.item_advertisements.create');
    }

    public function store(StoreItemAdvertisementRequest $request)
    {
        $item_advertisement = ItemAdvertisement::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $item_advertisement->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $item_advertisement->id]);
        }

        return redirect()->route('admin.item_advertisements.index');
    }

    public function edit(ItemAdvertisement  $item_advertisement)
    {
        //abort_if(Gate::denies('advertisement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.item_advertisements.edit', compact('item_advertisement'));
    }

    public function update(UpdateItemAdvertisementRequest $request, ItemAdvertisement  $item_advertisement)
    {
        $item_advertisement->update($request->all());

        if (count($item_advertisement->images) > 0) {
            foreach ($item_advertisement->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $item_advertisement->images->pluck('file_name')->toArray();

        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $item_advertisement->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.item_advertisements.index');
    }

    public function show(ItemAdvertisement  $item_advertisement)
    {
        //abort_if(Gate::denies('advertisement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.item_advertisements.show', compact('item_advertisement'));
    }

    public function destroy(ItemAdvertisement $item_advertisement)
    {
        //abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $item_advertisement->delete();

        return back();
    }

    public function massDestroy(MassDestroyItemAdvertisementRequest $request)
    {
        ItemAdvertisement::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('trader_create') && Gate::denies('trader_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ItemAdvertisement();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
