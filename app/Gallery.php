<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
	protected $table = "gallery";
	protected $fillable = [
		'path','property_id'
	];
	
	public static function getGalleryByPropertyId($propId)
	{
		$objGallery = DB::table('gallery')
						->where('property_id','=',$propId)
						->get();
		return $objGallery;
	}
}
