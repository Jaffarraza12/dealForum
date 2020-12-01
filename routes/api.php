<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
});



Route::get('home', 'Admin\CategoryController@api');
Route::get('companies', 'CompanyController@api');
Route::get('deals', 'DealController@api');
Route::get('customer/{id}', 'CustomerController@show');
Route::get('deal-detail', 'DealController@detailapi');
Route::get('mailer', 'ContactController@mailer');
Route::get('allCoupons/{customer}', 'CouponController@getCoupon');
Route::get('chatting/{room}', 'ChatController@get');
Route::get('chatrooms', 'ChatController@rooms');
Route::get('sliders', 'Admin\CategoryController@getSliders');
Route::get('help', 'Admin\CategoryController@getHelp');
Route::get('validate-coupon', 'Admin\CategoryController@getHelp');


Route::post('customer', 'CustomerController@CustomerApi');
Route::post('customerEdit', 'CustomerController@Edit');
Route::post('customerLogin', 'CustomerController@CustomerLoginApi');
Route::post('customerRegister', 'CustomerController@CustomerRegisterApi');
Route::post('rating', 'DealController@DoRating');
Route::post('message', 'DealController@message');
Route::post('contactSave', 'ContactController@Api');
Route::post('coupon-create', 'CouponController@api');
Route::post('chatmessage/{room}', 'ChatController@apiPost');
Route::post('chatuser', 'ChatController@chatuser');
Route::post('customer-status', 'ChatController@changeStatus');
Route::post('customer-apple-id', 'CustomerController@getCustomerByAppleId');
