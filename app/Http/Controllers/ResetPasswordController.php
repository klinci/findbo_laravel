<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    public function index($code) {
    	return view('resetpassword',['code'=>$code]);
    }
    
    public function submitResetPwd(Request $request)
    {
    	$code = $request->input('code');
    	
    	$objUser = DB::table('users')
    		->where('temp_hash','=',$code)
    		->first();
    	if(!empty($objUser) && count($objUser)>0)
    	{
            $password = bcrypt($request->input('password'));
    		//$password = password_hash($request->input('password'), PASSWORD_DEFAULT);
    		dd(DB::table('users')
    			->where('temp_hash', '=', $code)->get());
    			//->update(['password' => $password]);
    		
    		$request->session()->flash('message.level', 'success');
    		$request->session()->flash('message.content', __('messages.msg_password_updated'));
            return redirect(route('passwordreset.get', $code));
    		
    	}
    	else
    	{
    		$request->session()->flash('message.level', 'danger');
    		$request->session()->flash('message.content', __('messages.msg_reset_pwd_link_expired'));
    		return redirect(route('passwordreset.get', $code));
    	}
    		
    }
}
