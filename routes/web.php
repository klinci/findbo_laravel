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

// Auth::routes();

Route::get('/beskrive', 'HomeController@describe')->name('describe');
Route::get('/dashboard', function () {
    return redirect('http://findbo.dk/dashboard');
});

Route::get('/', 'HomeController@index')
  ->name('home');
Route::match(['get', 'post'], 'bolig', 'PropertyController@index')
  ->name('home.properties');
Route::match(['get', 'post'], '/map', 'PropertyController@map')
  ->name('home.map');
Route::get('auto_soege', 'HomeController@autoSearch')
  ->name('home.auto_search');
Route::get('hvordan_virker_det','HowItWorksController@index')
  ->name('home.how_it_works');
Route::get('pris','PriceController@index')
  ->name('prices');
Route::get('om', 'AboutusController@index')
  ->name('about');
Route::get('retningslinier', 'TermsConditionController@index')
  ->name('terms_condition');
Route::get('faq', 'FaqController@index')
  ->name('faq');
Route::get('kontakt', 'ContactController@index')
  ->name('home.contact');
Route::post('send_kontakt', 'ContactController@submitContact')
  ->name('submit_contact');
Route::get('/log_ind', 'Auth\LoginController@showLoginForm')
  ->name('login');
Route::post('registrer', 'Auth\RegisterController@register')
  ->name('register.post');

Route::post('tjek_email_registrered', 'Auth\RegisterController@checkEmailRegistered')
  ->name('check_email_registered');
Route::post('log_ind_sendt', 'Auth\LoginController@loginSubmit')
  ->name('loginsubmit');
Route::get('/log_ind/bekraeftelse', 'Auth\LoginController@confirm')
  ->name('login.confirmation');
Route::get('/aktivere/{code}', 'Auth\ActivateController@index')
  ->name('activate');
Route::get('ikke_aktiveret', 'Auth\ActivateController@notActivated')
  ->name('notactivated');
Route::get('ikke_godkendt', 'Auth\ApproveController@notApproved')
  ->name('notapproved');
Route::get('gensend_kode', 'Auth\ActivateController@resendCode')
  ->name('resend_code');
Route::post('log_ud', 'Auth\LoginController@logoutfront')
  ->name('logoutfront');

Route::get('min_profil', 'MyProfileController@index')
  ->name('myprofile');
Route::post('update_profil', 'MyProfileController@updateProfile')
  ->name('updateprofile');
Route::post('update_adgangskode', 'MyProfileController@updatePassword')
  ->name('updatepassword');

Route::match(['get', 'post'], 'mine_annoncer', 'MyAdsController@index')
  ->name('myads');

Route::get('favorit', 'FavoriteController@index')
  ->name('favorites');
Route::post('fjern_fra_favorit_liste','FavoriteController@removeToWishlist')
  ->name('removetowishlist');

Route::get('pakke/{id}', 'PackageController@index')
  ->name('package.show');
Route::get('pakke', 'PackageController@index')
  ->name('packages');
Route::post('koeb_pakke', 'PackageController@purchasePackage')
  ->name('purchase_package');
Route::post('pakke_succes', 'PackageController@packageSuccess')
  ->name('package_success');
Route::post('pakke_auto_fornyelse', 'PackageController@packageAutoRenew')
  ->name('package_auto_renew');

Route::get('upload_bolig', 'PropertyController@addProperty')
  ->name('property.create');
Route::post('indsat_bolig', 'PropertyController@insertProperty')
  ->name('property.insert');
Route::post('update_bolig','PropertyController@updateProperty')
  ->name('property.update');
Route::get('bolig_betaling/{id}/{pid}', 'PropertyController@propertyPayment')
  ->name('property_payment');
Route::post('koeb_bolig','PropertyController@purchaseProperty')
  ->name('purchase_property');
Route::get('bolig_redigering/{id}', 'PropertyController@editProperty')
  ->name('property_edit');
Route::post('fjern_bolig_billede', 'PropertyController@deletePropertyImage')
  ->name('property.delete_image');
Route::post('send_rapport_email', 'PropertyController@sendReportEmail')
  ->name('send_report_email');
Route::post('tilfoeg_fjern_favorit_liste','PropertyController@addRemoveWishlist')
  ->name('add_remove_wishlist');
Route::post('fjern_bolig', 'PropertyController@deleteProperty')
  ->name('property.delete');
Route::get('bolig_detaljer/{id}', 'PropertyController@propertyDetail')
  ->name('property_detail.show.withId');
Route::get('bolig_detaljer', 'PropertyController@noProperty')
  ->name('property_detail.show.withoutId');

//Route::get('/redirect', 'RedirectController@index');

Route::get('lejer/opret', 'HomeSeekerController@create')
  ->name('home_seeker.create');
Route::post('lejer_kontakt', 'HomeSeekerController@contact')
  ->name('home_seeker_contact');
Route::get('lejer/{homeseeker}/activate/{act}', 'HomeSeekerController@activate')
  ->middleware('can:update,homeseeker')
  ->name('home_seeker_activate');
Route::get('lejer/{id}/redigere', 'HomeSeekerController@edit')
  ->name('home_seeker.edit');
Route::put('lejer/{homeseeker}', 'HomeSeekerController@update')
  ->middleware('can:update,homeseeker')
  ->name('home_seeker.put');
Route::get('lejer/{id}', 'HomeSeekerController@index')
  ->name('home_seeker.show');
Route::post('lejer', 'HomeSeekerController@store')
  ->name('home_seeker.post')
  ->middleware('can:create,App\Seekads');

Route::get('glemt_adgangskode', 'Auth\ForgotPasswordController@showLinkRequestForm')
  ->name('forgot_password');
Route::post('send_glemt_adgangskode', 'Auth\ForgotPasswordController@sendResetLinkEmail')
  ->name('submit_forgotpwd');

Route::get('adgangskode/nustil/{token?}', 'Auth\PasswordController@showResetForm')
  ->name('passwordreset.get');
Route::post('adgangskode/nustil', 'Auth\ResetPasswordController@reset')
  ->name('passwordreset.post');

Route::match(['get', 'post'], 'besked_indbakke', 'MessageController@inbox')
  ->name('message_inbox');
Route::match(['get', 'post'], 'besked_sendt', 'MessageController@sent')
  ->name('message_sent');
Route::post('slet_beskeder', 'MessageController@deleteMsg')
  ->name('delete_msg');

Route::get('kommunikation/{id}', 'ConversationController@index')
  ->name('conversation');
Route::post('kommunikation_sendt', 'ConversationController@submitMsg')
  ->name('conversation_submit');


Route::get('omdirigere','SocialAuthFacebookController@redirect')
 ->name('redirect');
Route::get('kald_tilbage','SocialAuthFacebookController@callback')
 ->name('callback');

// Route::get('omdirigere','Auth\LoginController@redirectToProvider')
//   ->name('redirect');
// Route::get('kald_tilbage','Auth\LoginController@handleProviderCallback')
//   ->name('callback');

Route::post('nyhedsbrev', 'NewsletterController@store')
  ->name('newsletter.post');

Route::get('blog', 'BlogController@index')
  ->name('blog');
Route::get('blog/{id}', 'BlogController@show')
  ->name('blog.show');

Route::group(['prefix' => 'admin'], function () {
  Route::get('login', 'AdminAuth\LoginController@showLoginForm')
    ->name('admin.login');
  Route::post('login', 'AdminAuth\LoginController@login');
  Route::post('logout', 'AdminAuth\LoginController@logout')
    ->name('admin.logout');
  Route::get('register', 'AdminAuth\RegisterController@showRegistrationForm');
  Route::post('register', 'AdminAuth\RegisterController@register');
  Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.request');
  Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset')
    ->name('password.email');
  Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.reset');
  Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});
