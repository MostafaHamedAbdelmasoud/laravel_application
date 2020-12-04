<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMainProductTypeRequest;
use App\Http\Requests\StoreMainProductTypeRequest;
use App\Http\Requests\UpdateMainProductTypeRequest;
use App\Models\MainProductType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MainProductTypesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('main_product_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MainProductType::query()->select(sprintf('%s.*', (new MainProductType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'category_show';
                $editGate      = 'category_edit';
                $deleteGate    = 'category_delete';
                $crudRoutePart = 'main_product_types';

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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.main_product_types.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('main_product_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_types.create');
    }

    public function store(StoreMainProductTypeRequest $request)
    {
        $main_product_type = MainProductType::create($request->all());

        return redirect()->route('admin.main_product_types.index');
    }

    public function edit(MainProductType $main_product_type)
    {
        //abort_if(Gate::denies('main_product_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_types.edit', compact('main_product_type'));
    }

    public function update(UpdateMainProductTypeRequest $request, MainProductType $main_product_type)
    {
        $main_product_type->update($request->all());

        return redirect()->route('admin.main_product_types.index');
    }

    public function show(MainProductType $main_product_type)
    {
        //abort_if(Gate::denies('main_product_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_types.show', compact('main_product_type'));
    }

    public function destroy(MainProductType $main_product_type)
    {
        //abort_if(Gate::denies('main_product_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_type->delete();

        return back();
    }

    public function massDestroy(MassDestroyMainProductTypeRequest $request)
    {
        MainProductType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
