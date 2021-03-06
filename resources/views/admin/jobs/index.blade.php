@extends('layouts.admin')
@section('content')
    @can('job_create')


            <div style="margin-bottom: 10px;" class="row ">
                <div class="col-md-6 text-right ">

                    <form enctype="multipart/form-data" action="{{route('admin.upload_jobs_excel')}}" method="post">
                        @csrf


                        <div class="file-field">
                            <div class="btn btn-success  btn-sm float-left text-left">
                                <span>ملف الإكسل </span>
                                <br>
                                <input type="file" name="excel_file">
                                <button class="btn btn-success">حفظ</button>
                            </div>
                            </div>
                    </form>

                </div>
                <div class="col-md-6 text-right ">

                    @if(session('success'))
                        <div class="alert alert-success">تم الإضافة</div>
                    @endif
                </div>
            </div>


            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12 my-4">
                    <a class="btn btn-success" href="{{ route('admin.jobs.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.job.title_singular') }}
                    </a>
                </div>


            </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.job.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Job">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.approved') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.city') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.add_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.details') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.specialization') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.whats_app_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.job.fields.email') }}
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
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
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($cities as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($specializations as $key => $item)
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
            @can('job_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.jobs.massDestroy') }}",
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
                ajax: "{{ route('admin.jobs.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder', orderable: false, searchable: false},
                    {data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'approved', name: 'approved'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image', sortable: false, searchable: false},
                    {data: 'city_name', name: 'city.name'},
                    {data: 'add_date', name: 'add_date'},
                    {data: 'whats_app_number', name: 'whats_app_number'},
                    {data: 'specialization_name', name: 'specialization.name'},
                    {data: 'details', name: 'details'},
                    {data: 'email', name: 'email'},
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 50,
            };
            let table = $('.datatable-Job').DataTable(dtOverrideGlobals);
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
