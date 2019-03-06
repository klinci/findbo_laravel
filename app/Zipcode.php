<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Zipcode extends Model
{
	protected $table = "zip_code";
	
	protected $fillable = ['code', 'city_name', 'area_id'];
	
	public function getAllZipcode($start="",$limit="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('zip_code')
			->select('zip_code.*','areas.name')
			->leftJoin('areas','zip_code.area_id','=','areas.id')
			->orderBy('id','desc')
			->get();
		}
		else
		{
			$properties = DB::table('zip_code')
			->select('zip_code.*','areas.name')
			->leftJoin('areas','zip_code.area_id','=','areas.id')
			->offset($start)
			->limit($limit)
			->orderBy('id','desc')
			->get();
		}
			
		return $properties;
	}
}
