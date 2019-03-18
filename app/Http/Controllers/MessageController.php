<?php

namespace App\Http\Controllers;

use App\Messsages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MessageController extends Controller
{

	public function __construct() {
		$this -> middleware('auth');
	}

	public function inbox(Request $request)
	{
		$limit=10;
		$page = 1;
		
		$list_type = "inbox";
		if ($request -> input('page')) {
			$page = $request -> input('page');
		}
		
		$keywords = "";
		if($request -> input("keywords")) {
			$keywords = $request -> input("keywords");
		}
		
		$totalResult = Messsages::message(0, 0 , $list_type, $keywords);	
		
		$pagination = pagination($page, $limit, count($totalResult), 'message');
		
		$result = Messsages::message($page, $limit, $list_type, $keywords);
		
		return view('inbox', [
			'result' => $result,
			'pagination' => $pagination,
			'list_type' => $list_type,
			'page' => $page,
			'keywords' => $keywords
		]);
		
	}

	public function sent(Request $request)
	{
		$limit = 10;
		$page = 1;

		$list_type = "sent";
		if($request -> input('page')) {
			$page = $request->input('page');
		}

		$keywords = "";
		if ($request -> input("keywords")) {
			$keywords = $request -> input("keywords");
		}

		$totalResult = Messsages::message(0, 0, $list_type, $keywords);

		$pagination = pagination($page, $limit, count($totalResult), 'message');

		$result = Messsages::message($page, $limit, $list_type, $keywords);

		return view('sent', [
			'result' => $result,
			'pagination' => $pagination,
			'list_type' => $list_type,
			'page' => $page,
			'keywords' => $keywords
		]);
	}

	public function deleteMsg(Request $request)
	{
		$checkbox = $request->input('deleteArray');
		$checkbox = explode(",",$checkbox);

		if (!empty($checkbox) && count($checkbox) > 0)
		{
			foreach ($checkbox as $c)
			{
				DB::table('messages')
				->where('conversation_fk','=',$c)
				->delete();
					
				DB::table('conversation')
				->where('id','=',$c)
				->delete();
			}
		}

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Message deleted successfully.');
		return redirect()->back();
	}
}
