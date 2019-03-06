<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rentalperiod extends Model
{
	protected $table = "rental_period";
	protected $fillable = ['rental_name'];
	
	public function getAllRentalPeriod($start="",$limit="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('rental_period')
			->orderBy('id','desc')
			->get();
		}
		else
		{
			$properties = DB::table('rental_period')
			->offset($start)
			->limit($limit)
			->orderBy('id','desc')
			->get();
		}
			
		return $properties;
	}
}
