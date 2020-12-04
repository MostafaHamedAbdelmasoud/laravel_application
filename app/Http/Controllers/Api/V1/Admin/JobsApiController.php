<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Filters\JobsFilter;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\Admin\JobResource;
use App\Models\Job;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JobsApiController extends Controller
{
    use MediaUploadingTrait;


    /**
     * @var JobsFilter
     */
    protected $filter;

    public function __construct(JobsFilter $filter)
    {
        $this->filter = $filter;
    }

    public function index(Request $request)
    {
//        abort_if(Gate::denies('index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $jobQueryBuilder = Job::filter($this->filter)->with(['city', 'specialization'])->where([['approved',1],['deleted_at'=>null]]);

        $city_id = $request['city_id'];
        $specialization_id = $request['specialization_id'];

        if (isset($city_id)) {
            $jobQueryBuilder = $jobQueryBuilder->where('city_id', $city_id);
        }
        if (isset($specialization_id)) {
            $jobQueryBuilder = $jobQueryBuilder->where('specialization_id', $specialization_id);
        }

        return new JobResource($jobQueryBuilder->latest()->get());
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->all());

        if ($request->input('image', false)) {
            $job->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new JobResource($job))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Job $job)
    {
        //abort_if(Gate::denies('job_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new JobResource($job->load(['city', 'specialization']));
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

        return (new JobResource($job))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Job $job)
    {
        //abort_if(Gate::denies('job_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $job->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
