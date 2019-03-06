<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;
use App\Services\MailService;
use App\User;
use App\Http\Requests\PasswordResetRequest;


class ForgotPasswordController extends Controller
{

	/**
	* Displays a form for submitting an email for forgotten passwords.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index() {
		return view('forgotpassword');
	}

	/**
	* Creates a code for resetting a password and sends an email to user.
	*
	* @return \Illuminate\Http\Response
	*/
	public function submitForgotPwd(PasswordResetRequest $request) {
		$user = User::where('email', $request -> resetEmail)->first();
		$temp_hash = md5(rand() . microtime());
		$user -> update(['temp_hash' => $temp_hash]);

		$mailer = new MailService;
		$mailer -> sendPasswordResetMail($user);

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', __('messages.reset_email_sent'));
		return redirect('forgot_password');
	}
	
	/*
	public function submitForgotPwd(Request $request)
	{
		$objUsers = DB::table('users')
			->where('email','=',$request->input('resetEmail'))
			->first();
		
		if(!empty($objUsers) && count($objUsers)>0)
		{
			$temp_hash = md5(rand() . microtime());
			
			DB::table('users')
					->where('id','=',$objUsers->id)
					->update([
						'temp_hash'=>$temp_hash
					]);
			
			$reset_link = url('reset_password/'.$temp_hash);
			
			$objDemo = new \stdClass();
			$objDemo->fname = $objUsers->fname;
			$objDemo->reset_link = $reset_link;
			
			$to = $objUsers->email;
				
			Mail::to($to)->send(new ForgotPassword($objDemo));
			
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', __('messages.reset_email_sent'));
			return redirect('forgot_password');
			
		}
		else
		{
			$request->session()->flash('message.level', 'danger');
			$request->session()->flash('message.content', 'Email does not exist. Please enter different email addresss.');
			return redirect('forgot_password');
		}
	}
	*/
}
