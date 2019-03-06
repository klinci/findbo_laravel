<?php

/* Route::get('/home', function () {
	
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home'); */


$users[] = Auth::user();
$users[] = Auth::guard()->user();
$users[] = Auth::guard('admin')->user();

Route::get('/home', 'AdminAuth\HomeController@index')->name('home');
Route::get('/properties/allproperties', 'AdminAuth\PropertyController@allProperties');
Route::post('/properties/ajaxallproperties', 'AdminAuth\PropertyController@ajaxAllProperties');
Route::post('/properties/deleteproperties', 'AdminAuth\PropertyController@deleteProperties');
Route::get('/properties/updatestatus', 'AdminAuth\PropertyController@updateStatus');
Route::get('/properties/updatefeaturedstatus', 'AdminAuth\PropertyController@updateFeaturedStatus');

Route::get('/properties/pendingproperties', 'AdminAuth\PropertyController@pendingProperties');
Route::post('/properties/ajaxpendingproperties', 'AdminAuth\PropertyController@ajaxPendingProperties');
Route::post('/properties/updatependingproperties', 'AdminAuth\PropertyController@updatePendingProperties');

Route::get('/properties/makeitapprove', 'AdminAuth\PropertyController@makeItApprove');
Route::get('/properties/makeitreject', 'AdminAuth\PropertyController@makeItReject');


Route::get('/properties/rejectedproperties', 'AdminAuth\PropertyController@rejectedProperties');
Route::post('/properties/ajaxrejectedproperties', 'AdminAuth\PropertyController@ajaxRejectedProperties');


Route::get('/seekads/index', 'AdminAuth\SeekadsController@index');
Route::post('/seekads/ajaxseekads', 'AdminAuth\SeekadsController@ajaxSeekads');
Route::post('/seekads/deleteproperties', 'AdminAuth\SeekadsController@deleteProperties');

Route::get('/users/index', 'AdminAuth\UsersController@index');
Route::post('/users/ajaxusers', 'AdminAuth\UsersController@ajaxUsers');
Route::get('/users/view_profile', 'AdminAuth\UsersController@viewProfile');
Route::post('/users/checkmail', 'AdminAuth\UsersController@checkMail');
Route::post('/users/updateprofile', 'AdminAuth\UsersController@updateProfile');
Route::post('/users/change_password', 'AdminAuth\UsersController@changePassword');
Route::post('/users/updatePackageStatus', 'AdminAuth\UsersController@updatePackageStatus');
Route::post('/users/updatePropertyHunting', 'AdminAuth\UsersController@updatePropertyHunting');
Route::post('/users/updateBanUser', 'AdminAuth\UsersController@updateBanUser');
Route::get('/users/convertuser/{id}', 'AdminAuth\UsersController@convertUser');
Route::get('/users/updatebanstatus/{id}', 'AdminAuth\UsersController@updateBanStatus');


Route::get('/area/index', 'AdminAuth\AreaController@index');
Route::post('/area/ajaxarea', 'AdminAuth\AreaController@ajaxArea');
Route::get('/area/create', 'AdminAuth\AreaController@create');
Route::post('/area/store', 'AdminAuth\AreaController@store');

Route::get('/zipcode/index', 'AdminAuth\ZipcodeController@index');
Route::post('/zipcode/ajaxzipcode', 'AdminAuth\ZipcodeController@ajaxZipcode');
Route::get('/zipcode/create', 'AdminAuth\ZipcodeController@create');
Route::post('/zipcode/store', 'AdminAuth\ZipcodeController@store');

Route::get('/rental_period/index', 'AdminAuth\RentalPeriodController@index');
Route::post('/rental_period/ajaxrentalperiod', 'AdminAuth\RentalPeriodController@ajaxRentalPeriod');
Route::get('/rental_period/create', 'AdminAuth\RentalPeriodController@create');
Route::post('/rental_period/store', 'AdminAuth\RentalPeriodController@store');


Route::get('/blogcategories/index', 'AdminAuth\BlogCategoriesController@index');
Route::post('/blogcategories/ajaxblogcategories', 'AdminAuth\BlogCategoriesController@ajaxBlogCategories');
Route::get('/blogcategories/create', 'AdminAuth\BlogCategoriesController@create');
Route::get('/blogcategories/{id}/edit', 'AdminAuth\BlogCategoriesController@edit');
Route::post('/blogcategories/store', 'AdminAuth\BlogCategoriesController@store');
Route::post('/blogcategories/{id}', 'AdminAuth\BlogCategoriesController@update');
Route::get('/blogcategories/{id}/destroy', 'AdminAuth\BlogCategoriesController@destroy');


Route::get('/blogpost/index', 'AdminAuth\BlogPostController@index');
Route::post('/blogpost/ajaxblogpost', 'AdminAuth\BlogPostController@ajaxBlogPosts');
Route::get('/blogpost/create', 'AdminAuth\BlogPostController@create');
Route::post('/blogpost/store', 'AdminAuth\BlogPostController@store');
Route::get('/blogpost/{id}/edit', 'AdminAuth\BlogPostController@edit');
Route::post('/blogpost/{id}', 'AdminAuth\BlogPostController@update');
Route::get('/blogpost/{id}/destroy', 'AdminAuth\BlogPostController@destroy');
