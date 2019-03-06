<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SeekerPackageLogs extends Model
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'package_status', 'log_date', 'log_comment',
	];

	/**
	* Creates a log for package purchasing.
	*
	* @param \App\SeekerPackages
	*/
    public static function createPackagePurchaseLog($package) {
		$log_date	= date('Y-m-d H:i:s');
		$log_package_name = $package -> id == 2 ? 'FindboPackage' : 'IntroPackage';
		$log_comment = 'enabled by user while purchasing ' . $log_package_name;
		SeekerPackageLogs::create([
			'user_id' => Auth::id(),
			'package_status' => 1,
			'log_date' => $log_date,
			'log_comment' => $log_comment,
		]);
	}
}
