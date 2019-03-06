<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/describe', 'HomeController@describe');

Route::get('/', 'HomeController@index');
Route::get('/auto_search', 'HomeController@autoSearch');

Route::match(['get', 'post'], '/map', 'PropertyController@map');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/register', 'Auth\RegisterController@register');
Route::post('/check_email_registered', 'Auth\RegisterController@checkEmailRegistered');
Route::post('/loginsubmit', 'Auth\LoginController@loginSubmit');
Route::get('/login/confirm', 'Auth\LoginController@confirm');
Route::get('/activate/{code}', 'Auth\ActivateController@index');
Route::get('/notactivated', 'Auth\ActivateController@notActivated');
Route::get('/resend_code', 'Auth\ActivateController@resendCode');
Route::post('/logoutfront', 'Auth\LoginController@logoutfront');

Route::get('/myprofile', 'MyProfileController@index');
Route::post('/updateprofile', 'MyProfileController@updateProfile');
Route::post('/updatepassword', 'MyProfileController@updatePassword');

Route::match(['get', 'post'], '/myads', 'MyAdsController@index');

Route::get('/favorite', 'FavoriteController@index');
Route::post('/removetowishlist', 'FavoriteController@removeToWishlist');

Route::get('/package/{id}', 'PackageController@index');
Route::get('/package', 'PackageController@index');
Route::post('/purchase_package', 'PackageController@purchasePackage');
Route::post('/package_success', 'PackageController@packageSuccess');
Route::post('/package_auto_renew', 'PackageController@packageAutoRenew');

Route::match(['get', 'post'], '/property', 'PropertyController@index');
Route::get('/add_property', 'PropertyController@addProperty');
Route::post('/insert_property', 'PropertyController@insertProperty');
Route::post('/update_property', 'PropertyController@updateProperty');
Route::get('/property_payment/{id}/{pid}', 'PropertyController@propertyPayment');
Route::post('/purchase_property', 'PropertyController@purchaseProperty');
Route::get('/property_edit/{id}', 'PropertyController@editProperty');
Route::post('/delete_property_image', 'PropertyController@deletePropertyImage');
Route::post('/send_report_email', 'PropertyController@sendReportEmail');
Route::post('/add_remove_wishlist', 'PropertyController@addRemoveWishlist');
Route::post('/delete_property', 'PropertyController@deleteProperty');
Route::get('/property_detail/{id}', 'PropertyController@propertyDetail');
Route::get('/property_detail', 'PropertyController@noProperty');

//Route::get('/redirect', 'RedirectController@index');
Route::get('/how_it_works', 'HowItWorksController@index');
Route::get('/price', 'PriceController@index');
Route::get('/about', 'AboutusController@index');
Route::get('/terms_condition', 'TermsConditionController@index');
Route::get('/faq', 'FaqController@index');

Route::get('/contact', 'ContactController@index');
Route::post('/submit_contact', 'ContactController@submitContact');

Route::get('/home_seeker/create', 'HomeSeekerController@create');
Route::get('/home_seeker/{id}', 'HomeSeekerController@index');
Route::post('/home_seeker_contact', 'HomeSeekerController@contact');
Route::get('/home_seeker/{homeseeker}/activate/{act}', 'HomeSeekerController@activate')->middleware('can:update,homeseeker');
Route::get('/home_seeker/{id}/edit', 'HomeSeekerController@edit');
Route::put('/home_seeker/{homeseeker}', 'HomeSeekerController@update')->middleware('can:update,homeseeker');
Route::post('/home_seeker', 'HomeSeekerController@store')->middleware('can:create,App\Seekads');

Route::get('/forgot_password', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('/submit_forgotpwd', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');


Route::match(['get', 'post'], '/message_inbox', 'MessageController@inbox');
Route::match(['get', 'post'], '/message_sent', 'MessageController@sent');
Route::post('/delete_msg', 'MessageController@deleteMsg');

Route::get('/conversation/{id}', 'ConversationController@index');
Route::post('/conversation_submit', 'ConversationController@submitMsg');


Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::post('/newsletter', 'NewsletterController@store');

Route::get('/blog', 'BlogController@index');
Route::get('/blog/{id}', 'BlogController@show');

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm');
  Route::post('/register', 'AdminAuth\RegisterController@register');
  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});
