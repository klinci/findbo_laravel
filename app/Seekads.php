<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seekads extends Model
{
	protected $table = 'seekProperty';
	protected $fillable = [
		'profileType','civilStatus','title','description','name','age','phone','phone2','email','location','maxRent','minArea','minRooms','type','rentalPeriod','userFk','date','thumbnail','thumbnail_large','is_active'
	];

	public function getAllSeekProperty($start="",$limit="",$search="",$keyword="",$fromDate="",$toDate="",$status="",$pid="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('seekProperty')
					->select('seekProperty.*', 'users.fname', 'users.lname', 'areas.name')
					->join('users', 'seekProperty.userFk', '=', 'users.id')
					->join('areas', 'seekProperty.location', '=', 'areas.id')
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('seekProperty.title','LIKE',"%{$keyword}%")
							->orWhere('seekProperty.email','LIKE',"%{$keyword}%")
							->orWhere('users.lname','LIKE',"%{$keyword}%")
							->orWhere('areas.name','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('seekProperty.date',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
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
							return $query->where('seekProperty.is_active','=',"$status");
						}
					})
					->when($pid, function($query) use ($pid){
						if($pid!="")
						{
							return $query->where('seekProperty.id','=',"$pid");
						}
					})
					->orderBy('id','desc')
					->get();
		}
		else
		{
			//echo '<br>===>'.$keyword.'==='.$fromDate.'=='.$toDate.'=='.$status.'==='.$pid;

			$properties = DB::table('seekProperty')
					->select('seekProperty.*', 'users.fname', 'users.lname', 'areas.name')
					->join('users', 'seekProperty.userFk', '=', 'users.id')
					->join('areas', 'seekProperty.location', '=', 'areas.id')
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('seekProperty.title','LIKE',"%{$keyword}%")
							->orWhere('seekProperty.email','LIKE',"%{$keyword}%")
							->orWhere('users.lname','LIKE',"%{$keyword}%")
							->orWhere('areas.name','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('seekProperty.date',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
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
							return $query->where('seekProperty.is_active','=',"$status");
						}
					})
					->when($pid, function($query) use ($pid){
						if($pid!="")
						{
							return $query->where('seekProperty.id','=',"$pid");
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
		DB::table('seekProperty')->where('id', $id)->delete();
	}

	public function getUserSeekProperty($userId)
	{
		$objSeekProperty = DB::table('seekProperty')
					->select('seekProperty.*','users.email', 'areas.name')
					->join('users', 'seekProperty.userFk', '=', 'users.id')
					->join('areas', 'seekProperty.location', '=', 'areas.id')
					->where('users.id','=',$userId)
					->orderBy('seekProperty.id','DESC');
		return $objSeekProperty;
	}

	public function getNewHomeSeeker()
	{
		$today_date = date('Y-m-d H:i:s');

		$objHomeSeeker = DB::table('seekProperty')
						->select('seekProperty.*')
						->join('users','seekProperty.userFk','=','users.id')
						->join('areas','seekProperty.location','=','areas.id')
						->where('seekProperty.is_active','=',1)
						->whereDate('users.package_expiry_date','>',$today_date)
						//->orderBy('users.seek_package_id','DESC')
						->orderBy('seekProperty.id','DESC')
						->offset(0)
						->limit(12)
						//->toSql();
						->get();
		//dd($objHomeSeeker);
		return $objHomeSeeker;
	}

	public static function getHomeSeekerById($id)
	{
		$objHomeSeek = DB::table('seekProperty')
					->select('seekProperty.*','users.email','users.id as user2', 'users.email as me', 'areas.name as loc')
					->join('users', 'seekProperty.userFk', '=', 'users.id')
					->join('areas', 'seekProperty.location', '=', 'areas.id')
					->where('seekProperty.id','=',$id)
					->first();
		return $objHomeSeek;
	}

	public static function getHomeSeekerPropertyByLocation($locationId,$id)
	{
		$r_properties = array();

		if($locationId!="")
		{
			$objHomeSeekProp = self::getHomeSeekerPropertyByLocationwise($id,$locationId);

			if(!empty($objHomeSeekProp) && count($objHomeSeekProp)>0)
			{
				foreach($objHomeSeekProp as $prop)
				{
					array_push($r_properties, $prop);
				}
			}
		}

		if(!empty($r_properties) && count($r_properties) < 5)
		{
			$objHomeSeekProp1 = self::getHomeSeekerPropertyByLocationwise($id);
			if(!empty($objHomeSeekProp1) && count($objHomeSeekProp1)>0)
			{
				foreach($objHomeSeekProp1 as $prop)
				{
					array_push($r_properties, $prop);
				}
			}
		}
		return $r_properties;
	}

	public static function getHomeSeekerPropertyByLocationwise($id,$locationId='')
	{
		if($locationId!='')
		{
			$objHomeSeekProp = DB::table('seekProperty')
						->select('seekProperty.*', 'areas.name as loc')
						->join('areas', 'seekProperty.location', '=', 'areas.id')
						->where('seekProperty.location','=',$locationId)
						->where('seekProperty.is_active','=',1)
						->where('seekProperty.id','<>',$id)
						//->orderBy('RANd()','ASC')
						->orderBy(DB::raw('RAND()'))
						->limit(5)
						->get();
		}
		else
		{
			$objHomeSeekProp = DB::table('seekProperty')
						->select('seekProperty.*', 'areas.name as loc')
						->join('areas', 'seekProperty.location', '=', 'areas.id')
						->where('seekProperty.is_active','=',1)
						->where('seekProperty.id','<>',$id)
						//->orderBy('RANd()','ASC')
						->orderBy(DB::raw('RAND()'))
						->limit(5)
						->get();
		}


		return $objHomeSeekProp;
	}
}
