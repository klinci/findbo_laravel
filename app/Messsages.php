<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class Messsages extends Model
{
    protected $table = "messages";
    protected $fillable = [
    	'message_text','time','conversation_fk','user_sender_fk','user_receiver_fk','isSeen','relatedProperty'
    ];
    
    public static function message($page=1,$limit=10,$status,$keywordsStr='')
    {
    	$startpoint = ($page * $limit) - $limit;
    	
    	$limitCls = '';
    	if($page!=0 && $limit!=0)
    	{
    		$limitCls .= 'LIMIT '.$startpoint.', '.$limit;
    	}
    	if($keywordsStr!="")
    	{
    		$keywordsStr = " AND m.message_text LIKE '%".$keywordsStr."%' ";
    	}
    	
    	$userId = Auth::user()->id;
    	
    	$objMessage = DB::select('SELECT m.conversation_fk FROM messages m WHERE (m.user_receiver_fk = '.$userId.') 
    						'.$keywordsStr.' ORDER BY m.`time` DESC ' 
							.$limitCls);
    	if($page!=0 && $limit!=0)
    	{
    		$arrOfMsg = array();
	    	if(!empty($objMessage) && count($objMessage)>0)
	    	{
	    		foreach($objMessage as $msg)
	    		{
	    			$c_id = $msg->conversation_fk;
	    			if($status=='inbox')
	    			{
	    				$objMsg = DB::table('messages')
	    							->select('messages.*','users.fname','users.lname')
	    							->join('users','messages.user_sender_fk','=','users.id')
	    							->where('messages.conversation_fk','=',$c_id)
	    							->where('messages.user_receiver_fk','=',$userId)
	    							->orderBy('messages.time','desc')
	    							->limit(1)
	    							->first();
	    			}
	    			else
	    			{
	    				$objMsg = DB::table('messages')
				    				->select('messages.*','users.fname','users.lname')
				    				->join('users','messages.user_sender_fk','=','users.id')
				    				->where('messages.conversation_fk','=',$c_id)
				    				->where('messages.user_sender_fk','=',$userId)
				    				->orderBy('messages.time','desc')
				    				->first();
	    			}
	    			
	    			if(!empty($objMsg) && count($objMsg)>0)
	    			{
	    				
	    				$name			= $objMsg->fname.' '.$objMsg->lname;
	    				$message_date	= $objMsg->time;
	    				$message_text   = $objMsg->message_text;
	    				$is_seen   		= $objMsg->isSeen;
	    				$related_prop_id = $objMsg->relatedProperty;
	    				
	    				$objProperty = Properties::find($objMsg->relatedProperty);
	    				
	    				$headline = '';
	    				if(!empty($objProperty) && count($objProperty)>0)
	    				{
	    					if($objProperty->headline_dk!="")
	    					{
	    						$headline = $objProperty->headline_dk;
	    					}
	    					else
	    					{
	    						$headline = $objProperty->headline_eng;
	    					}
	    				}
	    				
	    				$arrOfMsg[] = array(
	    					'c_id'=>$c_id,
	    					'c_title'=>$headline,
	    					'is_seen'=>$is_seen,
	    					'message_date'=>$message_date,
	    					'message_text'=>$message_text,
	    					'name'=>$name
	    				);
	    				
	    			}
	    		}
	    	}
	    	
	    	return $arrOfMsg;
    	}
    	else
    	{
			return $objMessage;
    	}    	
    }
}
