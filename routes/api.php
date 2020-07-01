<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});



Route::get('home', 'Admin\CategoryController@api');
Route::get('companies', 'CompanyController@api');
Route::get('deals', 'DealController@api');
Route::get('customer/{id}', 'CustomerController@show');
Route::get('deal-detail', 'DealController@detailapi');


Route::post('customer', 'CustomerController@CustomerApi');
Route::post('customerEdit', 'CustomerController@Edit');
Route::post('rating', 'DealController@DoRating');
Route::post('contactSave', 'ContactController@Api');


 