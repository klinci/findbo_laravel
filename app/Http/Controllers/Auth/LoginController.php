<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\AdminAuth\UsersController;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Mail\Register;
use Illuminate\Support\Facades\URL;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
       $this->middleware('guest')->except(['logoutfront', 'confirm']);
    }
    
    public function showLoginForm()
    {
    	return view('auth.login');
    }
    
	public function loginSubmit(Request $request)
	{
		$this->validate($request, [
				'email' => 'required|max:255',
				'password' => 'required|max:255'
				]);
		
		$authUser = User::where('email', $request->email)->first();
		
		$getPreviousPage = $request->input('previous_page');

		if (isset($authUser))
		{
			if(password_verify($request->password, $authUser->password)==1)
			{
				if(auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password]))
				{
					if(strstr($getPreviousPage, 'property_detail'))
					{
						return redirect($getPreviousPage);
					}
					else
					{
						return redirect("/");
					}
				}
				else 
				{
					//return 'oops something happend : email - ' . $request->password;
					$request->session()->flash('message.level', 'danger');
					$request->session()->flash('message.content', 'Invalid credentails.');
					return redirect('login');
				}
			}
			else
			{
				//return 'oops something happend : email - ' . $request->password;
				$request->session()->flash('message.level', 'danger');
				$request->session()->flash('message.content', 'Invalid credentails.');
				return redirect('login');
			}
		}
		else
		{
			$request->session()->flash('message.level', 'danger');
			$request->session()->flash('message.content', 'Invalid credentails.');
			//return redirect()->route('login');
			return redirect('login');
		}
	}
	
	public function confirm()
	{
		return view('auth.confirm');
	}

	public function logoutfront(Request $request)
	{
		$this->guard()->logout();
	
		$request->session()->invalidate();
	
		return redirect('/');
	}
}
