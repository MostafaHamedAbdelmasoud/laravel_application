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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-specializationJobOffers">
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
                </thead>
                <tbody>
                    @foreach($jobOffers as $key => $jobOffer)
                        <tr data-entry-id="{{ $jobOffer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $jobOffer->id ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->name ?? '' }}
                            </td>
                            <td>
                                @if($jobOffer->photo)
                                    <a href="{{ $jobOffer->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $jobOffer->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $jobOffer->email ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->phone_number ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->details ?? '' }}
                            </td>
                            <td>
                                @if($jobOffer->cv)
                                    <a href="{{ $jobOffer->cv->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span style="display:none">{{ $jobOffer->approved ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $jobOffer->approved ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $jobOffer->specialization->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->city->name ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->add_date ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->about ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->age ?? '' }}
                            </td>
                            <td>
                                {{ $jobOffer->years_of_experience ?? '' }}
                            </td>
                            <td>
                                @can('job_offer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.job-offers.show', $jobOffer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('job_offer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.job-offers.edit', $jobOffer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('job_offer_delete')
                                    <form action="{{ route('admin.job-offers.destroy', $jobOffer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('job_offer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.job-offers.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-specializationJobOffers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection