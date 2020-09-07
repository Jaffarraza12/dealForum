@extends('layouts.admin')
@section('content')
<style>
	.gird{
		background:#fff;
		border:1px solid #0056ad;
		border-radius:10px;
		padding:10px 40px;
		position: relative;
		margin:10px 0;

	}
	.gird h2{
		  text-transform:uppercase;
  		  margin-bottom: 18px;
	}
	.fa{
		font-size: 36px;
		font-size: 51px;
    	color: #d6d6d6;
	}
	.val{
		    font-size: 48px;
    position: absolute;
    right: 45px;
    bottom:0px;
    color:#3f51b5;
	}
</style>
<div class="content" style="min-height:600px;">
    <div class="row" >
        <div class="col-lg-3">
            <div class="gird">
            	<h2>Companies</h2>
            	<i class="fa fa-building"></i>
            	<div class="pull-right"> <span class="val">{{$companiesCount}}</span></div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<h2>Deals</h2>
            	<i class="fa fa-tag"></i> 
            	<div class="pull-right"><span class="val">{{$dealCount}}</span> </div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<h2>Customer</h2>
            	<i class="fa fa-user"></i>
            	<div class="pull-right"> <span class="val">{{$customerCount}}</span></div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<h2>Coupons</h2>
            	<i class="fa fa-percent"></i> 
            	<div class="pull-right"><span class="val">{{$couponCount}}</span></div>
            </div>
        </div>
    </div>
    	<div class="row" style="margin-top:20px">   
           <div class="col-lg-6">
            <div class="gird">
            	<h2 >Messages</h2>
            	<table class="table table-bordered table-striped">
            		<tr>
            			<th>Title</th>	
            			<th>Email</th>	
            			<th>Deal</th>	
            			<th></th>	
            		</tr>
            		@foreach($messages as $message)
            		<tr>
            			<td>{{$message->title}}</td>
            			<td>{{$message->email}}</td>
            			<td>{{$message->name}}</td>
            			<td><a data-id="{{$message->id}}" data-email="{{$message->email}}" 
            				data-title="{{$message->title}}" data-message="{{$message->message}}"
            				class="ViewMessage" style="color:#0056ad;cursor:pointer;">View Message</a></td>
            		</tr>
            		@endforeach
            	</table>
            </div>
        </div>
          <div class="col-lg-6">
            <div class="gird">
            	<h2 >Coupons </h2>
            	<table class="table table-bordered table-striped">
            		<tr>
            			<td>Customer</td>	
            			<td>Deal</td>	
            			<td>Discount</td>
            			<td>Code</td>
            		</tr>
            		@foreach($coupons as $coupon)
            		<tr>
            			<td>{{$coupon->customer ?? 'Not Assigned' }} </td>
            			<td>{{$coupon->name}}</td>
            			<td>{{$coupon->discount}}%</td>
            			<td>{{$coupon->code}}</td>
            		</tr>
            		@endforeach
            	</table>
            </div>
        </div>

    </div>
    <div id="message" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">View Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-lg-6"><h5>Title:</h5></div>
        <div class="col-lg-6"><span id="messageTitle"></span></div>
		<hr>
		<div class="col-lg-6"><h5>Email:</h5></div>
        <div class="col-lg-6"><span id="messageEmail"></span></div>
		<hr>
		<div class="col-lg-12">
			<h5>Message</h5>
			<p id='messageText'> have tooltips on hover.</p>
		</div>
      </div>
      <div class="modal-footer">
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
<script >
	$(document).ready(function(){
		$('.ViewMessage').click(function(){
			id = $(this).data('id')
			title = $(this).data('title')
			message = $(this).data('message')
			email = $(this).data('email')
			$('#messageTitle').html(title)
			$('#messageEmail').html(email)
			$('#messageText').html(message)
			/*$.ajax({
			  url: '/view-message/'+id,
			  success: function(resp){
			  	console.log(resp)

			  }
			});
*/
			$('#message').modal('show')
		});
	});
	
</script>

@endsection