<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SeekerTransactions extends Model
{

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'charge_id', 'transaction_id', 'created_date', 'status', 'amount', 'currency', 'paid', 'object_id', 'object', 'brand', 'last4', 'dynamic_last4', 'funding', 'exp_month', 'exp_year', 'fingerprint', 'name', 'address_line1', 'address_line2', 'address_city', 'address_state', 'address_zip', 'address_country', 'cvc_check', 'address_line1_check', 'address_zip_check', 'failure_code', 'failure_message', 'description', 'seek_package_id', 'metadata', 'receipt_email', 'receipt_number', 'action_by',
	];

	/**
	* Creates a new transaction for purchasing a seeker package.
	*
	* @param \Stripe\Charge  $charge
	* @param \App\SeekerPackages  $package
	*/
    public static function createSeekerPackageTransaction($charge, $package) {
		SeekerTransactions::create([
			'user_id' => Auth::id(),
			'charge_id' => $charge -> id,
			'transaction_id' => $charge -> balance_transaction,
			'created_date' => date('Y-m-d H:i:s',$charge -> created),
			'status' => $charge -> status,
			'amount' => floatval($charge -> amount/100),
			'currency' => $charge -> currency,
			'paid' => $charge -> paid,
			'object_id' => $charge -> source->id,
			'object' => $charge -> source->object,
			'brand' => $charge -> source->brand,
			'last4' => $charge -> source->last4,
			'dynamic_last4' => $charge -> source->dynamic_last4,
			'funding' => $charge -> source->funding,
			'exp_month' => $charge -> source->exp_month,
			'exp_year' => $charge -> source->exp_year,
			'fingerprint' => $charge -> source->fingerprint,
			'name' => $charge -> source->name,
			'address_line1' => $charge -> source->address_line1,
			'address_line2' => $charge -> source->address_line2,
			'address_city' => $charge -> source->address_city,
			'address_state' => $charge -> source->address_state,
			'address_zip' => $charge -> source->address_zip,
			'address_country' => $charge -> source->address_country,
			'cvc_check' => $charge -> source->cvc_check,
			'address_line1_check' => $charge -> source->address_line1_check,
			'address_zip_check' => $charge -> source->address_zip_check,
			'failure_code' => $charge -> failure_code,
			'failure_message' => $charge -> failure_message,
			'description' => $charge -> description,
			'seek_package_id' => $package -> id,
			'metadata' => json_encode($charge -> metadata),
			'receipt_email' => $charge -> receipt_email,
			'receipt_number' => $charge -> receipt_number,
			'action_by' => 1,
		]);
	}
}
