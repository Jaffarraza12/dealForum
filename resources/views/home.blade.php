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
            		</tr>
            		@forach($message as $messages)
            		<tr>
            			<td>{{$message->title}}</td>
            			<td>{{$message->email}}</td>
            			<td>{{$message->name}}</td>
            			
            		</tr>

            		@enforeach
            	</table>
            </div>
        </div>
          <div class="col-lg-6">
            <div class="gird">
            	<h2 >Coupon </h2>
            	<table class="table table-bordered table-striped">
            		<tr>
            			<td>Customer</td>	
            			<td>Deal</td>	
            			<td>Discount</td>	
            		</tr>
            	</table>
            </div>
        </div>

    </div>

</div>
@endsection
@section('scripts')
@parent

@endsection