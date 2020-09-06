@extends('layouts.admin')
@section('content')
<style>
	.gird{
		background:#fff;
		border:1px solid #0056ad;
		border-radius:10%;
		padding:40px;
	}
	.fa{
		font-size: 36px;
	}
</style>
<div class="content">
    <div class="row" style="min-height:600px;">
        <div class="col-lg-3">
            <div class="gird">
            	<div class="pull-left">Companies</div>
            	<div class="pull-right"><i class="fa fa-building"></i> <span class="val">10</span></div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<div class="pull-left">Deals</div>
            	<div class="pull-right"><i class="fa fa-tag"></i> <span class="val">20</span> </div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<div class="pull-left">Customer</div>
            	<div class="pull-right"><i class="fa fa-user"></i> <span class="val">20</span></div>
            </div>
        </div>
         <div class="col-lg-3">
            <div class="gird">
            	<div class="pull-left">Coupons</div>
            	<div class="pull-right"><i class="fa fa-percent"></i> <span class="val">20</span></div>
            </div>
        </div>
    </div>
    	<div class="row">   
           <div class="col-lg-6">
            <div class="gird">
            	<h2 >Messages</h2>
            	
            </div>
        </div>
          <div class="col-lg-6">
            <div class="gird">
            	<h2 >Coupon Consumed</h2>
            
            </div>
        </div>

    </div>

</div>
@endsection
@section('scripts')
@parent

@endsection