@extends('layouts.admin')
@section('content')
@can('trader_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-6">
            <a class="btn btn-success" href="{{ route('admin.traders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.trader.title_singular') }}
            </a>
        </div>
        @include('partials.addExcel',['route_name'=>'upload_traders_excel'])

    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.trader.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Trader">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        &nbsp;
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.activeness') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.images') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.details') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.facebook_url') }}
                    </th>
                    <th>
                        {{ trans('cruds.trader.fields.whatsapp') }}
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
@can('trader_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.traders.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
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
    ajax: "{{ route('admin.traders.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' , orderable: false, searchable: false},
{ data: 'actions', name: '{{ trans('global.actions') }}' , orderable: false, searchable: false},
{ data: 'id', name: 'id' },
{ data: 'activeness', name: 'activeness' },
{ data: 'images', name: 'images', sortable: false, searchable: false },
{ data: 'name', name: 'name' },
{ data: 'address', name: 'address' },
{ data: 'phone_number', name: 'phone_number' },
{ data: 'details', name: 'details' },
{ data: 'facebook_url', name: 'facebook_url' },
{ data: 'whatsapp', name: 'whatsapp' },
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Trader').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
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
