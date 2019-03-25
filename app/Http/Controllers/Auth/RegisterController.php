<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\Register;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Services\MailService;
use Response;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
    * Mail service instance.
    *
    * @var \App\Services\MailService
    */
    protected $mailService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
        $this->mailService = new MailService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'usertype' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

      if($data['usertype'] == 1) {
        $userType = 1;
        $token = 1;
      } else {
        $userType = 2;
        $token = 0;
      }

      return User::create([
        'fname' => $data['fname'],
        'lname' => $data['lname'],
        'email' => $data['email'],
        'userType' => $userType,
        'password' => bcrypt($data['password']),
        'code' => md5($data['email'] . uniqid()),
        'token' => $token,
        'gender' => '',
        'isBan' => 'false',
        'isAdmin' => 'false',
        'seek_package_id' => 0,
        'hunting_email_unsubscribe' => 0,
        'ip_address' => $_SERVER["REMOTE_ADDR"],
      ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
          return redirect(route('login'))->withErrors($validator);
        }

        event(new Registered($user = $this->create($request->all())));

        $this->mailService->sendActivationMail($user);
        $this->guard()->login($user);

        //return $this->registered($request, $user) ?: redirect($this->redirectPath());
        return redirect(route('login.confirmation'));
    }

    /**
     * Handle a check email registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkEmailRegistered(Request $request)
    {
        $email = $request->email;

        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $user = User::where('email', $email)->first();
          if($user) {
            return response()->json([
              'success' => 0,
              'message' => \Lang::get('messages.email_allready_message')
            ]);
          } else {
            return response()->json([
              'success' => 1,
              'message' => ''
            ]);
          }
        } else {
          return response()->json([
            'success' => -1
          ]);
        }
    }

    /*
    public function register(Request $request)
    {

    	$this->validate($request, [
    			'usertype' => 'required',
    			'fname' => 'required',
    			'lname' => 'required',
    			//'email' => 'required|unique:users',
    			'email' => 'required',
    			'password'=>'required',
    			]);



    	$password = password_hash($request->input('password'), PASSWORD_DEFAULT);
    	$code = md5($request->input('email') . uniqid());
    	$reset_link = url('activate/'.$code);

    	//echo '<br>==>'.$password;


    	User::create([
	    	'userType' => $request->input('usertype'),
	    	'gender' => '',
	    	'fname' => $request->input('fname'),
	    	'lname' => $request->input('lname'),
	    	'email' => $request->input('email'),
	    	'password' => $password,
	    	'newsletter' => 0,
	    	'code' => $code,
	    	'token' => 1,
	    	'timeJoined' => date('Y-m-d H:i:s'),
	    	'isBan' => 'false',
	    	'isAdmin' => 'false',
	    	'seek_package_id' => 0,
	    	'hunting_email_unsubscribe' => 0,
	    	'ip_address' => $_SERVER["REMOTE_ADDR"],
    	]);

    	//$reset_link = "https://findbo.dk/aktivere.php?code=$code&email=".$request->input('email');

    	$objDemo = new \stdClass();
    	$objDemo->reset_link = $reset_link;
    	$objDemo->fname = $request->input('fname');
    	$objDemo->sender = 'SenderUserName';
    	$objDemo->receiver = 'ReceiverUserName';

    	Mail::to($request->input('email'))->send(new Register($objDemo));

    	return redirect('login/confirm');
    }
    */

}
