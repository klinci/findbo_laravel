<?php

namespace App;

use App\Services\MailService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'cust_id', 'gender', 'fname', 'lname', 'city', 'email', 'password', 'country', 'phone', 'bio', 'profile_picture', 'newsletter', 'active', 'code', 'token', 'isAdmin', 'timeJoined', 'isBan', 'userType', 'seek_package_id', 'package_start_date', 'package_expiry_date', 'auto_renew_seek_package', 'auto_renew_counter', 'is_paid_member', 'hunting_email_unsubscribe', 'sp_renew_tried_date', 'ip_address', 'remember_token'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	'password', 'remember_token',
	];

	public function sendPasswordResetNotification($token) {
		$mailer = new MailService;
		$mailer -> sendPasswordResetMail($this, $token);
	}
	
	public function checkEmail($email)
	{
		$objUser = DB::table("users")
					->where(array('email'=>$email,'token'=>1,'isBan'=>'false'))
					->first();
		return $objUser;
	}
	
	public function getAllUsers($start="",$limit="",$search="",$userType="",$keyword="",$fromDate="",$toDate="",$status="")
	{
		if($start=="" && $limit=="")
		{
			$properties = DB::table('users')
					->when($userType, function($query) use ($userType){
						if($userType!="")
						{
							return $query->where('userType',$userType);
						}
					})
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('fname','LIKE',"%{$keyword}%")
							->where('lname','LIKE',"%{$keyword}%")
							->where('email','LIKE',"%{$keyword}%")
							->where('phone','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('timeJoined',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
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
							
							if($status==0 || $status==1)
							{
								return $query->where('token','=',"$status");
							}
							else if($status==2)
							{
								return $query->where('isBan','=',"true");
							}
							else if($status==3)
							{
								return $query->where('isAdmin','=',"admin");
							}
						}
					})
					->orderBy('id','desc')
					->get();
		}
		else
		{
			//echo '<br>===>'.$keyword.'==='.$fromDate.'=='.$toDate.'=='.$status.'==='.$pid;
	
			$properties = DB::table('users')
					->when($userType, function($query) use ($userType){
						if($userType!="")
						{
							return $query->where('userType',$userType);
						}
					})
					->when($keyword, function($query) use ($keyword){
						if($keyword!="")
						{
							return $query->where('fname','LIKE',"%{$keyword}%")
							->orWhere('lname','LIKE',"%{$keyword}%")
							->orWhere('email','LIKE',"%{$keyword}%")
							->orWhere('phone','LIKE',"%{$keyword}%");
						}
					})
					->when([$fromDate,$toDate], function($query) use ($fromDate,$toDate) {
						if($fromDate!="" && $toDate!="")
						{
							return $query->whereBetween('timeJoined',[date('Y-m-d',strtotime($fromDate)), date('Y-m-d',strtotime($toDate))]);
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
							
							if($status==0 || $status==1)
							{
								return $query->where('token','=',"$status");
							}
							else if($status==2)
							{
								return $query->where('isBan','=',"true");
							}
							else if($status==3)
							{
								return $query->where('isAdmin','=',"admin");
							}
						}
					})
					->offset($start)
					->limit($limit)
					->orderBy('id','desc')
					//->toSql();
					->get();
					//dd($properties);
		}
			
		return $properties;
	}
	
	public function getUserById($id)
	{
		$objUser = DB::table('users')
					->where('id','=',$id)
					->get()
					->first();
		
		return $objUser;
		
	}
	
	public function checkEmailExists($id,$email)
	{
		$objUser = DB::table('users')
					->where('id','<>',$id)
					->where('email','=',$email)
					->get()
					->first();
		if(!empty($objUser) && count($objUser)>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function updateUser($id,$arrOfData)
	{
		foreach($arrOfData as $key=>$value)
		{
			DB::table('users')
				->where('id', $id)
				->update([$key=>$value]);
		}
	}

	/**
	* Updates user's records with information about a purchased package.
	*
	* @param \App\SeekerPackages  $package
	*/
	public function updateForPackagePurchase($package) {
		$package_start_date	= date('Y-m-d H:i:s');
		$package_expiry_date = date('Y-m-d H:i:s',strtotime("+".$package->duration." day"));
		$this -> update([
			'seek_package_id' => $package -> id,
			'package_start_date' => $package_start_date,
			'package_expiry_date' => $package_expiry_date,
			'auto_renew_seek_package' => 1,
			'auto_renew_counter' => 0,
			'is_paid_member' => 1,
		]);
	}

}
