<?php

	namespace App\Services;

	use Auth;
	use DB;
	use App\User;
	use App\SeekerTransactions;
	use App\SeekerPackageHistory;
	use App\SeekerPackageLogs;
	use App\Services\PHPMailer;

	use Stripe\Stripe;
	use Stripe\Charge;
	use Stripe\Customer;

	class StripeService {

		/**
		* Handles the request for purchasing a package.
		*
		* @param string  $stripeToken
		* @param \App\SeekerPackages  $package
		* 
		*/
		public function purchasePackage($stripeToken, $package) {

			try {

				Stripe::setApiKey(env('STRIPE_LIVE_SK'));
				$customer = $this -> createCustomer($stripeToken);

				DB::table('users')
					->where('id','=',Auth::id())
					->update(['cust_id' => $customer -> id]);

				if ($package -> id == 1)
					$name = __('messages.seeker_green_package_name');
				else $name = __('messages.seeker_blue_package_name');

				$charge = $this -> createCharge($customer, $package, $name);

				if ($charge) {
					if ($charge -> status == 'succeeded') {
						Auth::user()->updateForPackagePurchase($package);
						$mailer = new MailService;
						$mailer -> sendPackagePurchaseMail($charge, $package);
					}				
					SeekerTransactions::createSeekerPackageTransaction($charge, $package);
					SeekerPackageHistory::createPackagePurchaseHistory($customer, $package, $charge);
					SeekerPackageLogs::createPackagePurchaseLog($package);
				}
				return $charge;

			} catch(\Exception $e) {
				return $e;
			}
		}

		/**
		* Creates a new customer instance.
		*
		* @param string  token
		* @return \Stripe\Customer
		*/
		public function createCustomer($token) {
			return Customer::create([
				'email' => Auth::user() -> email,
				'source' => $token,
			]);
		}

		/**
		* Creates a new charge instance.
		*
		* @param \Stripe\Customer  $customer
		* @param \Stripe\Package  $package
		* @param string  $name
		* @return \Stripe\Charge
		*/
		public function createCharge($customer, $package, $name) {
			return Charge::create([
				'customer' => $customer->id,
				'amount' => $package->price * 100,
				'currency' => 'DKK',
				'description' => $name,
			]);
		}

	}

?>