@extends('layouts.admin')
@section('content')
<style>
  .nameCat{
    border-right:1px solid #cfcfcf ;
    padding-right: 5px;
  }
  .nameCat:last-child{
    border-right:none; ;
  }
</style>
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route("coupons.create") }}">
            New Coupon
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Coupons
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                           Id
                        </th>
                        <th>
                            Deal
                        </th>
                        <th>
                           Limit/Counsumed
                        </th>
                        <th>
                            coupon
                        </th>
                        <th>
                            End
                        </th>
                      
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                      <tr data-entry-id="{{ $coupon->id  ?? '' }}">
                            <td>

                            </td>
                            <td>
                                {{ $coupon->id ?? '' }}
                            </td>
                            <td>
                                
                              {{ $coupon->dealing['name'] ?? '' }}
                            </td>
                            <td>
                                {{  $coupon->consumed.'/'.$coupon->limit ?? '' }}
                            </td>
                           <td>
                                {{ $coupon->code ?? '' }}
                            </td>
                            <td>
                                {{ $coupon->end ?? '' }}
                            </td>
                            <td>
                                <a class="btn btn-xs btn-info" href="{{ route('coupons.edit', $coupon->id) }}">
                                    {{ trans('global.edit') }}
                                </a>

                                 <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {  
    text: deleteButtonTrans,
    url: "{{ route('coupon.massDestroy') }}",
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
          .done(function () { location.reload() 
          })
      }
    }
  }
  dtButtons.push(deleteButton)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection