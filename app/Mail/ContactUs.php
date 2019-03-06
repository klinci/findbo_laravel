<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
	use Queueable, SerializesModels;

	public $demo;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($demo)
	{
		$this->demo = $demo;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		 $this->subject = $this->demo->subject;
		
		return $this->view('mails.contactus')
					->with([
						'name'=>$this->demo->name,
						'email'=>$this->demo->email,
						'subject'=>$this->demo->subject,
						'message_body'=>$this->demo->message,
					]);
	}
}
