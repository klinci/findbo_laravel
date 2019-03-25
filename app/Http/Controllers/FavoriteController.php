<?php

namespace App\Http\Controllers;

use App\Wishlist;
use Auth;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
	public function index()
	{
		$userId = Auth::user()->id;
		$objFavorite = Wishlist::favoriteProperty($userId);
		return view('favorite',['objFavorite'=>$objFavorite]);
	}
	
	public function removeToWishlist(Request $request)
	{

		$findWhislist = Wishlist::where('id', $request->id)->where('user_id', Auth::user()->id)->first();

		if($findWhislist) {
			$findWhislist->delete();
			return [
				'error' => 0,
				'message' => 'Whislist removed.'
			];
		}

		return [
			'error' => 1,
			'message' => 'Whislist not found.'
		];

	}

}
