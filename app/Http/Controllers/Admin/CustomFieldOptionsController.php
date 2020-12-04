<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomFieldOptionRequest;
use App\Http\Requests\StoreCustomFieldOptionRequest;
use App\Http\Requests\UpdateCustomFieldOptionRequest;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CustomFieldOptionsController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('custom_field_option_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CustomFieldOption::query()->select(sprintf('%s.*', (new CustomFieldOption)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'custom_field_option_show';
                $editGate = 'custom_field_option_edit';
                $deleteGate = 'custom_field_option_delete';
                $crudRoutePart = 'custom_field_options';

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

            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });

            $table->editColumn('product_id', function ($row) {
                return $row->product ? $row->product->name : "";
            });

            $table->editColumn('custom_field_id', function ($row) {
                return $row->customField ? $row->customField->type : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.custom_field_options.index');
    }

    public function create()
    {
        $products = Product::pluck('name', 'id');

        $custom_fields = CustomField::pluck('type', 'id');

        return view('admin.custom_field_options.create', compact('products', 'custom_fields'));
    }

    public function store(StoreCustomFieldOptionRequest $request)
    {
        foreach ($request->products as $key=>$id) {
            $request_new = array_merge($request->except('products'), [
                'product_id'=>$id,
                'custom_field_id'=>$request->custom_field_id,
            ]);
            $custom_field_option = CustomFieldOption::create($request_new);
        }

        return redirect()->route('admin.custom_field_options.index');
    }

    public function edit(CustomFieldOption $custom_field_option)
    {
        //abort_if(Gate::denies('custom_field_option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.custom_field_options.edit', compact('custom_field_option'));
    }

    public function update(UpdateCustomFieldOptionRequest $request, CustomFieldOption $custom_field_option)
    {
        $custom_field_option->update($request->all());

        return redirect()->route('admin.custom_field_options.index');
    }

    public function show(CustomFieldOption $custom_field_option)
    {
        return view('admin.custom_field_options.show', compact('custom_field_option'));
    }

    public function destroy(CustomFieldOption $custom_field_option)
    {
        //abort_if(Gate::denies('custom_field_option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $custom_field_option->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomFieldOptionRequest $request)
    {
        CustomFieldOption::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
