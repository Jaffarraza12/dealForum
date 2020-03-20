<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});



Route::get('home', 'Admin\CategoryController@api');
Route::get('companies', 'CompanyController@api');
Route::get('deals', 'dealsController@api');
Route::get('deal-detail', 'dealsController@detailapi');

 