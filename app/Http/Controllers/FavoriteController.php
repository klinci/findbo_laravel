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
		$id = $request->input('id');
		
		Wishlist::destroy($id);
		
		echo 1;
		exit;
	}
}
