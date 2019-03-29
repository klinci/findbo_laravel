<?php

	namespace App\Services;

	use App\User;
	use PHPMailer\PHPMailer\PHPMailer;

	class MailService {

		/**
		* Creates a PHPMailer instance.
		*
		* @return  PHPMailer\PHPMailer\PHPMailer
		*/
		public function getMailer() {
			$mailer = new PHPMailer(true);
			$mailer->CharSet = 'UTF-8';
			$mailer-> SMTPAuth = true;
			$mailer->SMTPSecure = 'tls';
			$mailer->Host = env('MAIL_HOST');
			$mailer->Port = env('MAIL_PORT');
			$mailer->Username = env('MAIL_USERNAME');
			$mailer->Password = env('MAIL_PASSWORD');
			$mailer->SetFrom('info@findbo.dk','Findbo');
			return $mailer;
		}

		/**
		* Sends an e-mail to the user with the activation code.
		*
		* @param \App\User  $user
		* @return boolean  Indicates whether the message has been sent
		*/
		public function sendActivationMail(User $user) {
			$mailer = $this -> getMailer();
			$mailer -> Subject = 'Activation';
			$mailer -> addAddress($user -> email);
			$mailer -> MsgHTML('To activate your account, please click on the link below:
								<br/><a href="'. url('/activate/'.$user -> code ) .'">Activate</a>');
			return $mailer -> send();
		}

		/**
		* Sends an e-mail to Findbo with a message from a user.
		*
		* @param array  $data
		* @return boolean  Indicates whether the message has been sent
		*/
		public function sendContactUsMail(array $data) {
			$mailer = $this -> getMailer();
			$mailer -> Subject = $data['contactSubject'];
			$mailer -> SetFrom($data['contactEmail']);
			$mailer -> addAddress('info@findbo.dk');
			$mailer -> MsgHTML(view('mails.contactus')
									->with([
										'name' => $data['contactName'],
										'email' => $data['contactEmail'],
										'subject' => $data['contactSubject'],
										'message_body' => $data['contactMessage'],
									]));
			return $mailer -> send();
		}

		/**
		* Sends an e-mail to notify the user that he received a new private message.
		*
		* @param App\User  $sender
		* @param App\User  $receiver
		* @param string  $message
		* @return boolean  Indicates whether the message has been sent
		*/
		public function sendHomeSeekerContactMail($sender, $recipient, $message)
		{

			if(is_array($sender)) {
				$senderEmail = $sender['email'];
				$recipientEmail = $recipient['email'];
				$recipientFirstName = $recipient['fname'];
				$senderFirstName = $sender['fname'];
			} else {
				$senderEmail = $sender->email;
				$recipientEmail = $recipient->email;
				$recipientFirstName = $recipient->fname;
				$senderFirstName = $sender->fname;
			}

			$mailer = $this->getMailer();
			$mailer->Subject = __('messages.email_msg_seek_info_1');
			$mailer->AddAddress($recipientEmail);
			$mailer->SetFrom($senderEmail);
			$mailer->SetFrom('info@findbo.dk','Findbo');
			$mailer->addReplyTo($senderEmail,$senderFirstName);
			$mailer->MsgHTML(view('mails.homeseekercontact')->with([
					'receiver_fname' => $recipientFirstName,
					'sender_fname' => $senderFirstName,
				])
			);
			return $mailer->send();
		}

		/**
		* Sends an e-mail to notify the user about a purchased package.
		*
		* @param Stripe\Charge  $charge
		* @param App\Package  $package
		*/
		public function sendPackagePurchaseMail($charge, $package) {
			$mailer = $this -> getMailer();

			$name = $package->id == 1 ?
						__('messages.seeker_green_package_name_subject') . ' ' . __('messages.lbl_activated') :
						__('messages.seeker_blue_package_name') . ' ' . __('messages.lbl_activated');

			$mailer -> Subject = 'FindBo - ' . $name;
			$mailer -> addAddress($charge -> source->name);
			$mailer -> SetFrom('noreply@findbo.dk');
			$mailer -> MsgHTML(view('mails.propertypackage')
									->with([
										'description' => $charge -> description,
										'amount' => $charge -> amount,
										'days' => $package -> duration,
										'balance_transaction' => $charge -> balance_transaction,
									])
								);
			return $mailer -> send();
		}

		/**
		* Sends an e-mail for resetting a forgotten password.
		*
		* @param \App\User  $user
		* @return boolean  Indicates whether the message has been sent
		*/
		public function sendPasswordResetMail(User $user, $token) {
			$mailer = $this -> getMailer();
			$mailer -> Subject = __('messages.resettitle');
			$mailer -> addAddress($user -> email);
			$mailer -> SetFrom('info@findbo.dk');
			$mailer -> MsgHTML(view('mails.forgotpassword')
									->with([
										'fname' => $user -> fname,
										'reset_link' => url('password/reset/' . $token),
									])
								);
			return $mailer -> send();
		}

		/**
		* Sends an e-mail to Findbo with a report message regarding a property
		*
		* @param array  $data
		* @return boolean  Indicates whether the message has been sent
		*/
		public function sendReportMail(array $data) {
			$mailer = $this -> getMailer();
			$mailer -> Subject = 'Findbo - Property Status';
			$mailer -> addAddress('vgrcic@hotmail.com');
			$mailer -> SetFrom($data['reporter_email']);
			$mailer -> MsgHTML(view('mails.propertyadreport')
									->with([
										'property_link' => url('property_detail/' . $data['prop_id']),
										'reporter_email' => $data['reporter_email'],
										'reporter_name' => $data['reporter_name'],
										'reporter_reason' => $data['reporter_reason'],
										'reporter_reason_desc' => $data['reporter_reason_desc'],
									])
								);
			return $mailer -> send();
		}

	}

?>
