<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubProductTypeRequest;
use App\Http\Requests\StoreSubProductTypeRequest;
use App\Http\Requests\UpdateSubProductTypeRequest;
use App\Models\Category;
use App\Models\Helpers\PermissionHelper;
use App\Models\MainProductType;
use App\Models\SubProductType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubProductTypesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubProductType::with('MainProductType')->select(sprintf('%s.*', (new SubProductType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'sub_product_type_show';
                $editGate      = 'sub_product_type_edit';
                $deleteGate    = 'sub_product_type_delete';
                $crudRoutePart = 'sub_product_types';

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
            $table->addColumn('main_product_type_name', function ($row) {
                return $row->MainProductType ? $row->MainProductType->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sub_product_types.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_types = MainProductType::pluck('name', 'id');

        return view('admin.sub_product_types.create', compact('main_product_types'));
    }

    public function store(StoreSubProductTypeRequest $request)
    {
        $sub_product_type = SubProductType::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_product_type->name);

        return redirect()->route('admin.sub_product_types.index');
    }

    public function edit(SubProductType $sub_product_type)
    {
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_types = MainProductType::pluck('name', 'id');


        return view('admin.sub_product_types.edit', compact('sub_product_type', 'main_product_types'));
    }

    public function update(UpdateSubProductTypeRequest $request, SubProductType $sub_product_type)
    {
        $sub_product_type->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_product_type->name);

        return redirect()->route('admin.sub_product_types.index');
    }

    public function show(SubProductType $sub_product_type)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sub_product_types.show', compact('sub_product_type'));
    }

    public function destroy(SubProductType $sub_product_type)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_product_type->delete();

        return back();
    }

    public function massDestroy(MassDestroySubProductTypeRequest $request)
    {
        SubProductType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
