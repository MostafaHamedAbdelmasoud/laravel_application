@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.trader.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.traders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.id') }}
                        </th>
                        <td>
                            {{ $trader->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.images') }}
                        </th>
                        <td>
                            @foreach($trader->images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.name') }}
                        </th>
                        <td>
                            {{ $trader->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.address') }}
                        </th>
                        <td>
                            {{ $trader->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $trader->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.details') }}
                        </th>
                        <td>
                            {{ $trader->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.facebook_url') }}
                        </th>
                        <td>
                            {{ $trader->facebook_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.trader.fields.whatsapp') }}
                        </th>
                        <td>
                            {{ $trader->whatsapp }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.traders.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection