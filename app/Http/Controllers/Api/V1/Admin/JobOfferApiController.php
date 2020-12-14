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

        $jobOfferQueryBuilder = JobOffer::with('specialization', 'city')->filter($this->filter)->where([['deleted_at', null], ['approved', 1]]);

        $details = $request['details'];

        $city_id = $request['city_id'];
        $specialization_id = $request['specialization_id'];


        if (isset($specialization_id)) {
            $jobOfferQueryBuilder = $jobOfferQueryBuilder->where('specialization_id', $specialization_id);
        }
        if (isset($city_id)) {
            $jobOfferQueryBuilder = $jobOfferQueryBuilder->where('city_id', $city_id);
        }
        if (isset($details)) {
            $jobOfferQueryBuilder = $jobOfferQueryBuilder->where('details', 'like', "%$details%");
        }
        return new JobOfferResource($jobOfferQueryBuilder->latest()->get());
    }

    public function store(StoreJobOfferRequest $request)
    {
        $jobOffer = JobOffer::create($request->all());

        //        $cnt = count($request->file('image'));

        $path = storage_path('tmp/uploads');
        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        if ($request->hasFile('photo')) {

            //            for ($i = 0; $i < $cnt; $i++) {

            //                $photo = $request->file('photo')[$i];
            $photo = $request->file('photo');

            $name = uniqid() . '_' . trim($photo->getClientOriginalName());

            $photo->move($path, $name);

            $jobOffer->addMedia(storage_path('tmp/uploads/' . $name))->toMediaCollection('photo');

            //            }

        }


        if ($request->hasFile('cv')) {

            $cv = $request->file('cv');

            $name = uniqid() . '_' . trim($cv->getClientOriginalName());

            $cv->move($path, $name);

            $jobOffer->addMedia(storage_path('tmp/uploads/' . $name))->toMediaCollection('cv');
        }


        return (new JobOfferResource($jobOffer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show($jobOffer)
    {
        return JobOffer::findOrFail($jobOffer)->first();
        //            ->cv;
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
