<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Area extends Model
{
	protected $fillable = ['name'];
	
	public function getAllArea($start="",$limit="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('areas')
						->orderBy('id','desc')
						->get();
		}
		else
		{
			$properties = DB::table('areas')
						->offset($start)
						->limit($limit)
						->orderBy('id','desc')
						->get();
		}
			
		return $properties;
	}
}
