<?php

namespace App\Http\Controllers;

use Auth;
use App\Messsages;
use App\Conversation;
use App\User;
use Illuminate\Http\Request;
use App\Services\MailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConversationController extends Controller
{

	public function __construct() {
		$this->middleware('auth');
	}

	public function index($id)
	{
		$objConversation = Conversation::find($id);
		$userId = Auth::user()->id;
		
		if(!empty($objConversation) && count($objConversation)>0)
		{
			if ($userId != $objConversation -> user_one && $userId != $objConversation -> user_two)
			{
				return redirect()->back();
			}
			else
			{
				$sender_user_id = $userId;
				if ($objConversation -> user_one == $userId)
				{	
					$receiver_user_id = $objConversation->user_two;
				}
				else
				{
					$receiver_user_id = $objConversation->user_one;
				}
				
				DB::table('messages')
						->where('conversation_fk','=',$id)
						->where('user_receiver_fk','=',$userId)
						->update([
							'isSeen'=>'true'
						]);
						
				$objConversation = Conversation::getConversationInfo($id);
				
				return view('conversation', [
					'objConversation' => $objConversation,
					'userId' => $userId,
					'c_id' => $id,
					'receiver_user_id' => $receiver_user_id
				]);
			}
		}
		else
		{
			return redirect()->back();
		}
	}
	
	public function submitMsg(Request $request)
	{
		$text = $request->input('replyText'); // Message text
		$conversationId = $request->input('conversationId'); // Id of the conversation
		$end_Id = $request->input('receiverUserId'); // User that recieves the message
		$created_at = $date = date('Y-m-d H:i:s'); // Time of the delivery
		$propertyId = $request->input('propertyId'); // Related property
		
		Messsages::create([
			'message_text'=>$text,
			'time'=>$created_at,
			'conversation_fk'=>$conversationId,
			'user_sender_fk'=>Auth::user()->id,
			'user_receiver_fk'=>$end_Id,
			'isSeen'=>'false',
			'relatedProperty'=>$propertyId
		]);
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Data submitted successfully.');
		return redirect()->back();
	}

	public function sendConversationWithEmail(Request $request)
	{

		$conversationCreate = Conversation::create([
			'user_one' => Auth::user()->id,
			'user_two' => $request->user_id,
		]);

		if($conversationCreate) {

			$message = Messsages::create([
				'message_text' => $request->message,
				'conversation_fk' => $conversationCreate->id,
				'user_sender_fk' => Auth::user()->id,
				'user_receiver_fk' => $request->user_id,
				'isSeen' => 'false',
				'relatedProperty' => $request->property_id
			]);

			$user = User::find($request->user_id);
			if($user) {

				$mailer = new MailService;
				$sender = [
					'email' => Auth::user()->email,
					'fname' => Auth::user()->fname,
				];
				$recipient = [
					'email' => $request->user_email,
					'fname' => $user->fname,
				];
				$mailer->sendHomeSeekerContactMail(
					$sender,
					$recipient,
					$request->message
				);

				if($mailer) {
					$message = 'Your message has been send.';
				} else {
					$message = 'Your message not send.';
				}

				return redirect()->back()->with('message',$message);
			}

		}

	}

}
