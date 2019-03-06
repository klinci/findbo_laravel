<?php

namespace App\Http\Controllers\AdminAuth;
use App\User;
use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	/*
	 |--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers, LogsoutGuard {
		LogsoutGuard::logout insteadof AuthenticatesUsers;
	}

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	public $redirectTo = '/admin/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('admin.guest', ['except' => 'logout']);
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm()
	{
		return view('admin.auth.login');
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard() {
		return Auth::guard('admin');
	}
	
	public function login(Request $request) {
	
		$this->validate($request, [
				'email' => 'required|max:255',
				'password' => 'required|max:255'
				]);
	
		$authUser = Admin::where('email', $request->email)->first();
		
		if (isset($authUser))
		{
			if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password/*, 'isAdmin'=>'admin'*/])) {
				return redirect()->route('admin.home');
			}
			else {
				//return 'oops something happend : email - ' . $request->password;
				$request->session()->flash('message.level', 'danger');
				$request->session()->flash('message.content', 'Invalid credentails.');
				return redirect()->route('login');
			}
		}
		else
		{
			$request->session()->flash('message.level', 'danger');
			$request->session()->flash('message.content', 'Invalid credentails.');
			return redirect()->route('login');
		}
	}
	
	/**
	 * Log the user out of the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();
	
		$request->session()->invalidate();
	
		return redirect('/admin/login');
	}

}
