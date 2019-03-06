<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SeekerPackageHistory extends Model
{

	protected $table = 'seeker_package_history';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'cust_id', 'seek_package_id', 'package_start_date', 'package_expiry_date', 'transaction_id',
	];

    /**
	* Records a seeker package purchasing transaction.
	*
	* @param \Stripe\Customer  $customer
	* @param \App\SeekerPackages  $package
	* @param \Stripe\Charge  $charge
	*/
    public static function createPackagePurchaseHistory($customer, $package, $charge) {
		$package_start_date	= date('Y-m-d H:i:s');
		$package_expiry_date = date('Y-m-d H:i:s',strtotime("+".$package -> duration." day"));
		SeekerPackageHistory::create([
			'user_id' => Auth::id(),
			'cust_id' => $customer -> id,
			'seek_package_id' => $package -> id,
			'package_start_date' => $package_start_date,
			'package_expiry_date' => $package_expiry_date,
			'transaction_id' => $charge -> balance_transaction,
		]);
	}
}
