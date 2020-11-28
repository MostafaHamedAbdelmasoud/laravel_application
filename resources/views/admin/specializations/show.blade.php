@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.specialization.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specializations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.specialization.fields.id') }}
                        </th>
                        <td>
                            {{ $specialization->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialization.fields.name') }}
                        </th>
                        <td>
                            {{ $specialization->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specializations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#specialization_jobs" role="tab" data-toggle="tab">
                {{ trans('cruds.job.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#specialization_job_offers" role="tab" data-toggle="tab">
                {{ trans('cruds.jobOffer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="specialization_jobs">
            @includeIf('admin.specializations.relationships.specializationJobs', ['jobs' => $specialization->specializationJobs])
        </div>
        <div class="tab-pane" role="tabpanel" id="specialization_job_offers">
            @includeIf('admin.specializations.relationships.specializationJobOffers', ['jobOffers' => $specialization->specializationJobOffers])
        </div>
    </div>
</div>

@endsection