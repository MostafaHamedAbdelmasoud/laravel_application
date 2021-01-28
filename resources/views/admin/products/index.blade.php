@extends('layouts.admin')
@section('content')
    @can('product_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-6">
                <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
                </a>
            </div>
            @include('partials.addExcel',['route_name'=>'upload_products_excel'])

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
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.id') }}
                    </th>


                    <th>
                        {{ trans('cruds.product.fields.is_available') }}
                    </th>
                    <th>
                        {{ trans('cruds.product.fields.name') }}
                    </th>

                    <th>
                        {{ trans('cruds.product.fields.brand') }}
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
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
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
                rowCallback: function (row, data, index) {
                    if (data['column'] <= 0) {
                        $(row).hide();
                    }
                },
                columns: [
                    {data: 'placeholder', name: 'placeholder', orderable: false, searchable: false},
                    {data: 'actions', name: '{{ trans('global.actions') }}', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'is_available', name: 'is_available'},
                    {data: 'name', name: 'name'},
                    {data: 'brand', name: 'brand'},
                    {data: 'product_code', name: 'product_code'},
                    {data: 'show_in_trader_page', name: 'showInTraderPage'},
                    {data: 'show_in_main_page', name: 'show_in_main_page'},
                    {data: 'image', name: 'image', sortable: false, searchable: false},
                    {data: 'price', name: 'price'},
                    {data: 'main_product_type_name', name: 'MainProductType.name'},
                    {data: 'sub_product_type_name', name: 'SubProductType.name'},
                    {data: 'main_product_service_type_name', name: 'MainProductServiceType.name'},
                    {data: 'sub_product_service_type_name', name: 'MainProductServiceType.name'},
                    {data: 'trader_name', name: 'trader.name'},
                    {data: 'department_name', name: 'department.name'},
                    {data: 'city_name', name: 'city.name'},
                    {data: 'show_trader_name', name: 'show_trader_name'},
                    {data: 'details', name: 'details'},
                    {data: 'detailed_title', name: 'detailed_title'},
                    {data: 'price_after_discount', name: 'price_after_discount'},
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
            var table1 = document.getElementById(".datatable-Product");

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
