<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class ContactController extends Controller
{
    public function index() {
    	return view('contact');
    }

    public function submitContact(ContactUsRequest $request) {
        $mailer = new MailService;
        $mailer -> sendContactUsMail($request->all());
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', __('messages.msgSent').'<br>'.__('messages.supportMsg'));
        return redirect()->back();
    }
    
    /*
    public function submitContact(ContactUsRequest $request) {
        $objDemo = new \stdClass();
    	$objDemo->name = $request->input('contactName');
    	$objDemo->email = $request->input('contactEmail');
    	$objDemo->subject = $request->input('contactSubject');
    	$objDemo->message = $request->input('contactMessage');
    	
    	$to = 'hardik@desireinfoway.com';
		Mail::to($to)->send(new ContactUs($objDemo));
		
		if( count(Mail::failures()) > 0 ) {

		   echo "There was one or more failures. They were: <br />";

		   foreach(Mail::failures() as $email_address) {
			   echo " - $email_address <br />";
			}

		} else {
			echo "No errors, all sent successfully!";
		}
		exit;		
    	
    	$request->session()->flash('message.level', 'success');
    	$request->session()->flash('message.content', __('messages.msgSent').'<br>'.__('messages.supportMsg'));
    	return redirect('contact');
    }
    */
}
