<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubCategoryRequest;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\Helpers\PermissionHelper;
use App\Models\SubCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SubCategoriesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SubCategory::query()->select(sprintf('%s.*', (new SubCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'sub_category_show';
                $editGate      = 'sub_category_edit';
                $deleteGate    = 'sub_category_delete';
                $crudRoutePart = 'sub_categories';

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
            $table->editColumn('category_id', function ($row) {
                return $row->category ? $row->category->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sub_categories.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');

        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $sub_category = SubCategory::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_category->name);


        return redirect()->route('admin.sub_categories.index');
    }

    public function edit(SubCategory $sub_category)
    {
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');


        return view('admin.sub_categories.edit', compact('sub_category', 'categories'));
    }

    public function update(UpdateSubCategoryRequest $request, SubCategory $sub_category)
    {
        $sub_category->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($sub_category->name);

        return redirect()->route('admin.sub_categories.index');
    }

    public function show(SubCategory $sub_category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sub_categories.show', compact('sub_category'));
    }

    public function destroy(SubCategory $sub_category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_category->delete();

        return back();
    }

    public function massDestroy(MassDestroySubCategoryRequest $request)
    {
        SubCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
