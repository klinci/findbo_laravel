<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request) {
    	if (!Newsletter::isSubscribed($request -> EMAIL)) {
    		Newsletter::subscribe($request -> EMAIL);
    		return redirect()->back()->with([
    			'message.level' => 'success',
    			'message.content' => 'You successfully subscribed to our newsletter!'
    		]);
    	}
    	return redirect()->back()->with([
			'message.level' => 'danger',
			'message.content' => 'You are already subscribed.'
		]);
    }
}
