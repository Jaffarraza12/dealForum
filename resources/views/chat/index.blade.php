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
  .chatBox{
    background:#fff;
    min-height: 400px;
    overflow: hidden;
    overflow-y:scroll;

  }
  .user{margin:5px 0px;color:#0056ad;}
  .chatBox{
    margin:5px 0px;
  }
  .bold{font-weight:bold;}
</style>
<div class="card">
    <div class="card-header">
        Chat   
        <div class="row h-100">
           <div class="col-sm-12 my-auto">
             <div class="card card-block w-25">
              <select class="room-select" id="inputGroupSelect01">
                
                  @foreach($rooms as $room)
                    <option {{($roomId == $room->id) ? 'selected' }} value="{{$room->id}}">{{$room->name}}</option>
                  @endforeach
                </select>
            </div>
           </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-8">
              <div class="chatBox">
                  @foreach($chatMessages as $message)
                      <div> <span class="bold">{{$message->name}}:</span> {{$message->message}}</div>

                  @endforeach

              </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
                    Chat Room User   

                </div>
                <div class="card-body">
                  @foreach($users as $user)
                    <a class="user" >{{$user->name}} ({{($user->status == 1) ? 'active' : 'block'  }})</a><br/>
                  @endforeach
                </div>
              </div>
            </div>

            
        </div>

    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
      $('.room-select').change(function(){
          window.location.href = '/public/chats/'+$(this).val()
      });



  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {  
    text: deleteButtonTrans,
    url: "{{ route('deal.massDestroy') }}",
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