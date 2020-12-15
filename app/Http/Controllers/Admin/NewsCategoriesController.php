<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNewsCategoryRequest;
use App\Http\Requests\StoreNewsCategoryRequest;
use App\Http\Requests\UpdateNewsCategoryRequest;
use App\Models\Helpers\PermissionHelper;
use App\Models\NewsCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NewsCategoriesController extends Controller
{
    public function index(Request $request)
    {
        //abort_if(Gate::denies('news_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = NewsCategory::query()->select(sprintf('%s.*', (new NewsCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'news_category_show';
                $editGate      = 'news_category_edit';
                $deleteGate    = 'news_category_delete';
                $crudRoutePart = 'news_categories';

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

        return view('admin.news_categories.index');
    }

    public function create()
    {
        //abort_if(Gate::denies('news_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.news_categories.create');
    }

    public function store(StoreNewsCategoryRequest $request)
    {
        $news_category = NewsCategory::create($request->all());

        PermissionHelper::createPermissionWithModelAttribute($news_category->name);

        return redirect()->route('admin.news_categories.index');
    }

    public function edit(NewsCategory $news_category)
    {
        //abort_if(Gate::denies('news_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.news_categories.edit', compact('news_category'));
    }

    public function update(UpdateNewsCategoryRequest $request, NewsCategory $news_category)
    {
        $news_category->update($request->all());

        PermissionHelper::createPermissionWithModelAttribute($news_category->name);

        PermissionHelper::createPermissionWithModelAttribute($news_category->name);


        return redirect()->route('admin.news_categories.index');
    }

    public function show(NewsCategory $news_category)
    {
        //abort_if(Gate::denies('news_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $news_category->load('news_categoryDepartments', 'news_categoryOffers', 'news_categoryNews');

        return view('admin.news_categories.show', compact('news_category'));
    }

    public function destroy(NewsCategory $news_category)
    {
        //abort_if(Gate::denies('news_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_category->delete();

        return back();
    }

    public function massDestroy(MassDestroyNewsCategoryRequest $request)
    {
        NewsCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
