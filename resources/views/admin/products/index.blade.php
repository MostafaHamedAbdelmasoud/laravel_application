@extends('layouts.admin')
@section('content')
    @can('product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.product.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Product">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.product.fields.id') }}
                    </th>

                    <th>
                        {{ trans('cruds.product.fields.product_code') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.show_in_trader_page') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.show_in_main_page') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.price') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.main_product_type_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.sub_product_type_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.main_product_service_type_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.sub_product_service_type_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.trader') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.department_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.city_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.show_trader_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.details') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.detailed_title') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.price_after_discount') }}
                    </th>
                    <th>
                        &nbsp;
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
                    </td>
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
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($main_product_types as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($sub_product_types as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($main_product_service_types as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($sub_product_service_types as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($traders as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($departments as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
            @can('product_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.products.massDestroy') }}",
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
                ajax: "{{ route('admin.products.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'id', name: 'id'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'show_in_trader_page', name: 'show_in_trader_page'},
                    {data: 'show_in_main_page', name: 'show_in_main_page'},
                    {data: 'image', name: 'image', sortable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'main_product_type_name', name: 'main_product_type_name'},
                    {data: 'sub_product_type_name', name: 'sub_product_type_name'},
                    {data: 'main_product_service_type_name', name: 'main_product_service_type_name'},
                    {data: 'sub_product_service_type_name', name: 'sub_product_service_type_name'},
                    {data: 'trader_name', name: 'trader_name'},
                    {data: 'department_name', name: 'department_name'},
                    {data: 'city_name', name: 'city_name'},
                    {data: 'show_trader_name', name: 'show_trader_name'},
                    {data: 'details', name: 'details'},
                    {data: 'detailed_title', name: 'detailed_title'},
                    {data: 'price_after_discount', name: 'price_after_discount'},

                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 50,
            };
            let table = $('.datatable-Product').DataTable(dtOverrideGlobals);
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
