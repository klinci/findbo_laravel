<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Conversation extends Model
{
	protected $table = 'conversation';
	protected $fillable = [
		'user_one','user_two'
	];
	
	public static function getConversationInfo($id)
	{
		$objMessage = DB::table('messages')
			->select('messages.*','users.fname','users.lname')
			->join('users','users.id','=','messages.user_sender_fk')
			->where('messages.conversation_fk','=',$id)
			->orderBy('messages.time','ASC')
			->get();
		
		$arrOfConversation = array();
		if(!empty($objMessage) && count($objMessage)>0)
		{
			foreach($objMessage as $con)
			{
				$name			= $con->fname.' '.$con->lname;
				$message_date	= $con->time;
				$message_text   = $con->message_text;
				$receiver_id    = $con->user_receiver_fk;
				$propertyId		= $con->relatedProperty;
				
				$objProperty = Properties::find($propertyId);
				
				$c_title = "";
				if(!empty($objProperty) && count($objProperty)>0)
				{
					if($objProperty->headline_dk != "")
					{
						$c_title = $objProperty->headline_dk;
					}
					else
					{
						$c_title = $objProperty->headline_eng;
					}
				}
				$prop_user_id = $objProperty->user_id;
				
				$arrOfConversation[] = array(
						'name'=>$name,
						'message_date'=>$message_date,
						'message_text'=>$message_text,
						'c_title'=>$c_title,
						'c_id'=>$id,
						'receiver_id'=>$receiver_id,
						'propertyId'=>$propertyId,
						'prop_user_id'=>$prop_user_id
					);
				
			}
		}
		return $arrOfConversation;
	}
}
