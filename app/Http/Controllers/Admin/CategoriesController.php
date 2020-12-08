<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Helpers\PermissionHelper;
use App\Repositories\CouponRepository;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    protected $repo;

    public function __construct(CouponRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        // abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Category::query()->select(sprintf('%s.*', (new Category)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
//                $name_seperated = explode(' ',$row->name);
//                $name_imploded_with_underscore  = implode('_',$name_seperated);
                $viewGate      = 'category_show';
//                $viewGate      = $name_imploded_with_underscore.'_show';
                $editGate      = 'category_edit';
//                $editGate      = $name_imploded_with_underscore.'_edit';
                $deleteGate    = 'category_delete';
//                $deleteGate    = $name_imploded_with_underscore.'_delete';
                $crudRoutePart = 'categories';

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
            $table->editColumn('type', function ($row) {
                return $row->type ? Category::TYPE_RADIO[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.categories.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($category->name);

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($category->name);

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        //abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->load('categoryDepartments', 'categoryOffers', 'categoryNews');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
