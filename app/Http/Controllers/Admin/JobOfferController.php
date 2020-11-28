<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyJobOfferRequest;
use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Models\City;
use App\Models\JobOffer;
use App\Models\Specialization;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class JobOfferController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        //abort_if(Gate::denies('job_offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = JobOffer::with(['specialization', 'city'])->select(sprintf('%s.*', (new JobOffer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'job_offer_show';
                $editGate      = 'job_offer_edit';
                $deleteGate    = 'job_offer_delete';
                $crudRoutePart = 'job-offers';

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
            $table->editColumn('photo', function ($row) {
                if ($photo = $row->photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : "";
            });
            $table->editColumn('details', function ($row) {
                return $row->details ? $row->details : "";
            });
            $table->editColumn('cv', function ($row) {
                return $row->cv ? '<a href="' . $row->cv->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->addColumn('specialization_name', function ($row) {
                return $row->specialization ? $row->specialization->name : '';
            });

            $table->addColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : '';
            });

            $table->editColumn('about', function ($row) {
                return $row->about ? $row->about : "";
            });
            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : "";
            });
            $table->editColumn('years_of_experience', function ($row) {
                return $row->years_of_experience ? $row->years_of_experience : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'photo', 'cv', 'approved', 'specialization', 'city']);

            return $table->make(true);
        }

        $specializations = Specialization::get();
        $cities          = City::get();

        return view('admin.jobOffers.index', compact('specializations', 'cities'));
    }

    public function create()
    {
        //abort_if(Gate::denies('job_offer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.jobOffers.create', compact('specializations', 'cities'));
    }

    public function store(StoreJobOfferRequest $request)
    {
        $jobOffer = JobOffer::create($request->all());

        if ($request->input('photo', false)) {
            $jobOffer->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        if ($request->input('cv', false)) {
            $jobOffer->addMedia(storage_path('tmp/uploads/' . $request->input('cv')))->toMediaCollection('cv');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $jobOffer->id]);
        }

        return redirect()->route('admin.job-offers.index');
    }

    public function edit(JobOffer $jobOffer)
    {
        //abort_if(Gate::denies('job_offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specializations = Specialization::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $jobOffer->load('specialization', 'city');

        return view('admin.jobOffers.edit', compact('specializations', 'cities', 'jobOffer'));
    }

    public function update(UpdateJobOfferRequest $request, JobOffer $jobOffer)
    {
        $jobOffer->update($request->all());

        if ($request->input('photo', false)) {
            if (!$jobOffer->photo || $request->input('photo') !== $jobOffer->photo->file_name) {
                if ($jobOffer->photo) {
                    $jobOffer->photo->delete();
                }

                $jobOffer->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
            }
        } elseif ($jobOffer->photo) {
            $jobOffer->photo->delete();
        }

        if ($request->input('cv', false)) {
            if (!$jobOffer->cv || $request->input('cv') !== $jobOffer->cv->file_name) {
                if ($jobOffer->cv) {
                    $jobOffer->cv->delete();
                }

                $jobOffer->addMedia(storage_path('tmp/uploads/' . $request->input('cv')))->toMediaCollection('cv');
            }
        } elseif ($jobOffer->cv) {
            $jobOffer->cv->delete();
        }

        return redirect()->route('admin.job-offers.index');
    }

    public function show(JobOffer $jobOffer)
    {
        //abort_if(Gate::denies('job_offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffer->load('specialization', 'city');

        return view('admin.jobOffers.show', compact('jobOffer'));
    }

    public function destroy(JobOffer $jobOffer)
    {
        //abort_if(Gate::denies('job_offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffer->delete();

        return back();
    }

    public function massDestroy(MassDestroyJobOfferRequest $request)
    {
        JobOffer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        //abort_if(Gate::denies('job_offer_create') && Gate::denies('job_offer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new JobOffer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
