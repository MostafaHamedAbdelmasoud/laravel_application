@extends('layouts.admin')
@section('content')
    @can('news_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-6">
                <a class="btn btn-success" href="{{ route('admin.news.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.news.title_singular') }}
                </a>
            </div>
            @include('partials.addExcel',['route_name'=>'upload_news_excel'])

        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.news.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-News">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.city_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.details') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.price') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.detailed_title') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.news_category_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.news_sub_category_name') }}
                    </th>

                    <th>
                        {{ trans('cruds.news.fields.add_date') }}
                    </th>

                    <th>
                        {{ trans('cruds.news.fields.phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.news.fields.approved') }}
                    </th>

                    <th>
                        {{ trans('cruds.news.fields.added_by_admin') }}
                    </th>

                    <th>
                        {{ trans('cruds.news.fields.image') }}
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($cities as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>

                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($news_categories as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($news_sub_categories as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>

                    <td>
                    </td>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('news_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.news.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.news.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder', orderable: false, searchable: false},
                    {data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'city_name', name: 'city.name'},
                    {data: 'details', name: 'details'},
                    {data: 'price', name: 'price'},
                    {data: 'detailed_title', name: 'detailed_title'},
                    {data: 'news_category_name', name: 'news_category.name'},
                    {data: 'news_sub_category_name', name: 'news_sub_category.name'},
                    {data: 'add_date', name: 'add_date'},
                    {data: 'phone_number', name: 'phone_number'},
                    {data: 'approved', name: 'approved'},
                    {data: 'added_by_admin', name: 'added_by_admin'},

                    {data: 'image', name: 'image', sortable: false, searchable: false},
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 50,
            };
            let table = $('.datatable-News').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
        });

    </script>
@endsection
