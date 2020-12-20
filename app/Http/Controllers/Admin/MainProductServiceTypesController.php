<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMainProductServiceTypeRequest;
use App\Http\Requests\StoreMainProductServiceTypeRequest;
use App\Http\Requests\UpdateMainProductServiceTypeRequest;
use App\Models\Helpers\PermissionHelper;
use App\Models\MainProductServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MainProductServiceTypesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('main_product_service_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MainProductServiceType::query()->select(sprintf('%s.*', (new MainProductServiceType)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'main_product_service_type_show';
                $editGate      = 'main_product_service_type_edit';
                $deleteGate    = 'main_product_service_type_delete';
                $crudRoutePart = 'main_product_service_types';

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

        return view('admin.main_product_service_types.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('main_product_service_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_service_types.create');
    }

    public function store(StoreMainProductServiceTypeRequest $request)
    {
        $main_product_service_type = MainProductServiceType::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($main_product_service_type->name);

        return redirect()->route('admin.main_product_service_types.index');
    }

    public function edit(MainProductServiceType $main_product_service_type)
    {
        //abort_if(Gate::denies('main_product_service_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_service_types.edit', compact('main_product_service_type'));
    }

    public function update(UpdateMainProductServiceTypeRequest $request, MainProductServiceType $main_product_service_type)
    {
        $main_product_service_type->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($main_product_service_type->name);


        return redirect()->route('admin.main_product_service_types.index');
    }

    public function show(MainProductServiceType $main_product_service_type)
    {
        //abort_if(Gate::denies('main_product_service_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.main_product_service_types.show', compact('main_product_service_type'));
    }

    public function destroy(MainProductServiceType $main_product_service_type)
    {
        //abort_if(Gate::denies('main_product_service_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $main_product_service_type->delete();

        return back();
    }

    public function massDestroy(MassDestroyMainProductServiceTypeRequest $request)
    {
        MainProductServiceType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
