<?php 
Route::get('/', function () { return redirect('/admin/home'); });

Auth::routes(['register' => false]);

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('abilities/destroy', 'AbilitiesController@massDestroy')->name('abilities.massDestroy');
    Route::resource('abilities', 'AbilitiesController');
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');


    Route::get('/setting','SettingController@index')->name('setting');
    Route::patch('/setting','SettingController@save')->name('setting');
    Route::resource('category', 'CategoryController');
     Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('category.massDestroy');
   
   
});

Route::get('file-manager','Admin\FileManager@index')->middleware('auth');
Route::post('file-manager','Admin\FileManager@upload')->middleware('auth');
Route::delete('file-manager-remove','Admin\FileManager@delete')->middleware('auth');
Route::post('file-manager-folder','Admin\FileManager@folder')->middleware('auth');

Route::resource('companies', 'CompanyController')->middleware('auth');
Route::delete('company/massdestroy', 'CompanyController@massDestroy')->name('company.massDestroy')->middleware('auth');

Route::resource('deals', 'DealController')->middleware('auth');
Route::delete('deal/massdestroy', 'DealController@massDestroy')->name('deal.massDestroy')->middleware('auth');
Route::resource('coupons', 'CouponController')->middleware('auth');
Route::delete('coupon/massdestroy', 'CouponController@massDestroy')->name('coupon.massDestroy')->middleware('auth');


 Route::get('coupon-deal', 'CouponController@deal')->name('coupon.deal')->middleware('auth');
   

