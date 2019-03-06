<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\MailService;
use Auth;

class ActivateController extends Controller
{

	public function __construct() {
		$this->middleware('auth')->except('index');
	}

	public function index($code)
	{
		$objUSer = DB::table('users')
						->where('code','=',$code)
						->first();
		
		if(!empty($objUSer) && count($objUSer)>0)
		{
			DB::table('users')
					->where('id','=',$objUSer->id)
					->update([
						'token'=>1
					]);
		}
		return view('auth.activate');
	}

	public function notActivated() {
		return view('auth.notactivated');
	}

	public function resendCode() {
		$mailService = new MailService;
		$mailService -> sendActivationMail(Auth::user());
		return view('auth.confirm');
	}

}
