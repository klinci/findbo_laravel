<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
	protected $table = "wishlist";
	protected $fillable = [ 'property_fk', 'user_id' ];
	
	public static function favoriteProperty($userId)
	{
		$objProperty = DB::table('wishlist')
					->select('properties.*','users.email as user_email','zip_code.city_name','wishlist.id as wishlistid')
					->join('properties','wishlist.property_fk','=','properties.id')
					->join('zip_code','properties.zip_code_id','=','zip_code.id')
					->join('users','wishlist.user_id','=','users.id')
					->where('wishlist.user_id','=',$userId)
					->get();
		return $objProperty;
	}
	
}
