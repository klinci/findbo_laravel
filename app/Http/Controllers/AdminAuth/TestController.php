<?php

namespace App\Http\Controllers\AdminAuth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;

use Illuminate\Http\Request;

class TestController extends Controller
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
	//public $redirectTo = '/admin/home';
	public $redirectTo = '/admin/dashboard';

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
	protected function guard()
	{
		return Auth::guard('admin');
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


	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		//info@findbo.dk
		//zg%!';|~w`+jq
		
		$this->validate($request, [
				'email' => 'required|max:255',
				'password' => 'required|max:255'
				]);
		
		$authUser = User::where('email', $request->email)->first();
		
		if (isset($authUser))
		{
			if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'isAdmin'=>'admin'])) {
				//return 'logged in successfully : email - ' . $request->password;
				//return $this->sendLoginResponse($request);
				
				//$request->session()->regenerate();
				
				$this->clearLoginAttempts($request);
				
				
				return $this->authenticated($request, $this->guard()->user())?: redirect()->intended('admin/dashboard');
				
				
				return redirect('admin/dashboard');
				//return redirect('admin/home');
			}
			else {
				//return 'oops something happend : email - ' . $request->password;
			}
		}
		else
		{
			
		}
		
		exit;
		
		
		$email = $request->input('email');
		$password = $request->input('password');
		
		$objUser = new User();
		$objCheckEmail = $objUser->checkEmail($email);
		if(!empty($objCheckEmail) && count($objCheckEmail)>0)
		{
			if((password_verify($password, $objCheckEmail->password) == 1) && ($objCheckEmail->isAdmin=='admin'))
			{
				//echo '<br>==>'.$objCheckEmail->email.'===='.$objCheckEmail->password;
				//if(Auth::validate(['email'=>$objCheckEmail->email,'password'=>$objCheckEmail->password]))
				if (Auth::attempt(['email'=>$objCheckEmail->email,'password'=>$objCheckEmail->password]))
				{
					//Auth::login($user,$request->has('remember'));
					return redirect('admin/home');
				}
				else
				{
					echo "No logged in";
				}
			}
			else
			{
				//echo "Normal login";
				echo 'Else ==>Invalid Credentials';
			}
		}
		else
		{
			echo 'main Else===>Invalid Credentials';
		}
		exit;
		
		echo '<pre>';
		print_r($objCheckEmail);
		exit;
		
		// for check password
		//password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		// for login
		//password_verify($password, $row['password'])
		
		exit;
			
		//if(Auth::validate(['email'=>$email, 'password'=>$password]))
		
	
	}
	
	
}
