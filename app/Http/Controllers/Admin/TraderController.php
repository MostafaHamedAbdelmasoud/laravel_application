<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTraderRequest;
use App\Http\Requests\StoreTraderRequest;
use App\Http\Requests\UpdateTraderRequest;
use App\Imports\TradersImport;
use App\Models\Trader;
use Gate;
use Excel;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TraderController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('trader_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Trader::query()->select(sprintf('%s.*', (new Trader)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'trader_show';
                $editGate = 'trader_edit';
                $deleteGate = 'trader_delete';
                $crudRoutePart = 'traders';

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

            $table->editColumn('activeness', function ($row) {
                return $row->activeness ? $row->activeness : "";
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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('address', function ($row) {
                return $row->address ? $row->address : "";
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : "";
            });
            $table->editColumn('details', function ($row) {
                return $row->details ? $row->details : "";
            });
            $table->editColumn('facebook_url', function ($row) {
                return $row->facebook_url ? $row->facebook_url : "";
            });
            $table->editColumn('whatsapp', function ($row) {
                return $row->whatsapp ? $row->whatsapp : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'images']);

            return $table->make(true);
        }

        return view('admin.traders.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('trader_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.traders.create');
    }

    public function store(StoreTraderRequest $request)
    {

        $trader = Trader::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $trader->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $trader->id]);
        }

        return redirect()->route('admin.traders.index');
    }

    public function edit(Trader $trader)
    {
        //abort_if(Gate::denies('trader_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.traders.edit', compact('trader'));
    }

    public function update(UpdateTraderRequest $request, Trader $trader)
    {
        $trader->update($request->all());

        if (count($trader->images) > 0) {
            foreach ($trader->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $trader->images->pluck('file_name')->toArray();

        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $trader->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.traders.index');
    }

    public function show(Trader $trader)
    {
        //abort_if(Gate::denies('trader_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.traders.show', compact('trader'));
    }

    public function destroy(Trader $trader)
    {
        //abort_if(Gate::denies('trader_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $trader->delete();

        return back();
    }

    public function massDestroy(MassDestroyTraderRequest $request)
    {
        Trader::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('trader_create') && Gate::denies('trader_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Trader();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    /**
     * upload from excel part in index blade
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadExcel(Request $request)
    {
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('excel_file'));

            Excel::import(new TradersImport($spreadsheet), $request->file('excel_file'));
            return back()->with('success', 'All good!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}
