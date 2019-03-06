<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Register extends Mailable
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
		$this->subject = __('messages.email_msg_reg_3');
		
		return $this->view('mails.demo')
					->with([
						'first_name'=>$this->demo->fname
					]);
	}
}
