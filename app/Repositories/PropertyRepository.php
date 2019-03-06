<?php

	namespace App\Repositories;
	
	use DB;

	class PropertyRepository {

		public function countWhereCityNameLike($name) {
			return DB::table('properties')
                        ->select('zip_code.city_name')
                        ->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
                        ->where('zip_code.city_name','LIKE',"%". $name ."%")->count();
		}

	}

?>