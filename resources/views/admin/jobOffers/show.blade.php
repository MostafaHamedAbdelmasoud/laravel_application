@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.jobOffer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.job-offers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.id') }}
                        </th>
                        <td>
                            {{ $jobOffer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.name') }}
                        </th>
                        <td>
                            {{ $jobOffer->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.photo') }}
                        </th>
                        <td>
                            @if($jobOffer->photo)
                                <a href="{{ $jobOffer->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $jobOffer->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.email') }}
                        </th>
                        <td>
                            {{ $jobOffer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $jobOffer->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.details') }}
                        </th>
                        <td>
                            {{ $jobOffer->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.cv') }}
                        </th>
                        <td>
                            @if($jobOffer->cv)
                                <a href="{{ $jobOffer->cv->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $jobOffer->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.specialization') }}
                        </th>
                        <td>
                            {{ $jobOffer->specialization->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.city') }}
                        </th>
                        <td>
                            {{ $jobOffer->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.add_date') }}
                        </th>
                        <td>
                            {{ $jobOffer->add_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.about') }}
                        </th>
                        <td>
                            {{ $jobOffer->about }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.age') }}
                        </th>
                        <td>
                            {{ $jobOffer->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.jobOffer.fields.years_of_experience') }}
                        </th>
                        <td>
                            {{ $jobOffer->years_of_experience }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.job-offers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection