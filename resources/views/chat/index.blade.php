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
  .user{margin:5px 0px;color:#0056ad !important;cursor: pointer;}
  .chatBox{
    margin:5px 0px;
  }
  .modal-dialog{max-width: 350px;}
  .bold{font-weight:bold;}
  .chatID{margin: 3px 0; }
</style>
<div class="card">
    <div class="card-header">
        Chat   
        <div class="row h-100">
           <div class="col-sm-12 my-auto">
             <div class="card card-block w-25">
              <select class="room-select" id="inputGroupSelect01">
                
                  @foreach($rooms as $room)
                    <option {{($roomId == $room->id) ? 'selected' : '' }} value="{{$room->id}}">{{$room->name}}</option>
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
                      <div class="chatID"> <span class="bold">{{$message->name}}:</span> {{$message->message}}</div>

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
                    <a class="user" data-status="{{$user->status}}" data-name="{{$user->name}}" data-id="{{$user->id}}">{{$user->name}} ({{($user->status == 1) ? 'active' : 'block'  }})</a><br/>
                  @endforeach
                </div>
              </div>
            </div>

            
        </div>

        <div id="modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Status is <span class="Ustatus"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div><span class="bold">Id:</span><span id="customerId"></span>.</div>
        <div><span class="bold">Name : </span><span id="customerName"></span>.</div>
      </div>
      <div class="modal-footer">
        <button id="room-status-active" data-status="2" type="button" class="btn btn-primary BtnStatus">Active</button>
        <button id="room-status-block" data-status="2" type="button" class="btn btn-danger BtnStatus">Block from This Room</button> 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

      $('.user').click(function(){
          Id = $(this).data('id')   
          name = $(this).data('name')   
          status = $(this).data('status')   
          if(status == 2){
              $('.Ustatus').html('Block')
              $('#room-status-active').show()
              $('#room-status-block').hide()
          } else {
             $('.Ustatus').html('Active')
             $('#room-status-active').hide()
             $('#room-status-block').show()

          }
          $('#customerId').html(Id)
          $('#customerName').html(name)


          $('#modal').modal('show')

      });


      $('.BtnStatus').click(function(){

      })



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