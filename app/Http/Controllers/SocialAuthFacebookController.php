<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialFacebookAccountService;

class SocialAuthFacebookController extends Controller
{

    /**
    * Create a redirect method to facebook api.
    *
    * @return void
    */
	public function redirect()
	{
		return Socialite::driver('facebook')->stateless()->redirect();
	}

	/**
	* Return a callback method from facebook api.
	*
	* @return callback URL from facebook
	*/
	public function callback(SocialFacebookAccountService $service)
	{

		$response = Socialite::driver('facebook')->stateless()->user();
		$user = $service->createOrGetUser($response);
		$redirected = route('home');

		auth()->login($user->first());

		if(\Session::has('redirected')) {
			$redirected = \Session::get('redirected');
		}
		return redirect($redirected);
	}

}
