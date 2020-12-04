@can('offer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.offers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.offer.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.offer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-custom_fieldOffers">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.custom_field') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.add_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.date_end') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.phone_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.location') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.trader') }}
                        </th>
                        <th>
                            {{ trans('cruds.offer.fields.images') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $key => $offer)
                        <tr data-entry-id="{{ $offer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $offer->id ?? '' }}
                            </td>
                            <td>
                                {{ $offer->name ?? '' }}
                            </td>
                            <td>
                                {{ $offer->custom_field->name ?? '' }}
                            </td>
                            <td>
                                {{ $offer->add_date ?? '' }}
                            </td>
                            <td>
                                {{ $offer->date_end ?? '' }}
                            </td>
                            <td>
                                {{ $offer->phone_number ?? '' }}
                            </td>
                            <td>
                                {{ $offer->location ?? '' }}
                            </td>
                            <td>
                                {{ $offer->price ?? '' }}
                            </td>
                            <td>
                                {{ $offer->trader->name ?? '' }}
                            </td>
                            <td>
                                @foreach($offer->images as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('offer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.offers.show', $offer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('offer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.offers.edit', $offer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('offer_delete')
                                    <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('offer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.offers.massDestroy') }}",
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
  let table = $('.datatable-custom_fieldOffers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
