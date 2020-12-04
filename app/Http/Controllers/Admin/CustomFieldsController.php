<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomFieldRequest;
use App\Http\Requests\StoreCustomFieldRequest;
use App\Http\Requests\UpdateCustomFieldRequest;
use App\Models\CustomField;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CustomFieldsController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('custom_field_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CustomField::query()->select(sprintf('%s.*', (new CustomField)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'custom_field_show';
                $editGate      = 'custom_field_edit';
                $deleteGate    = 'custom_field_delete';
                $crudRoutePart = 'custom_fields';

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

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.custom_fields.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('custom_field_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.custom_fields.create');
    }

    public function store(StoreCustomFieldRequest $request)
    {
        CustomField::create($request->all());

        return redirect()->route('admin.custom_fields.index');
    }

    public function edit(CustomField $custom_field)
    {
        //abort_if(Gate::denies('custom_field_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.custom_fields.edit', compact('custom_field'));
    }

    public function update(UpdateCustomFieldRequest $request, CustomField $custom_field)
    {
        $custom_field->update($request->all());

        return redirect()->route('admin.custom_fields.index');
    }

    public function show(CustomField $custom_field)
    {
        return view('admin.custom_fields.show', compact('custom_field'));
    }

    public function destroy(CustomField $custom_field)
    {
        //abort_if(Gate::denies('custom_field_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $custom_field->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomFieldRequest $request)
    {
        CustomField::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
