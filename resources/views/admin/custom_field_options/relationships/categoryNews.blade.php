@can('news_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.news.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.news.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.news.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-custom_field_optionNews">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.news.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.news.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.news.fields.image') }}
                        </th>
                        <th>
                            {{ trans('cruds.news.fields.details') }}
                        </th>
                        <th>
                            {{ trans('cruds.news.fields.custom_field_option') }}
                        </th>
                        <th>
                            {{ trans('cruds.news.fields.city') }}
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
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $key => $news)
                        <tr data-entry-id="{{ $news->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $news->id ?? '' }}
                            </td>
                            <td>
                                {{ $news->name ?? '' }}
                            </td>
                            <td>
                                @if($news->image)
                                    <a href="{{ $news->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $news->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $news->details ?? '' }}
                            </td>
                            <td>
                                {{ $news->custom_field_option->name ?? '' }}
                            </td>
                            <td>
                                {{ $news->city->name ?? '' }}
                            </td>
                            <td>
                                {{ $news->add_date ?? '' }}
                            </td>
                            <td>
                                {{ $news->phone_number ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $news->approved ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $news->approved ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('news_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.news.show', $news->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('news_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.news.edit', $news->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('news_delete')
                                    <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('news_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.news.massDestroy') }}",
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
  let table = $('.datatable-custom_field_optionNews:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection