<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobRequest;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\City;
use App\Models\Job;
use App\Models\Specialization;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class JobsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('job_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Job::with(['city', 'specialization'])->select(sprintf('%s.*', (new Job)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'job_show';
                $editGate      = 'job_edit';
                $deleteGate    = 'job_delete';
                $crudRoutePart = 'jobs';

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
            $table->addColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : '';
            });

            $table->editColumn('details', function ($row) {
                return $row->details ? $row->details : "";
            });
            $table->addColumn('specialization_name', function ($row) {
                return $row->specialization ? $row->specialization->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'city', 'specialization']);

            return $table->make(true);
        }

        $cities          = City::get();
        $specializations = Specialization::get();

        return view('admin.jobs.index', compact('cities', 'specializations'));
    }

    public function create()
    {
        //abort_if(Gate::denies('job_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.jobs.create', compact('cities', 'specializations'));
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->all());

        if ($request->input('image', false)) {
            $job->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $job->id]);
        }

        return redirect()->route('admin.jobs.index');
    }

    public function edit(Job $job)
    {
        //abort_if(Gate::denies('job_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $job->load('city', 'specialization');

        return view('admin.jobs.edit', compact('cities', 'specializations', 'job'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $job->update($request->all());

        if ($request->input('image', false)) {
            if (!$job->image || $request->input('image') !== $job->image->file_name) {
                if ($job->image) {
                    $job->image->delete();
                }

                $job->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($job->image) {
            $job->image->delete();
        }

        return redirect()->route('admin.jobs.index');
    }

    public function show(Job $job)
    {
        //abort_if(Gate::denies('job_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job->load('city', 'specialization');

        return view('admin.jobs.show', compact('job'));
    }

    public function destroy(Job $job)
    {
        //abort_if(Gate::denies('job_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobRequest $request)
    {
        Job::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('job_create') && Gate::denies('job_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Job();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
