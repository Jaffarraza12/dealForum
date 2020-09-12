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
       Coupon Code
    </div>

    <div class="m-auto w-550">
        <form action="/public/validate-coupon" method="POST">
           @csrf 

            <div class="form-control">
                  <input type="text" name="coupon" value="{{$code}}" />

            </div>
            <button type="submit" class="btn btn-danger">CHECK</button> 
          
        </form>

    </div>
     @if($coupon !== "")
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
              <div class="card">
                 <div class="card-header"><i class="nav-icon fas fa-fw fa-user"></i> Customer Detail</div>
                 <div class="card-body">
                  @if($coupon->name !== "")
                    <h2>{{$coupon->name}}</h2>
                    <h4>{{$coupon->email}}</h4>
                    <h4>{{$coupon->phone}}</h4>
                  @else
                    <p>No Customer Assign to it.</p>
                  
                  @endif  
                 </div>
              </div>
            </div> 
            <div class="col-lg-6">
                 <div class="card">
                 <div class="card-header"> <i class="nav-icon fas fa-fw fa-percent"></i> Coupon Detail</div>
                 <div class="card-body">
                    <img src="http://deal-forum.com/asset/{{$coupon->image}}" width="100" height="auto" />
                    <h2><i class="nav-icon fas fa-fw fa-building"></i> {{$coupon->COMPANY}}</h2>
                    <h4><i class="nav-icon fas fa-fwfa-tag"></i> {{$coupon->DEAL}}</h4>
                    <h4><i class="nav-icon fas fa-fw fa-tag"></i>{{$coupon->discount}} % OFF</h4>
                 </div>
              </div>
            </div> 
           
        </div>


    </div>
    @endif
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