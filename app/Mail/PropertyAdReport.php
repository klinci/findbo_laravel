<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PropertyAdReport extends Mailable
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
		$this->subject = 'Findbo - Property Status';
		
		return $this->view('mails.propertyadreport')
					->with([
						'property_link'=>$this->demo->property_link,
						'reporter_email'=>$this->demo->reporter_email,
						'reporter_name'=>$this->demo->reporter_name,
						'reporter_reason'=>$this->demo->reporter_reason,
						'reporter_reason_desc'=>$this->demo->reporter_reason_desc,
					]);
	}
}
