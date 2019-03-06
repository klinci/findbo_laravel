<?php

namespace App\Http\Controllers\AdminAuth;

use App\Seekads;
use Auth;
use App\User;
use App\Seekpackagelogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
	public function index(Request $request)
	{
		$userType = $keyword = $fromDate = $toDate = $status = $propertyId = "";
		if($request->input("accType"))
		{
			$userType = $request->input("accType");
		}
		if($request->input("txtKeyword"))
		{
			$keyword = $request->input("txtKeyword");
		}
		if($request->input("txtFromDate")!="" && $request->input("txtToDate")!="")
		{
			$fromDate = $request->input("txtFromDate");
			$toDate = $request->input("txtToDate");
		}
		if($request->input("cmbStatus")!="")
		{
			$status = $request->input("cmbStatus");
		}
		
		return view('admin.users.users',['userType'=>$userType,'keyword'=>$keyword, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'status'=>$status]);
	}

	public function ajaxUsers(Request $request)
	{
		$userType = $request->input("userType");
		$keyword = $request->input("keyword");
		$fromDate = $request->input("fromDate");
		$toDate = $request->input("toDate");
		$status = $request->input("status");
		
		$objUsers = new User();
		
		$objAllUsers = $objUsers->getAllUsers("","","",$userType,$keyword,$fromDate,$toDate,$status);
		
		$totalData = count($objAllUsers);
		$totalFiltered = $totalData;
		
		$limit = $request->input('length');
		$start = $request->input('start');
		
		if(empty($request->input('search.value')))
		{
			$users = $objUsers->getAllUsers($start, $limit, "", $userType,$keyword,$fromDate,$toDate,$status);
		}
		else
		{
			$search = $request->input('search.value');
			$users = $objUsers->getAllUsers($start, $limit, $search, $userType, $keyword,$fromDate,$toDate,$status);
			$totalFiltered = count($users);
		}
		
		$currentDate = date('Y-m-d H:i:s');
		$data = array();
		if(!empty($users) && count($users)>0)
		{
			foreach($users as $post)
			{
				$uType = $post->userType;
				if($uType == '1')
				{
					$userTypeClass = 'Landlord';
				}
				else if($uType == '2')
				{
					$userTypeClass = 'House Seeker';
				}
				$nestedData['account_type'] = $userTypeClass;
				$nestedData['full_name'] = $post->fname.' '.$post->lname;
				$nestedData['email'] = $post->email;
				$nestedData['phone_number'] = $post->phone;
				$nestedData['date_registered'] = $post->timeJoined;
				if($post->token==1)
				{
					$nestedData['status'] = 'Active';
				}
				else
				{
					$nestedData['status'] = '<b>Not Active</b>';
				}
				
				$active_pack_id = 0;
				if((strtotime($post->package_expiry_date)>strtotime($currentDate)) && ($post->seek_package_id==2))
				{
					$active_pack_id = $post->seek_package_id;
				}
				else if((strtotime($post->package_expiry_date)>strtotime($currentDate)) && ($post->seek_package_id==1))
				{
					$active_pack_id = $post->seek_package_id;
				}
				
				if($active_pack_id == 1)
				{
					$nestedData['active_package'] = '<span class="pack_green"><b>IntroPakken</b></span>';
				}
				else if($active_pack_id == 2)
				{
					$nestedData['active_package'] = '<span class="pack_green"><b>FindboPakken</b></span>';
				}
				else //if($active_pack_id == 0)
				{
					$nestedData['active_package'] = 'None';
				}
				
				$view = '<a href="'.url("admin/users/view_profile?id=".$post->id).'"><i class="fa fa-file-text-o"></i></a>';
				
				if(Auth::user()->email=='info@findbo.dk' || Auth::user()->email=='info1@findbo.dk')
				{
					if($post->isAdmin=="admin")
					{
						$userIcon = '<a href="'.url("admin/users/convertuser/".$post->id).'" onclick="return confirm(\'Are you sure?\')" title="Convert from Admin to User"><img src="'.asset('public/admin/images/admin.png').'" /></a>';
					}
					else
					{
						$userIcon = '<a href="'.url("admin/users/convertuser/".$post->id).'" onclick="return confirm(\'Are you sure?\')" title="Convert from User to Admin"><i class="fa fa-user"></i></a>';
					}
					
					if($post->isBan=="true")
					{
						$ban = '<a href="'.url("admin/users/updatebanstatus/".$post->id).'" onclick="return confirm(\'Are you sure?\')" title="Apply Ban"><img src="'.asset('public/admin/images/unban.png').'" /></a>';
					}
					else
					{
						$ban = '<a href="'.url("admin/users/updatebanstatus/".$post->id).'" onclick="return confirm(\'Are you sure?\')" title="Remove Ban"><img src="'.asset('public/admin/images/ban.png').'" /></a>';
					}
					
				}
				else
				{
					$userIcon = $ban = '';
				}
		
				$nestedData['action'] = $view.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$userIcon.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$ban;
		
				$data[] = $nestedData;
			}
		}
		
		$json_data = array(
				"draw"            => intval($request->input('draw')),
				"recordsTotal"    => intval($totalData),
				"recordsFiltered" => intval($totalFiltered),
				"data"            => $data
		);
		
		echo json_encode($json_data);
	}
	
	public function convertUser($id, Request $request)
	{
		$objUsers = new User();
		$user = $objUsers->getUserById($id);
		
		if($user->isAdmin=="admin")
		{
			$arrOfData['isAdmin'] = 'false';
		}
		else 
		{
			$arrOfData['isAdmin'] = 'admin';
		}
		$objUsers->updateUser($id,$arrOfData);	

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record updated successfully.');
		return redirect('admin/users/index');
	}
	
	public function updateBanStatus($id, Request $request)
	{
		$objUsers = new User();
		$user = $objUsers->getUserById($id);
		
		if($user->isBan=="true")
		{
			$arrOfData = array(
					'isBan'=>"false"
			);
		}
		else
		{
			$arrOfData = array(
					'isBan'=>"true"
			);
		}
		
		$objUsers->updateUser($id,$arrOfData);
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record updated successfully.');
		return redirect('admin/users/index');
	}
	
	public function viewProfile(Request $request)
	{
		$id = $request->input("id");
		
		$objUsers = new User();
		$user = $objUsers->getUserById($id);
		
		return view('admin.users.view_profile',['objUser'=>$user, 'id'=>$id]);
	}
	
	public function checkMail(Request $request)
	{
		$getId = $request->input("id");
		$getEmail = $request->input("email");
		
		$objUser = new User();
		$checkEmailStatus = $objUser->checkEmailExists($getId,$getEmail);
		
		if($checkEmailStatus)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
		exit;
	}
	
	public function updateProfile(Request $request)
	{
		$getId = $request->input("txtId");
		$getEmail = $request->input("email_id");
		$getPhone = $request->input("userPhone");
		
		$arrOfData = array(
				'email'=>$getEmail,
				'phone'=>$getPhone
			);
		
		$objUser = new User();
		$objUser->updateUser($getId,$arrOfData);
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record updated successfully.');
		return redirect('admin/users/view_profile?id='.$getId);
	}
	
	public function changePassword(Request $request)
	{
		$getId = $request->input("txtPwdId");
		$newPassowrd = $request->input("new_password");
		
		$finPassword = password_hash($newPassowrd, PASSWORD_DEFAULT);
		
		$arrOfData = array(
				'password'=>$finPassword
			);
		
		$objUser = new User();
		$objUser->updateUser($getId,$arrOfData);
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Password has been updated successfully.');
		return redirect('admin/users/view_profile?id='.$getId);
	}
	
	public function updatePackageStatus(Request $request)
	{
		$getId = $request->input("id");
		$packageStatus = $request->input("isChecked");
		
		$arrOfData = array(
				'auto_renew_seek_package'=>$packageStatus
		);
		
		$objUser = new User();
		$objUser->updateUser($getId,$arrOfData);
		
		if($packageStatus==1)
		{
			$log_comment = 'enabled by admin';
		}
		else
		{
			$log_comment = 'disabled by admin';
		}
		
		$objLogs = new Seekpackagelogs();
		$objLogs->insertSeekPackageLog($getId, $packageStatus, $log_comment);
		
		echo 1;
		exit;
	}
	
	public function updatePropertyHunting(Request $request)
	{
		$getId = $request->input("id");
		$prpHuntingStatus = $request->input("isChecked");
	
		$arrOfData = array(
				'hunting_email_unsubscribe'=>$prpHuntingStatus
		);
	
		$objUser = new User();
		$objUser->updateUser($getId,$arrOfData);
		
		echo 1;
		exit;
	}
	
	public function updateBanUser(Request $request)
	{
		$getId = $request->input("id");
		$banStatus = $request->input("isChecked");
		
		$ban = 'false';
		if($banStatus==1)
		{
			$ban = 'true';
		}
		
		$arrOfData = array(
				'isBan'=>$ban
		);
		
		$objUser = new User();
		$objUser->updateUser($getId,$arrOfData);
		
		echo 1;
		exit;
	}
	
	public function seekads(Request $request)
	{
		$getId = $request->input("id");
		$objSeekPackage = new Seekads();
		$arrOfSeekProperties = $objSeekPackage->getUserSeekProperty($getId);
		
		$html = '';
		if(!empty($arrOfSeekProperties) && count($arrOfSeekProperties)>0)
		{
			$html .= '<table border="0" class="table">';
			$html .= '<thead>';
			$html .= '<tr>';
			$html .= '<th>Title</th>';
			$html .= '<th>Area</th>';
			$html .= '<th>Date Published</th>';
			$html .= '<th>Edit</th>';
			$html .= '<th>View</th>';
			$html .= '</tr>';
			$html .= '</thead>';
			
			$html .= '</table>';
		}
		
		return view('admin.users.view_profile',['seekProperty'=>$objSeekPackage]);
	}
}
