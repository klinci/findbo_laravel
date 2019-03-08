<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\MailService;
use Auth;

class ApproveController extends Controller
{

	public function __construct() {
		$this->middleware('auth')->except('index');
	}

	public function notApproved() {
		return view('auth.notapproved');
	}

}
