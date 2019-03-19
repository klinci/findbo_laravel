<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Package extends Mailable
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

		return $this->view('mails.package')
					->with([
						'description'=>$this->demo->description,
						'amount'=>$this->demo->amount,
						'days'=>$this->demo->days,
						'balance_transaction'=>$this->demo->balance_transaction,
					]);

	}
}
