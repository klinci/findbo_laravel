<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Properties extends Model
{
	protected $fillable = [
		'type','size','bedrooms','bathrooms','garage','parking_place','pets_allowed','pets_comment','furnished','basement','entry_phone','thumbnail','date_published','user_id','price_usd','price_dk','area_id','location1','location2','address','zip_code_id','description_eng','package_type_id','package_start_date','package_expiry_date','floor_side','headline_dk','headline_eng','prop_seo_title','description_dk','rental_period','ACTION','housenum','FLOOR','phonenum1','phonenum2','vacant','shareFriendly','handicapFriendly','youthHousing','seniorFriendly','rooms','rentDeposit','prepaidRent','expenses','balcony','lift','garden','scenic','sea','near_sea','near_forest','business_contact','business_contract','STATUS','is_available','is_featured_property','rented_date','groundarea','YEAR','energy','payment','gross','net','company_name','email','email2','vacantDate','openHouseAddress','openHouseComment','openHouseEndTime','openHouseStartTime','openHouseDate','downpayment','prop_site_name','prop_url','property_url','is_from_scrap','auto_id','created_at','updated_at', 'price',
	];

	/*
		PROPERTY STATUS:

		0 - pending
		1 - approved
		2 - rejected
		3 - inactive
	*/

	public function getAllProperties($start="",$limit="",$search="",$keyword="",$fromDate="",$toDate="",$status="",$pid="")
	{
		/* $properties = Properties::offset($start)
		 ->limit($limit)
		->orderBy($order,$dir)
		->get(); */

		if($start=="" && $limit=="")
		{
			$properties = DB::table('properties')
					->select('properties.id', 'users.fname', 'users.lname')
					->join('users', 'properties.user_id', '=', 'users.id')
					->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('properties.headline_eng','LIKE',"%{$keyword}%")
							->orWhere('users.fname','LIKE',"%{$keyword}%")
							->orWhere('users.lname','LIKE',"%{$keyword}%")
							->orWhere('zip_code.city_name','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('properties.date_published',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
						}
					})
					->when($status, function($query) use ($status) {
						if($status!="")
						{
							if($status==1) {
								$status = 0;
							}
							if($status==2) {
								$status = 1;
							}
							if($status==3) {
								$status = 2;
							}
							if($status==4) {
								$status = 3;
							}
							return $query->where('properties.status','=',"$status");
						}
					})
					->when($pid, function($query) use ($pid){
						if($pid!="")
						{
							return $query->where('properties.id','=',"$pid");
						}
					})
					->orderBy('id','desc')
					->get();
		}
		else
		{
			//echo '<br>===>'.$keyword.'==='.$fromDate.'=='.$toDate.'=='.$status.'==='.$pid;

			$properties = DB::table('properties')
					->select('properties.*', 'users.fname', 'users.lname')
					->join('users', 'properties.user_id', '=', 'users.id')
					->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('properties.headline_eng','LIKE',"%{$keyword}%")
							->orWhere('users.fname','LIKE',"%{$keyword}%")
							->orWhere('users.lname','LIKE',"%{$keyword}%")
							->orWhere('zip_code.city_name','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('properties.date_published',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
						}
					})
					->when($status, function($query) use ($status) {
						if($status!="")
						{
							if($status==1) {
								$status = 0;
							}
							if($status==2) {
								$status = 1;
							}
							if($status==3) {
								$status = 2;
							}
							if($status==4) {
								$status = 3;
							}

							//echo '<br>===>'.$status;

							return $query->where('properties.status','=',"$status");
						}
					})
					->when($pid, function($query) use ($pid){
						if($pid!="")
						{
							return $query->where('properties.id','=',"$pid");
						}
					})
					->offset($start)
					->limit($limit)
					->orderBy('id','desc')
					//->toSql();
					->get();
			//dd($properties);

			/* $properties = DB::table('properties')
			 ->select('properties.*', 'users.fname', 'users.lname')
			->join('users', 'properties.user_id', '=', 'users.id')
			->offset($start)
			->limit($limit)
			->orderBy('id','desc')
			->get(); */


		}

		return $properties;
	}

	public function deleteProperty($id)
	{
		DB::table('properties')->where('id', $id)->delete();

		DB::table('gallery')->where('property_id', $id)->delete();
	}

	public function updatePropertyStatus($id,$flag)
	{
		if($flag=='inactivate')
		{
			DB::table('properties')
				->where('id', $id)
				->update(['status' => 3]);
		}
		if($flag=='activate')
		{
			DB::table('properties')
				->where('id', $id)
				->update(['status' => 1]);
		}
		if($flag=='rejected')
		{
			DB::table('properties')
			->where('id', $id)
			->update(['status' => 2]);
		}
	}

	public function updatePropertyFeatured($id,$isFeatured)
	{
		DB::table('properties')
			->where('id', $id)
			->update(['is_featured_property' => $isFeatured]);
	}

	public function getPendingProperties($start,$limit,$search="")
	{
		if($search!="")
		{
			$properties = DB::table('properties')
					->select('properties.*', 'users.fname', 'users.lname')
					->join('users', 'properties.user_id', '=', 'users.id')
					->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
					->where('properties.status','=','0')
					->orWhere('users.fname','LIKE',"%{$search}%")
					->orWhere('users.lname','LIKE',"%{$search}%")
					->orWhere('properties.date_published','LIKE',"%{$search}%")
					->orWhere('properties.id','LIKE',"%{$search}%")
					->orWhere('properties.headline_dk','LIKE',"%{$search}%")
					->offset($start)
					->limit($limit)
					->orderBy('id','desc')
					->get();
		}
		else if($start=="" && $limit=="")
		{
			$properties = DB::table('properties')
					->select('properties.id', 'users.fname', 'users.lname')
					->join('users', 'properties.user_id', '=', 'users.id')
					->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
					->where('properties.status','=','0')
					->orderBy('id','desc')
					->get();
		}
		else
		{
			$properties = DB::table('properties')
						->select('properties.*', 'users.fname', 'users.lname')
						->join('users', 'properties.user_id', '=', 'users.id')
						->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
						->where('properties.status','=','0')
						->offset($start)
						->limit($limit)
						->orderBy('id','desc')
						->get();
		}

		return $properties;
	}

	public function getRejectedProperties($start,$limit,$search="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('properties')
			->select('properties.id', 'users.fname', 'users.lname')
			->join('users', 'properties.user_id', '=', 'users.id')
			->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
			->where('properties.status','=',2)
			->orderBy('id','desc')
			->get();
		}
		else
		{
			$properties = DB::table('properties')
			->select('properties.*', 'users.fname', 'users.lname')
			->join('users', 'properties.user_id', '=', 'users.id')
			->join('zip_code', 'properties.zip_code_id', '=', 'zip_code.id')
			->where('properties.status','=',2)
			->offset($start)
			->limit($limit)
			->orderBy('id','desc')
			->get();
		}

		return $properties;
	}

	function getSearchProperties($page=1,$limit=10,$arrOfParams = array(),$userId = 0)
	{

		/* echo '<pre>';
		print_r($arrOfParams); */

		$datePublished = date('Y-m-d',strtotime("-2 month"));
		$rentedDate = date('Y-m-d H:i:s',strtotime("-7 day"));

		$startpoint = ($page * $limit) - $limit;

		$limitCls = $whereCls = '';
		if($page!=0 && $limit!=0)
		{
			$limitCls .= 'LIMIT '.$startpoint.', '.$limit;
		}

		if(($arrOfParams["keyword"]!="" && $arrOfParams["keyword"]!="all") && (@$arrOfParams["code"]==""))
		{
			//$whereCls .= ' AND (properties.headline_eng LIKE "%'.$arrOfParams["keyword"].'%" OR properties.headline_dk LIKE "%'.$arrOfParams["keyword"].'%" OR areas.name LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.city_name LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.code LIKE "%'.$arrOfParams["keyword"].'%")';
			$whereCls .= ' AND (properties.headline_eng LIKE "%'.$arrOfParams["keyword"].'%" OR properties.headline_dk LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.city_name LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.code LIKE "%'.$arrOfParams["keyword"].'%")';
		}
		if(@$arrOfParams["code"]!="")
		{
			$whereCls .= ' AND zip_code.code = "'.$arrOfParams["code"].'"';
		}
		/* if(@$arrOfParams["area"]!="")
		{
			$whereCls .= ' AND properties.area_id IN ('.$arrOfParams["area"].')';
		} */
		if(@$arrOfParams["zipcode"]!="")
		{
			$whereCls .= ' AND properties.zip_code_id IN ('.$arrOfParams["zipcode"].')';
		}
		if(@$arrOfParams["price"]!="")
		{
			$whereCls .= ' AND properties.price = "'.$arrOfParams["price"].'"';
		}
		if(@$arrOfParams["type"]!="")
		{
			$whereCls .= ' AND properties.type = "'.$arrOfParams["type"].'"';
		}
		if(@$arrOfParams["minPrice"]!="")
		{
			$whereCls .= ' AND properties.price >= "'.$arrOfParams["minPrice"].'"';
		}
		if(@$arrOfParams["maxPrice"]!="")
		{
			$whereCls .= ' AND properties.price <= "'.$arrOfParams["maxPrice"].'"';
		}
		if(@$arrOfParams["minArea"]!="")
		{
			$whereCls .= ' AND properties.size >= '.$arrOfParams["minArea"].'';
		}
		if(@$arrOfParams["maxArea"]!="")
		{
			$whereCls .= ' AND properties.size <= '.$arrOfParams["maxArea"].'';
		}
		if(@$arrOfParams["minRooms"]!="")
		{
			$whereCls .= ' AND properties.rooms >= '.$arrOfParams["minRooms"].'';
		}
		if(@$arrOfParams["maxRooms"]!="")
		{
			$whereCls .= ' AND properties.rooms <= '.$arrOfParams["maxRooms"].'';
		}
		if(@$arrOfParams["rental"]!="")
		{
			$whereCls .= ' AND properties.rental_period IN ('.$arrOfParams["rental"].')';
		}
		if(@$arrOfParams["pets"]!="")
		{
			$whereCls .= ' AND properties.pets_allowed="'.$arrOfParams["pets"].'"';
		}
		if(@$arrOfParams["furnished"]!="")
		{
			$whereCls .= ' AND properties.furnished="'.$arrOfParams["furnished"].'"';
		}
		if(@$arrOfParams["businesscontract"]!="")
		{
			$whereCls .= ' AND properties.business_contract="'.$arrOfParams["businesscontract"].'"';
		}
		if(@$arrOfParams["garage"]!="")
		{
			$whereCls .= ' AND properties.garage="'.$arrOfParams["garage"].'"';
		}
		if(@$arrOfParams["balcony"]!="")
		{
			$whereCls .= ' AND properties.balcony="'.$arrOfParams["balcony"].'"';
		}
		if(@$arrOfParams["lift"]!="")
		{
			$whereCls .= ' AND properties.lift="'.$arrOfParams["lift"].'"';
		}
		if(@$arrOfParams["garden"]!="")
		{
			$whereCls .= ' AND properties.garden="'.$arrOfParams["garden"].'"';
		}
		if(@$arrOfParams["senior"]!="")
		{
			$whereCls .= ' AND properties.seniorFriendly="'.$arrOfParams["senior"].'"';
		}
		if(@$arrOfParams["youth"]!="")
		{
			$whereCls .= ' AND properties.youthHousing="'.$arrOfParams["youth"].'"';
		}
		if(@$arrOfParams["handicap"]!="")
		{
			$whereCls .= ' AND properties.handicapFriendly="'.$arrOfParams["handicap"].'"';
		}

		if(@$arrOfParams['sortBy']=='date')
		{
			$orderBy = 'ORDER BY properties.package_type_id DESC, properties.date_published '.$arrOfParams['sort_order'];
		}
		else if(@$arrOfParams['sortBy']=='size')
		{
			$orderBy = 'ORDER BY properties.package_type_id DESC, properties.size '.$arrOfParams['sort_order'];
		}
		else if($arrOfParams['sortBy']=='price')
		{
			$orderBy = 'ORDER BY properties.package_type_id DESC, properties.price '.$arrOfParams['sort_order'];
		}

		/* echo '<br>====>SELECT
								properties.id, properties.headline_dk, properties.headline_eng, properties.description_dk, properties.description_eng,
								properties.thumbnail, properties.price_usd, properties.size, properties.bedrooms, zip_code.city_name, areas.name,
								properties.action, properties.status, properties.type, properties.rooms, properties.is_available, properties.date_published
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN areas ON zip_code.area_id = areas.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE
							((properties.is_available=1) OR ((properties.is_available=0) AND (DATE(properties.rented_date)>="'.$rentedDate.'"))) AND
							properties.action="rent" AND
							(DATE(properties.date_published) > "'.$datePublished.'") AND
							properties.status=1 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls;
		exit; */

		if($userId == 0)
		{
			/* $objProperties = DB::select('SELECT
								properties.*, zip_code.city_name, areas.name
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN areas ON zip_code.area_id = areas.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE
							((properties.is_available=1) OR ((properties.is_available=0) AND (DATE(properties.rented_date)>="'.$rentedDate.'"))) AND
							properties.action="rent" AND
							(DATE(properties.date_published) > "'.$datePublished.'") AND
							properties.status=1 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls); */

			/* echo 'SELECT
								properties.*, zip_code.city_name
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE
							((properties.is_available=1) OR ((properties.is_available=0) AND (DATE(properties.rented_date)>="'.$rentedDate.'"))) AND
							properties.action="rent" AND
							(DATE(properties.date_published) > "'.$datePublished.'") AND
							properties.status=1 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls;
			exit; */

			$objProperties = DB::select('SELECT
								properties.*, zip_code.city_name
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE
							((properties.is_available=1) OR ((properties.is_available=0) AND (DATE(properties.rented_date)>="'.$rentedDate.'"))) AND
							properties.action="rent" AND
							(DATE(properties.date_published) > "'.$datePublished.'") AND
							properties.status=1 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls);
		}
		else
		{
			/* $objProperties = DB::select('SELECT
								properties.id, properties.headline_dk, properties.headline_eng, properties.description_dk, properties.description_eng,
								properties.thumbnail, properties.price_usd, properties.size, properties.bedrooms, zip_code.city_name, areas.name,
								properties.action, properties.status, properties.type, properties.rooms, properties.is_available, properties.date_published
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN areas ON zip_code.area_id = areas.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.user_id = "'.$userId.'"
						 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls); */
			$objProperties = DB::select('SELECT
								properties.id, properties.headline_dk, properties.headline_eng, properties.description_dk, properties.description_eng,
								properties.thumbnail, properties.price_usd, properties.price_dk, properties.price, properties.size, properties.bedrooms, zip_code.city_name,
								properties.action, properties.status, properties.type, properties.rooms, properties.is_available, properties.date_published
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.user_id = "'.$userId.'"
						 '.$whereCls.'
							'.$orderBy.'
							'.$limitCls);
		}

		return $objProperties;
	}

	public static function getPropertyById($id)
	{
		$objProperty = DB::table('properties')
						->select('properties.*','users.email as user_email')
						->join('zip_code','properties.zip_code_id','=','zip_code.id')
						->join('users','properties.user_id','=','users.id')
						->where('properties.id','=',$id)
						->first();

		return $objProperty;

	}

	public static function getRelatedProperty($zipcodeId,$propertyId)
	{
		$r_property_exp_date = date('Y-m-d',strtotime("-2 month"));

		$arrOfProperty = array();
		if(!empty($zipcodeId))
		{
			$objProperties = DB::select('SELECT
								properties.id
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id AND properties.zip_code_id="'.$zipcodeId.'"
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.id <> "'.$propertyId.'" AND properties.is_available=1 AND
							(properties.date_published >"'.$r_property_exp_date.'") AND  properties.status=1
							ORDER BY RAND() LIMIT 5');
			if(!empty($objProperties) && count($objProperties)>0)
			{
				foreach($objProperties as $property)
				{
					$arrOfProperty[$property->id] = $property->id;
				}
			}
		}

		/* if($areaId!="" && count($arrOfProperty)<5)
		{
			$objProperties2 = DB::select('SELECT
								properties.id
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id AND zip_code.area_id="'.$areaId.'" AND properties.zip_code_id > 0
							INNER JOIN areas ON zip_code.area_id = areas.id
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.id <> "'.$propertyId.'" AND properties.is_available=1 AND
							(properties.date_published >"'.$r_property_exp_date.'") AND  properties.status=1
							ORDER BY RAND() LIMIT 5');
			if(!empty($objProperties2) && count($objProperties2)>0)
			{
				foreach($objProperties2 as $property)
				{
					$arrOfProperty[$property->id] = $property->id;
				}
			}
		} */

		$objProperties3 = DB::select('SELECT
								properties.id
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id AND properties.zip_code_id > 0
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.id <> "'.$propertyId.'" AND properties.is_available=1 AND
							(properties.date_published >"'.$r_property_exp_date.'") AND  properties.status=1
							ORDER BY RAND() LIMIT 5');
		if(!empty($objProperties3) && count($objProperties3)>0)
		{
			foreach($objProperties3 as $property3)
			{
				$arrOfProperty[$property3->id] = $property3->id;
			}
		}

		if(!empty($arrOfProperty) && count($arrOfProperty)>0)
		{
			$mainProperty = DB::select('SELECT
								properties.id, properties.headline_dk, properties.headline_eng, properties.description_dk, properties.description_eng,
								properties.thumbnail, properties.price_usd, properties.price, properties.size, properties.bedrooms, zip_code.city_name,
								properties.action, properties.status, properties.type, properties.rooms, properties.is_available, properties.date_published
							FROM properties
							INNER JOIN zip_code ON properties.zip_code_id = zip_code.id AND properties.zip_code_id > 0
							INNER JOIN users ON users.id = properties.user_id
							WHERE properties.id IN ('.implode(",",$arrOfProperty).')
							LIMIT 6');
			return $mainProperty;
		}
		else
		{
			return [];
		}
	}
}
