<?php

namespace App\Http\Controllers;

use App\SeekerPackageLogs;
use App\SeekerPackageHistory;
use App\SeekerTransactions;
use Auth;
use App\User;
use App\SeekerPackages;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Mail;
use App\Services\StripeService;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class PackageController extends Controller
{
	public function index($id = null)
	{
		$active_pack_id = 0;
		$remaining_days = 0;
		if(Auth::check())
		{
			$userId = Auth::user()->id;
			if ($userId > 0)
			{
				$objUser = User::find($userId);

				$today_date = date('Y-m-d H:i:s');
				if((strtotime($objUser->package_expiry_date)>strtotime($today_date)) && ($objUser->seek_package_id == 2))
				{
					$active_pack_id = $objUser->seek_package_id;
				}
				elseif((strtotime($objUser->package_expiry_date)>strtotime($today_date)) && ($objUser->seek_package_id == 1))
				{
					$active_pack_id = $objUser->seek_package_id;
				}

				$today_date = date('Y-m-d H:i:s');
				if(($active_pack_id == 1) || ($active_pack_id == 2))
				{
					$datediff = strtotime($objUser->package_expiry_date) - strtotime($today_date);
					$remaining_days = floor($datediff/(60*60*24));
				}
			}
		}
		$objGreenSeekPackages = DB::table('seeker_packages')
									->where('name','=','seeker_green_package_name')
									->first();

		$objBlueSeekPackages = DB::table('seeker_packages')
								->where('name','=','seeker_blue_package_name')
								->first();
		/* echo '<br>===>'.$active_pack_id;
		exit; */
		return view('package',[
			'active_pack_id' => $active_pack_id,
			'remaining_days' => $remaining_days,
			'objGreenSeekPackages' => $objGreenSeekPackages,
			'objBlueSeekPackages' => $objBlueSeekPackages,
			'stripe_key' => env('STRIPE_LIVE_PK'),
			'property_id' => $id,
		]);
	}



	public function packageAutoRenew(Request $request)
	{
		if(Auth::check())
		{
			$auto_renew_seek_package = 0;
			if($request -> input('autorenew'))
			{
				$auto_renew_seek_package = $request->input('autorenew');
			}

			DB::table('users')
					->where('id', Auth::id())
					->update([
						'auto_renew_seek_package' => $auto_renew_seek_package
					]);

			$log_p_status = $auto_renew_seek_package;
			$log_date = date('Y-m-d H:i:s');
			$log_comment = 'disabled by user';

			if($log_p_status == 1) {
				$log_comment = 'enabled by user';
			}

			$objSeekerLogs = new SeekerPackageLogs();
			$objSeekerLogs -> user_id = Auth::user()->id;
			$objSeekerLogs -> package_status = $log_p_status;
			$objSeekerLogs -> log_date = $log_date;
			$objSeekerLogs -> log_comment = $log_comment;
		}

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', \Lang::get('messages.auto_renew_success'));
		// return redirect('package');
		return redirect()->back();
	}



	public function purchasePackage(Request $request) {

		$package = SeekerPackages::find($request -> selected_pack);
		if (!$package) return redirect()->back();

		$stripe = new StripeService;
		$purchase = $stripe -> purchasePackage($request->stripeToken, $package);

		if ($purchase instanceof \Exception) {
			$request->session()->flash('message.level', 'danger');
			$request->session()->flash('message.content', $purchase->getMessage());
		} else {
			$request->session()->flash('message.level', 'success');
			$request->session()->flash(
				'message.content',
				// 'Package activated successfully.'
				\Lang::get('messages.udpate_package_message')
			);
		}
		if($request->property_id) {
			// return redirect('property_detail/'.$request->property_id);
			return redirect()->back();
		}
		// return redirect('package');
		return redirect()->back();






























/*

		/////// OLD CODE ////////

		$token = $request->input("stripeToken");
		//$postUserId = $request->input('u_id');
		$selectedPack = $request->input("selected_pack");
		//$packageName = $request->input("packageName");
		//$packageAmount = $request->input("packageAmount");

		$userEmail = Auth::user()->email;

		$objSeekerPackages = SeekerPackages::find($selectedPack);

		$price = $objSeekerPackages -> price;
		$days = $objSeekerPackages -> days;

		if ($objSeekerPackages->id == 1) {
			$name = __('messages.seeker_green_package_name');
		} else {
			$name = __('messages.seeker_blue_package_name');
		}

		include(app_path() . '/modules/Stripe/lib/Util/Set.php');
		include(app_path() . '/modules/Stripe/lib/Object.php');
		include(app_path() . '/modules/Stripe/lib/ApiResource.php');
		include(app_path() . '/modules/Stripe/lib/SingletonApiResource.php');
		include(app_path() . '/modules/Stripe/lib/Error/Base.php');

		$lib_path = app_path() . '/modules/Stripe/lib/';
		$allClasses = scandir($lib_path);
		foreach ($allClasses as $class)
		{
			if ($class == '.' || $class == '..')
				continue;

			if (is_dir($lib_path.$class))
			{	$allSubClasses = scandir($lib_path.$class);
			foreach ($allSubClasses as $subClass)
			{	if ($subClass == '.' || $subClass == '..')
				continue;

			if (!is_dir($lib_path.$class.'/'.$subClass))
				include_once $lib_path.$class.'/'.$subClass;
			}
			continue;
			}
			include_once $lib_path.$class;
		}

		Stripe::setApiKey(env('STRIPE_TEST_SK'));
		//\Stripe\Stripe::setApiKey("sk_live_QzQTc1EOLHMyfFYTb9AqG2Gw");	//live
		//\Stripe\Stripe::setApiKey("pk_test_oMmhTOQFmqt1ytxOpBw2kNSn");	//test

		$userId = Auth::user()->id;
		$userEmail = Auth::user()->email;

		$error_message = "";
		try
		{
			$customer = \Stripe\Customer::create(array(
								"description" => "ID : ".$userId.", Email : ".$userEmail,
								"source" => $token
						));

			$cust_id = $customer->id;

			DB::table('users')
				->where('id','=',$userId)
				->update(['cust_id' => $cust_id]);

			$charge_info_arr = array(
					"amount" => ($price * 100), // amount in cents, again
					"currency" => "DKK",
					"customer" => $cust_id,
					"description" => $name);

			$charge_info = \Stripe\Charge::create($charge_info_arr);

			if($charge_info)
			{
				$package_start_date	= date('Y-m-d H:i:s');
				$package_expiry_date= date('Y-m-d H:i:s',strtotime("+$days day"));

				if($charge_info->status == 'succeeded')
				{
					DB::table('users')
							->where('id','=',$userId)
							->update([
								'seek_package_id'=>$objSeekerPackages->id,
								'package_start_date'=>$package_start_date,
								'package_expiry_date'=>$package_expiry_date,
								'auto_renew_seek_package'=>1,
								'auto_renew_counter'=>0,
								'is_paid_member'=>1,
							]);
				}

				$seekerTransaction = new SeekerTransactions([
							'user_id'=>$userId,
							'charge_id'=>$charge_info->id,
							'transaction_id'=>$charge_info->balance_transaction,
							'created_date'=>date('Y-m-d H:i:s',$charge_info->created),
							'status'=>$charge_info->status,
							'amount'=>floatval($charge_info->amount/100),
							'currency'=>$charge_info->currency,
							'paid'=>$charge_info->paid,
							'object_id'=>$charge_info->source->id,
							'object'=>$charge_info->source->object,
							'brand'=>$charge_info->source->brand,
							'last4'=>$charge_info->source->last4,
							'dynamic_last4'=>$charge_info->source->dynamic_last4,
							'funding'=>$charge_info->source->funding,
							'exp_month'=>$charge_info->source->exp_month,
							'exp_year'=>$charge_info->source->exp_year,
							'fingerprint'=>$charge_info->source->fingerprint,
							'name'=>$charge_info->source->name,
							'address_line1'=>$charge_info->source->address_line1,
							'address_line2'=>$charge_info->source->address_line2,
							'address_city'=>$charge_info->source->address_city,
							'address_state'=>$charge_info->source->address_state,
							'address_zip'=>$charge_info->source->address_zip,
							'address_country'=>$charge_info->source->address_country,
							'cvc_check'=>$charge_info->source->cvc_check,
							'address_line1_check'=>$charge_info->source->address_line1_check,
							'address_zip_check'=>$charge_info->source->address_zip_check,
							'failure_code'=>$charge_info->failure_code,
							'failure_message'=>$charge_info->failure_message,
							'description'=>$charge_info->description,
							'seek_package_id'=>$objSeekerPackages->id,
							'metadata'=>json_encode($charge_info->metadata),
							'receipt_email'=>$charge_info->receipt_email,
							'receipt_number'=>$charge_info->receipt_number,
							'action_by'=>1,
						]);
				$seekerTransaction->save();

				$objSeekerHistory = new SeekerPackageHistory([
						'user_id'=>$userId,
						'cust_id'=>$cust_id,
						'seek_package_id'=>$objSeekerPackages->id,
						'package_start_date'=>$package_start_date,
						'package_expiry_date'=>$package_expiry_date,
						'transaction_id'=>$charge_info->balance_transaction
					]);
				$objSeekerHistory->save();

				$log_date	= date('Y-m-d H:i:s');
				$log_package_name = 'IntroPackage';

				if($pack == 2)
				{
					$log_package_name = 'FindboPackage';
				}

				$log_comment = 'enabled by user while purchasing '.$log_package_name;

				$objSeekerPackageLogs = new SeekerPackageLogs([
							'user_id'=>$userId,
							'package_status'=>1,
							'log_date'=>$log_date,
							'log_comment'=>$log_comment
						]);
				$objSeekerPackageLogs->save();










				$to = $charge_info->source->name;
				if($objSeekerPackages->id == 1)
				{
					$subject = 'FindBo - '.__('seeker_green_package_name').' '.__('lbl_activated');
				}
				else
				{
					$subject = 'FindBo - '.__('seeker_blue_package_name').' '.__('lbl_activated');
				}

				$objDemo = new \stdClass();
				$objDemo->subject = $subject;
				$objDemo->description = $charge_info->description;
				$objDemo->amount = $charge_info->amount;
				$objDemo->days = $days;
				$objDemo->balance_transaction = $charge_info->balance_transaction;

				Mail::to($to)->send(new Register($objDemo));
			}

			DB::table('seekProperty')
				->where('userFk','=',$userId)
				->update([
					'is_active'=>1
				]);

			return redirect('packageSuccess');


		}
























		catch(\Stripe\Error\Card $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_1');
		}
		catch (\Stripe\Error\InvalidRequest $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		catch (\Stripe\Error\Authentication $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		catch (\Stripe\Error\ApiConnection $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		catch (\Stripe\Error $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		catch(Exception $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		return view('stripe_message',['error_message'=>$error_message]);
		*/
	}



}
