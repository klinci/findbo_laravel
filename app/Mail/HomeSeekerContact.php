<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HomeSeekerContact extends Mailable
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
        $this->subject = __('messages.email_msg_seek_info_1');
		
		return $this->view('mails.homeseekercontact')
					->with([
						'receiver_fname'=>$this->demo->receiver_fname,
						'sender_fname'=>$this->demo->sender_fname,
					]);
    }
}
