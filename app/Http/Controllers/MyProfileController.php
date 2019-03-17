<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;

class MyProfileController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return  void
    */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
    * Shows the profile page.
    *
    * @return  void
    */
	public function index() {
		return view('myprofile', ['objUser' => Auth::user()]);
	}
	
	/**
	* Updates users profile information.
	*
	* @param  App\Http\Requests\ProfileUpdateRequest  $request
	*/
	public function updateprofile(ProfileUpdateRequest $request) {

		DB::table('users')
			->where('id', Auth::id())
			->update([
				'fname' => $request->input('fname'),
				'lname' => $request->input('lname'),
				'phone' => $request->input('phone')
			]);
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash(
			'message.content',
			// 'Profile updated successfully.'
			\Lang::get('messages.udpate_profile_message')
		);
		return redirect('myprofile');
	}
	
	/**
	* Updates users password.
	*
	* @param  App\Http\Requests\PasswordUpdateRequest  $request
	*/
	public function updatePassword(PasswordUpdateRequest $request) {

		if (password_verify($request->input("old_password"), Auth::user()->password)) {
			DB::table('users')
				->where('id', Auth::id())
				->update(['password' => bcrypt($request->input("password"))]);
			
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Password updated successfully.');
		} else {
			$request->session()->flash('message.level', 'danger');
			$request->session()->flash('message.content', 'Old password does not match with database.');
		}
		return redirect('myprofile');
	}

}
