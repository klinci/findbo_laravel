<?php

namespace App\Http\Controllers\AdminAuth;
use Illuminate\Support\Facades\Storage;

use App\Properties;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{

	public function allProperties(Request $request)
	{
		$keyword = $fromDate = $toDate = $status = $propertyId = "";
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
		if($request->input("txtPid"))
		{
			$propertyId = $request->input("txtPid");
		}
		
		return view('admin.properties.allproperties',['keyword'=>$keyword, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'status'=>$status,'propertyId'=>$propertyId]);
	}

	public function ajaxAllProperties(Request $request)
	{
		/* print_r($request->all());
		 exit; */
		
		$keyword = $request->input("keyword");
		$fromDate = $request->input("fromDate");
		$toDate = $request->input("toDate");
		$status = $request->input("status");
		$pid = $request->input("pid");
		
		$objProperty = new Properties();
		
		$objAllProperties = $objProperty->getAllProperties("","","",$keyword,$fromDate,$toDate,$status,$pid);
		
		$totalData = count($objAllProperties);
		$totalFiltered = $totalData;
		
		$limit = $request->input('length');
		$start = $request->input('start');
		
		if(empty($request->input('search.value')))
		{
			$properties = $objProperty->getAllProperties($start, $limit, "", $keyword,$fromDate,$toDate,$status,$pid);
		}
		else
		{
			$search = $request->input('search.value');
			$properties = $objProperty->getAllProperties($start, $limit, $search, $keyword,$fromDate,$toDate,$status,$pid);
			$totalFiltered = count($properties);
		}
		
		$data = array();
		if(!empty($properties) && count($properties)>0)
		{
			foreach($properties as $post)
			{
				if($post->prop_url!="")
				{
					$propertyUrl = $post->prop_url;
				}
				else
				{
					$propertyUrl = $post->property_url;
				}

				$nestedData['checkboxes'] = '<input type="checkbox" name="chkProperty['.$post->id.']" class="chkProperties" value="'.$post->id.'" />';
				$nestedData['property_id'] = $post->id;
				$nestedData['property_name'] = $post->headline_dk;
				if($post->prop_site_name=='findbo')
				{
					$nestedData['imported_from'] = '';
				}
				else
				{
					if($propertyUrl!="")
					{
						$nestedData['imported_from'] = '<a href="'.$propertyUrl.'" style="color: #1C91D0;" target="_blank"><i class="fa fa-external-link"></i> '.$post->prop_site_name.'</a>';
					}
					else
					{
						$nestedData['imported_from'] = $post->prop_site_name;
					}
				}
				
				$nestedData['owner'] = $post->fname.' '.$post->lname;
				$nestedData['date_added'] = $post->date_published;
				if($post->status==1)
				{
					$nestedData['inactivate_activate'] = '<a href="'.url('admin/properties/updatestatus?id='.$post->id.'&action=inactivate&kw='.$keyword.'&fd='.$fromDate.'&td='.$toDate.'&sts='.$status.'&prt='.$pid.'&btnSubmit=').'"> Inactivate <i class="fa fa-eye-slash"></i></a>';
				}
				else if($post->status==3)
				{
					$nestedData['inactivate_activate'] = '<a href="'.url('admin/properties/updatestatus?id='.$post->id.'&action=activate&kw='.$keyword.'&fd='.$fromDate.'&td='.$toDate.'&sts='.$status.'&prt='.$pid.'&btnSubmit=').'"> Activate <i class="fa fa-eye-slash"></i></a>';
				}
				else
				{
					$nestedData['inactivate_activate'] = '';
				}
				$edit = '<a href="'.url('property_edit/'.$post->id).'" target="_blank"><i class="fa fa-pencil-square-o"></i></a>';
				$externalLink = '<a href="'.url('property_detail/'.$post->id).'" target="_blank"><i class="fa fa-external-link"></i>';
				$userProfile = '<a href="'.url("admin/users/view_profile?id=".$post->user_id).'" target="_blank"><i class="fa fa-file-text-o"></i></a>';
				
				$featuredProperty = '';
				if($post->is_featured_property==1)
				{
					$featuredProperty = '<a href="'.url('admin/properties/updatefeaturedstatus?id='.$post->id.'&featured=0&kw='.$keyword.'&fd='.$fromDate.'&td='.$toDate.'&sts='.$status.'&prt='.$pid.'&btnSubmit=').'"><img src="'.asset('public/admin/images/unchecked_box.png').'"></a>';
				}
				if(empty($post->is_featured_property))
				{
					$featuredProperty = '<a href="'.url('admin/properties/updatefeaturedstatus?id='.$post->id.'&featured=1&kw='.$keyword.'&fd='.$fromDate.'&td='.$toDate.'&sts='.$status.'&prt='.$pid.'&btnSubmit=').'"><img src="'.asset('public/admin/images/checked_box.png').'"></a>';
				}
				
				$nestedData['action'] = $edit.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
										$externalLink.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
										$userProfile.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
										$featuredProperty;

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


	public function deleteProperties(Request $request) {
		$keyboard = $request->input('kw');
		$fromDate = $request->input('fd');
		$toDate = $request->input('td');
		$status = $request->input('sts');
		$propertyId = $request->input('prt');
		
		$postPrp = $request->input('chkProperty');
		
		$objProperty = new Properties();
		foreach($postPrp as $property) {
			$objProperty->deleteProperty($property);
		}
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record deleted successfully.');
		return redirect('admin/properties/allproperties?txtKeyword='.$keyboard.'&txtFromDate='.$fromDate.'&txtToDate='.$toDate.'&cmbStatus='.$status.'&txtPid='.$propertyId.'&btnSubmit=');
	}
	
	public function updateStatus(Request $request)
	{
		if($request->id > 0 && $request->action!="")
		{
			$keyboard = $request->input('kw');
			$fromDate = $request->input('fd');
			$toDate = $request->input('td');
			$status = $request->input('sts');
			$pid = $request->input('prt');
			
			$propertyId = $request->id;
			$action = $request->action;
			
			$objProperty = new Properties();
			$objProperty->updatePropertyStatus($propertyId,$action);
			
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record updated successfully.');
			return redirect('admin/properties/allproperties?txtKeyword='.$keyboard.'&txtFromDate='.$fromDate.'&txtToDate='.$toDate.'&cmbStatus='.$status.'&txtPid='.$pid.'&btnSubmit=');
		}
	}
	
	public function updateFeaturedStatus(Request $request)
	{
		if($request->id > 0)
		{
			$keyboard = $request->input('kw');
			$fromDate = $request->input('fd');
			$toDate = $request->input('td');
			$status = $request->input('sts');
			$pid = $request->input('prt');
				
			$propertyId = $request->id;
			$featured = $request->featured;
			
			$objProperty = new Properties();
			$objProperty->updatePropertyFeatured($propertyId,$featured);
				
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record updated successfully.');
			return redirect('admin/properties/allproperties?txtKeyword='.$keyboard.'&txtFromDate='.$fromDate.'&txtToDate='.$toDate.'&cmbStatus='.$status.'&txtPid='.$pid.'&btnSubmit=');
		}
	}
	
	
	public function pendingProperties()
	{
		$objProperty = new Properties();
		$objPendingProperties = $objProperty->getPendingProperties("","","");
		$countOfPendingPrp = count($objPendingProperties);
		return view('admin.properties.pendingproperties',['count'=>$countOfPendingPrp]);
	}
	
	
	public function ajaxPendingProperties(Request $request)
	{
		/* print_r($request->all());
		 exit; */
	
		$objProperty = new Properties();
	
		$objPendingProperties = $objProperty->getPendingProperties("","","");
	
		$totalData = count($objPendingProperties);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$properties = $objProperty->getPendingProperties($start, $limit, "");
		}
		else
		{
			$search = $request->input('search.value');
			$properties = $objProperty->getPendingProperties($start, $limit, $search);
			$totalFiltered = count($properties);
		}
	
		$data = array();
		if(!empty($properties) && count($properties)>0)
		{
			foreach($properties as $post)
			{
				if($post->prop_url!="")
				{
					$propertyUrl = $post->prop_url;
				}
				else
				{
					$propertyUrl = $post->property_url;
				}
	
				$nestedData['checkboxes'] = '<input type="checkbox" name="chkProperty['.$post->id.']" class="chkProperties" value="'.$post->id.'" />';
				$nestedData['checkboxes_approve'] = '<input type="checkbox" name="chkPropertyApprove['.$post->id.']" class="chkPropertiesApprove" value="'.$post->id.'" />';
				$nestedData['owner'] = $post->fname.' '.$post->lname;
				$nestedData['date_added'] = $post->date_published;
				
				if($post->prop_site_name=='findbo')
				{
					$nestedData['imported_from'] = '';
				}
				else
				{
					if($propertyUrl!="")
					{
						$nestedData['imported_from'] = '<a href="'.$propertyUrl.'" style="color: #1C91D0;" target="_blank"><i class="fa fa-external-link"></i> '.$post->prop_site_name.'</a>';
					}
					else
					{
						$nestedData['imported_from'] = $post->prop_site_name;
					}
				}
				
				$nestedData['property_id'] = $post->id;
				$nestedData['property_name'] = $post->headline_dk;
				
				if($propertyUrl!="")
				{
					$nestedData['property_url'] = '<a href="'.$propertyUrl.'" style="color: #1C91D0;word-wrap: break-word;white-space: pre-wrap;" target="_blank"> '.$propertyUrl.'</a>';
				}
				else
				{
					$nestedData['property_url'] = '';
				}
				
				$approve = '<a href="'.url('admin/properties/makeitapprove?id='.$post->id).'"><i class="fa fa-check"></i></a>';
				$externalLink = '<a href="'.url('property_detail/'.$post->id).'" target="_blank"><i class="fa fa-external-link"></i>';
				$rejected = '<a href="'.url('admin/properties/makeitreject?id='.$post->id).'"><i class="fa fa-times"></i></a>';
				$userProfile = '<a href="'.url("admin/users/view_profile?id=".$post->user_id).'" target="_blank"><i class="fa fa-file-text-o"></i></a>';
	
				$nestedData['action'] = $externalLink.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$approve.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$rejected.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$userProfile;
	
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
	
	public function updatePendingProperties(Request $request)
	{
		$objProperty = new Properties();
		
		if($request->input("btnDelete")=="delete")
		{
			$arrOfPrpId = $request->input("chkProperty");
			
			if(!empty($arrOfPrpId) && count($arrOfPrpId)>0)
			{
				foreach($arrOfPrpId as $propertyId)
				{
					$objProperty->deleteProperty($propertyId);
				}
			}
			
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record deleted successfully.');
			return redirect('admin/properties/pendingproperties');
		}
		
		if($request->input("btnApprove")=="approve")
		{
			$arrOfPrpId = $request->input("chkPropertyApprove");
				
			if(!empty($arrOfPrpId) && count($arrOfPrpId)>0)
			{
				foreach($arrOfPrpId as $propertyId)
				{
					$objProperty->updatePropertyStatus($propertyId,'activate');
				}
			}
				
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record updated successfully.');
			return redirect('admin/properties/pendingproperties');
		}
	}
	
	public function makeItApprove(Request $request)
	{
		if($request->input('id')>0)
		{
			$objProperty = new Properties();
			$objProperty->updatePropertyStatus($request->input('id'),'activate');
			
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record updated successfully.');
			
			if($request->input('from')=='rejected')
			{
				return redirect('admin/properties/rejectedproperties');
			}
			else
			{
				return redirect('admin/properties/pendingproperties');
			}
		}
	}
	
	public function makeItReject(Request $request)
	{
		if($request->input('id')>0)
		{
			$objProperty = new Properties();
			$objProperty->updatePropertyStatus($request->input('id'),'rejected');
				
			$request->session()->flash('message.level', 'success');
			$request->session()->flash('message.content', 'Record updated successfully.');
			return redirect('admin/properties/pendingproperties');
		}
	}
	
	
	public function rejectedProperties()
	{
		$objProperty = new Properties();
		$objRejectedProperties = $objProperty->getRejectedProperties("","","");
		$countOfRejectedPrp = count($objRejectedProperties);
		return view('admin.properties.rejectedproperties',['count'=>$countOfRejectedPrp]);
	}
	
	
	public function ajaxRejectedProperties(Request $request)
	{
		/* print_r($request->all());
		 exit; */
	
		$objProperty = new Properties();
	
		$objRejectedProperties = $objProperty->getRejectedProperties("","","");
	
		$totalData = count($objRejectedProperties);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$properties = $objProperty->getRejectedProperties($start, $limit, "");
		}
		else
		{
			$search = $request->input('search.value');
			$properties = $objProperty->getRejectedProperties($start, $limit, $search);
			$totalFiltered = count($properties);
		}
	
		$data = array();
		if(!empty($properties) && count($properties)>0)
		{
			foreach($properties as $post)
			{
				$nestedData['property_id'] = $post->id;
				$nestedData['property_name'] = $post->headline_dk;
				$nestedData['owner'] = $post->fname.' '.$post->lname;
				$nestedData['date_added'] = $post->date_published;
	
				$approve = '<a href="'.url('admin/properties/makeitapprove?id='.$post->id.'&from=rejected').'"><i class="fa fa-check"></i></a>';
				$externalLink = '<a href="'.url('property_detail/'.$post->id).'" target="_blank"><i class="fa fa-external-link"></i>';
				$userProfile = '<a href="'.url("admin/users/view_profile?id=".$post->user_id).'" target="_blank"><i class="fa fa-file-text-o"></i></a>';
	
				$nestedData['action'] = $externalLink.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$approve.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$userProfile;
	
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
}
