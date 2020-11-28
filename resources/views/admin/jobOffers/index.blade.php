@extends('layouts.admin')
@section('content')
@can('job_offer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.job-offers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.jobOffer.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.jobOffer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-JobOffer">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.photo') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.phone_number') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.details') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.cv') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.approved') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.specialization') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.city') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.add_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.about') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.age') }}
                    </th>
                    <th>
                        {{ trans('cruds.jobOffer.fields.years_of_experience') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
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
                    </td>
                    <td>
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
@can('job_offer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-offers.massDestroy') }}",
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
    ajax: "{{ route('admin.job-offers.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'photo', name: 'photo', sortable: false, searchable: false },
{ data: 'email', name: 'email' },
{ data: 'phone_number', name: 'phone_number' },
{ data: 'details', name: 'details' },
{ data: 'cv', name: 'cv', sortable: false, searchable: false },
{ data: 'approved', name: 'approved' },
{ data: 'specialization_name', name: 'specialization.name' },
{ data: 'city_name', name: 'city.name' },
{ data: 'add_date', name: 'add_date' },
{ data: 'about', name: 'about' },
{ data: 'age', name: 'age' },
{ data: 'years_of_experience', name: 'years_of_experience' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  };
  let table = $('.datatable-JobOffer').DataTable(dtOverrideGlobals);
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