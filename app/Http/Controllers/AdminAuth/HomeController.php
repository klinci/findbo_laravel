<?php

namespace App\Http\Controllers\AdminAuth;

use App\Seekpackagelogs;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$objTotalUsers = DB::table('users')->count();
		
		$objActiveProperties = DB::table('properties')->where('status','=',1)->count();
		
		$objActiveSeekProperties = DB::table('seekProperty')->where('is_active','=',1)->count();
		
		$objMessages = DB::table('messages')->count();

		$obj = DB::select('select count(seek_package_id) as count, seek_package_id
							 from seeker_transactions where status = "succeeded" group by seek_package_id');

		$objUnScribedUsers = DB::table('users')
							->join('seeker_package_logs','seeker_package_logs.user_id','=','users.id')
							->where('auto_renew_seek_package','=',0)
							->count();
		
		$arrOf['all_time']['total_users'] = $objTotalUsers;
		$arrOf['all_time']['total_active_properties'] = $objActiveProperties;
		$arrOf['all_time']['total_active_seek_properties'] = $objActiveSeekProperties;
		$arrOf['all_time']['total_messages'] = $objMessages;
		$arrOf['all_time']['total_green_packages'] = $obj[0]->count;
		$arrOf['all_time']['total_blue_packages'] = $obj[1]->count;
		$arrOf['all_time']['total_unsubscribed'] = $objUnScribedUsers;

		//------------------------------------------------------
		
		$lastMonthDate = date('Y-m-d',strtotime("-30 day"));
		$objLast30DaysUsers = DB::table('users')
								->whereDate('timeJoined','>',$lastMonthDate)
								->count();
		
		$objLast30DaysActiveProperties = DB::table('properties')
								->where('status','=',1)
								->whereDate('date_published','>',$lastMonthDate)
								->count();
		
		
		$objLast30DaysActiveSeekProperties = DB::table('seekProperty')
									->where('is_active','=',1)
									->whereDate('date','>',$lastMonthDate)
									->count();
		
		$objLast30DaysMessages = DB::table('messages')
						->whereDate('time','>',$lastMonthDate)
						->count();
		
		$objLast30DaysGreenPackages = DB::table("seeker_transactions")
						->where('status','=','succeeded')
						->where('seek_package_id','=','1')
						->whereDate('created_date','>',$lastMonthDate)
						->count();
		
		$objLast30DaysBluePackages = DB::table("seeker_transactions")
						->where('status','=','succeeded')
						->where('seek_package_id','=','2')
						->whereDate('created_date','>',$lastMonthDate)
						->count();
		
		$objLast30DaysUnScribedUsers = DB::table('users')
						->join('seeker_package_logs','seeker_package_logs.user_id','=','users.id')
						->where('auto_renew_seek_package','=',0)
						->whereDate('log_date','>',$lastMonthDate)
						->count();
		
		$arrOf['last_30_days']['total_users'] = $objLast30DaysUsers;
		$arrOf['last_30_days']['total_active_properties'] = $objLast30DaysActiveProperties;
		$arrOf['last_30_days']['total_active_seek_properties'] = $objLast30DaysActiveSeekProperties;
		$arrOf['last_30_days']['total_messages'] = $objLast30DaysMessages;
		$arrOf['last_30_days']['total_green_packages'] = $objLast30DaysGreenPackages;
		$arrOf['last_30_days']['total_blue_packages'] = $objLast30DaysBluePackages;
		$arrOf['last_30_days']['total_unsubscribed'] = $objLast30DaysUnScribedUsers;
		
		//----------------------------------------------
		
		$lastWeekDate = date('Y-m-d',strtotime("-7 day"));
		
		$objLast7DaysUsers = DB::table('users')
							->whereDate('timeJoined','>',$lastWeekDate)
							->count();
		
		$objLast7DaysActiveProperties = DB::table('properties')
							->where('status','=',1)
							->whereDate('date_published','>',$lastWeekDate)
							->count();
		
		
		$objLast7DaysActiveSeekProperties = DB::table('seekProperty')
							->where('is_active','=',1)
							->whereDate('date','>',$lastWeekDate)
							->count();
		
		$objLast7DaysMessages = DB::table('messages')
							->whereDate('time','>',$lastWeekDate)
							->count();

		$objLast7DaysGreenPackages = DB::table("seeker_transactions")
							->where('status','=','succeeded')
							->where('seek_package_id','=','1')
							->whereDate('created_date','>',$lastWeekDate)
							->count();
		
		$objLast7DaysBluePackages = DB::table("seeker_transactions")
							->where('status','=','succeeded')
							->where('seek_package_id','=','2')
							->whereDate('created_date','>',$lastWeekDate)
							->count();
		
		$objLast7DaysUnScribedUsers = DB::table('users')
							->join('seeker_package_logs','seeker_package_logs.user_id','=','users.id')
							->where('auto_renew_seek_package','=',0)
							->whereDate('log_date','>',$lastWeekDate)
							->count();
		
		$arrOf['last_7_days']['total_users'] = $objLast7DaysUsers;
		$arrOf['last_7_days']['total_active_properties'] = $objLast7DaysActiveProperties;
		$arrOf['last_7_days']['total_active_seek_properties'] = $objLast7DaysActiveSeekProperties;
		$arrOf['last_7_days']['total_messages'] = $objLast7DaysMessages;
		$arrOf['last_7_days']['total_green_packages'] = $objLast7DaysGreenPackages;
		$arrOf['last_7_days']['total_blue_packages'] = $objLast7DaysBluePackages;
		$arrOf['last_7_days']['total_unsubscribed'] = $objLast7DaysUnScribedUsers;
		
		
		//------------------------------------
		
		$future_payments = array();
		$total_future_payments = 0;
		for($future_payment_day = 1; $future_payment_day <= 30; $future_payment_day++)
		{
			$f_date = date('Y-m-d',strtotime("+$future_payment_day day"));
			$future_payments["$f_date"] = 0;
		}
		
		$objSeekPackages = DB::table('seeker_packages')
							->where('id','=',2)
							->first();
		$packagePrice = 0;
		if(!empty($objSeekPackages) && count($objSeekPackages)>0)
		{
			$packagePrice = $objSeekPackages->price;
		}
		$expiry_date_start = date('Y-m-d',strtotime("+1 day"));
		$expiry_date_end = date('Y-m-d',strtotime("+30 day"));

		$objFutureCustomers = DB::table('users')
							->where('auto_renew_seek_package','=',1)
							->whereBetween('package_expiry_date',[$expiry_date_start, $expiry_date_end])
							->get();
		
		if(!empty($objFutureCustomers) && count($objFutureCustomers)>0)
		{
			foreach($objFutureCustomers as $futureCustomers)
			{
				$temp_f_expiry_date_time = $futureCustomers->package_expiry_date;
				$f_expiry_date_arr = explode(' ',$temp_f_expiry_date_time);
				$f_expiry_date = trim($f_expiry_date_arr[0]);
				$future_payments["$f_expiry_date"] += intval($packagePrice);
				$total_future_payments += intval($packagePrice);
			}
		}
		
		return view('admin.home',['all_time'=>$arrOf['all_time'],'last_30_days'=>$arrOf['last_30_days'],'last_7_days'=>$arrOf['last_7_days'],'total_future_payments'=>$total_future_payments,'future_payments'=>$future_payments]);
	}
}
