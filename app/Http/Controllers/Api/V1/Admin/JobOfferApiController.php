<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Filters\JobOffersFilter;
use App\Http\Filters\JobsFilter;
use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Http\Resources\Admin\JobOfferResource;
use App\Models\JobOffer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobOfferApiController extends Controller
{
    use MediaUploadingTrait;


    public function __construct(JobOffersFilter $filter)
    {
        $this->filter = $filter;
    }


    public function index(Request $request)
    {
        //abort_if(Gate::denies('job_offer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOfferQueryBuilder = JobOffer::with(['specialization', 'city'])->filter($this->filter)->where('deleted_at', null);
        $details = $request['details'];
        if (isset($details)) {
            $jobOfferQueryBuilder = $jobOfferQueryBuilder->where('details', $details);
        }
        return new JobOfferResource($jobOfferQueryBuilder->latest()->get());
    }

    public function store(StoreJobOfferRequest $request)
    {
        $jobOffer = JobOffer::create($request->all());

        if ($request->input('photo', false)) {
            $jobOffer->addMedia(  $request->input('photo'))->toMediaCollection('photo');
        }

        if ($request->input('cv', false)) {
            $jobOffer->addMedia(  $request->input('cv'))->toMediaCollection('cv');
        }

        return (new JobOfferResource($jobOffer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show( $jobOffer)
    {
        //abort_if(Gate::denies('job_offer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JobOfferResource(JobOffer::findOrFail($jobOffer)->load(['specialization', 'city']));
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

        return (new JobOfferResource($jobOffer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(JobOffer $jobOffer)
    {
        //abort_if(Gate::denies('job_offer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $jobOffer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
