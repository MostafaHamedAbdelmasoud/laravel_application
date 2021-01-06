<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyNewsRequest;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Imports\NewsImport;
use App\Models\Category;
use App\Models\City;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsSubCategory;
use App\Models\Offer;
use App\Repositories\GateRepository;
use App\Repositories\NewsRepository;
use Dotenv\Exception\ValidationException;
use Gate;
use Illuminate\Http\Request;
use Excel;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    use MediaUploadingTrait;

    /**
     * @var GateRepository
     */
    private $repo;


    /**
     * ProductsController constructor.
     * @param GateRepository $repo
     */
    public function __construct(GateRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        //abort_if(Gate::denies('news_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->repo->user = auth()->user();

        if ($request->ajax()) {
            $query = News::with(['news_category', 'news_sub_category','city'])->select(sprintf('%s.*', (new News)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $parameters = [
                    $row->news_category->name,
                    $row->news_sub_category->name,
                ];

                $viewGate = $this->repo->get_gate($parameters, 'news', '_show');
                $editGate = $this->repo->get_gate($parameters, 'news', '_edit');
                $deleteGate = $this->repo->get_gate($parameters, 'news', '_delete');

                $crudRoutePart = 'news';

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

            $table->editColumn('added_by_admin', function ($row) {
                return $row->added_by_admin ;
            });

            $table->editColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : "";
            });

            $table->editColumn('details', function ($row) {
                return $row->details ? $row->details : "";
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : "";
            });

            $table->editColumn('detailed_title', function ($row) {
                return $row->detailed_title ? $row->detailed_title : "";
            });

            $table->addColumn('news_sub_category_name', function ($row) {
                return $row->news_sub_category ? $row->news_sub_category->name : '';
            });

            $table->addColumn('news_category_name', function ($row) {
                return $row->news_category ? $row->news_category->name : '';
            });

            $table->editColumn('add_date', function ($row) {
                return $row->add_date ? $row->add_date : "";
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : "";
            });

            $table->editColumn('approved', function ($row) {
                return $row->approved ;
            });

            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'trader', 'image']);

            return $table->make(true);
        }


        $news = News::all();

        $news_categories = NewsCategory::get();

        $news_sub_categories = NewsSubCategory::get();

        $cities = City::get();

        return view('admin.news.index', compact('news', 'news_categories', 'news_sub_categories', 'cities'));
    }

    public function create()
    {
        //abort_if(Gate::denies('news_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_categories = NewsCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.news.create', compact('news_categories', 'cities'));
    }

    public function store(StoreNewsRequest $request)
    {
        $request['added_by_admin'] = 1;

        $news = News::create($request->all());

        if ($request->input('image', false)) {
            foreach ($request->input('image') as $image) {
                $news->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('image');
            }
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $news->id]);
        }

        return redirect()->route('admin.news.index');
    }

    public function edit(News $news)
    {
        //abort_if(Gate::denies('news_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news_categories = NewsCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $news_sub_categories = NewsSubCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $news->load('news_category', 'city');

        return view('admin.news.edit', compact('news_categories', 'cities', 'news', 'news_sub_categories'));
    }

    public function update(UpdateNewsRequest $request, News $news)
    {
        $request['approved'] = $request['approved'] ? 1 : 0;

        $news->update($request->all());
        $news_repo = new NewsRepository;

        if ($request->input('image', false)) {
            $news_repo->updateMedia($news, $news->getMedia('image'), $request->input('image'));
        } elseif ($news->image) {
            $news->image->delete();
        }

        return redirect()->route('admin.news.index');
    }

    public function show(News $news)
    {
        //abort_if(Gate::denies('news_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->load('news_category', 'city');

        $news_medias = $news->getMedia('image');
        return view('admin.news.show', compact('news', 'news_medias'));
    }

    public function destroy(News $news)
    {
        //abort_if(Gate::denies('news_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $news->delete();

        return back();
    }

    public function massDestroy(MassDestroyNewsRequest $request)
    {
        News::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('news_create') && Gate::denies('news_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new News();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    /**
     * upload from excel part in index blade
     *
     * @param Request $request
     * @return string
     */
    public function uploadExcel(Request $request)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('excel_file'));


        $lol = Excel::import(new NewsImport($spreadsheet), $request->file('excel_file'));
//        dd('s');
        return back()->with('success', 'All good!');
//        try {
//
//
//        } catch (ValidationException $e)  {
////            return back()->with('error', $e->getMessage());
//            return  $e->getMessage();
//        }
    }
}
