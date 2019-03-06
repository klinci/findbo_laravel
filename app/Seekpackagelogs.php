<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seekpackagelogs extends Model
{
	protected $table = "seeker_package_logs";
	protected $fillable = ['user_id','package_status','log_date','log_comment'];	
	
	public function insertSeekPackageLog($userId, $package_status, $log_comment)
	{
		$objLogs = new Seekpackagelogs([
				'user_id'=>$userId,
				'package_status'=>$package_status,
				'log_date'=>date('Y-m-d H:i:s'),
				'log_comment'=>$log_comment
			]);
		$objLogs->save();
		
	}
}
