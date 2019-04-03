<?php

namespace App\Services;

class MailboxDisposable {

	function __construct()
	{
		$this->ch 		= curl_init();
		$this->url 		= 'http://apilayer.net';
	}

	public function check($email)
	{
		curl_setopt_array($this->ch, [
			CURLOPT_URL => $this->url.'/api/check?access_key='.env('MAILBOX_DISPOSABLE_APIKEY').'&email='.$email.'&smtp=1&format=1',
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_COOKIEFILE => '/cookiefile.txt',
			CURLOPT_COOKIEJAR => '/cookiefile.jar',
			CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:66.0) Gecko/20100101 Firefox/66.0',
			CURLOPT_VERBOSE => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_NOBODY => 0,
			CURLOPT_TIMEOUT => 10
		]);

		$response = curl_exec($this->ch);
		$error 		= curl_error($this->ch);
		$info 		= curl_getinfo($this->ch);
		// curl_close($this->ch);

		return [
			'code' 		=> $info['http_code'],
			'info'		=> $info,
			'response' 	=> $response
		];
	}

}