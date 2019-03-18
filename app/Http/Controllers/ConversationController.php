<?php

namespace App\Http\Controllers;

use App\Messsages;

use App\Conversation;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConversationController extends Controller
{

	public function __construct() {
		$this -> middleware('auth');
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
}
