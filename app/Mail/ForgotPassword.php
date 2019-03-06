<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
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
       $this->subject = __('messages.resettitle');
		
		return $this->view('mails.forgotpassword')
					->with([
						'fname'=>$this->demo->fname,
						'reset_link'=>$this->demo->reset_link,
					]);
    }
}
