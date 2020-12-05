<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubProductServiceTypeRequest;
use App\Http\Requests\StoreSubProductServiceTypeRequest;
use App\Http\Requests\UpdateSubProductServiceTypeRequest;
use App\Models\Category;
use App\Models\Helpers\PermissionHelper;
use App\Models\MainProductServiceType;
use App\Models\SubProductServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubProductServiceTypesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubProductServiceType::query()->select(sprintf('%s.*', (new SubProductServiceType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'category_show';
                $editGate      = 'category_edit';
                $deleteGate    = 'category_delete';
                $crudRoutePart = 'sub_product_service_types';

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
            $table->editColumn('main_product_service_type_id', function ($row) {
                return $row->MainProductServiceType ? $row->MainProductServiceType->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sub_product_service_types.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_service_types = MainProductServiceType::pluck('name', 'id');

        return view('admin.sub_product_service_types.create', compact('main_product_service_types'));
    }

    public function store(StoreSubProductServiceTypeRequest $request)
    {
        $sub_product_service_type = SubProductServiceType::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_product_service_type->name);

        return redirect()->route('admin.sub_product_service_types.index');
    }

    public function edit(SubProductServiceType $sub_product_service_type)
    {
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_service_types = MainProductServiceType::pluck('name', 'id');

        return view('admin.sub_product_service_types.edit', compact('sub_product_service_type', 'main_product_service_types'));
    }

    public function update(UpdateSubProductServiceTypeRequest $request, SubProductServiceType $sub_product_service_type)
    {
        $sub_product_service_type->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_product_service_type->name);

        return redirect()->route('admin.sub_product_service_types.index');
    }

    public function show(SubProductServiceType $sub_product_service_type)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sub_product_service_types.show', compact('sub_product_service_type'));
    }

    public function destroy(SubProductServiceType $sub_product_service_type)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_product_service_type->delete();

        return back();
    }

    public function massDestroy(MassDestroySubProductServiceTypeRequest $request)
    {
        SubProductServiceType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
