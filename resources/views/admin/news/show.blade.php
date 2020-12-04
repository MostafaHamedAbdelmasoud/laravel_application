@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.news.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.news.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.id') }}
                        </th>
                        <td>
                            {{ $news->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.name') }}
                        </th>
                        <td>
                            {{ $news->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.image') }}
                        </th>
                        <td>
                            @if($news->image)
                                @forelse($news_medias as $news_media)
                                    <a href="{{ $news_media->getUrl() }}" target="_blank"
                                       style="display: inline-block">
                                        <img src="{{ $news_media->getUrl('thumb') }}">
                                    </a>
                                @empty
                                @endforelse
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.details') }}
                        </th>
                        <td>
                            {{ $news->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.detailed_title') }}
                        </th>
                        <td>
                            {{ $news->detailed_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.news_category') }}
                        </th>
                        <td>
                            {{ $news->news_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.news_sub_category') }}
                        </th>
                        <td>
                            {{ $news->news_sub_category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.city') }}
                        </th>
                        <td>
                            {{ $news->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.add_date') }}
                        </th>
                        <td>
                            {{ $news->add_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $news->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.price') }}
                        </th>
                        <td>
                            {{ $news->price_value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.approved') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $news->approved ? 'checked' : '' }}>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.news.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
