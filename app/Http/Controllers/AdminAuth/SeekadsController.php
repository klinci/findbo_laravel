<?php

namespace App\Http\Controllers\AdminAuth;

use App\Seekads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SeekadsController extends Controller
{
	public function index(Request $request)
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
		
		return view('admin.seekads.seekads',['keyword'=>$keyword, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'status'=>$status,'propertyId'=>$propertyId]);
	}

	public function ajaxSeekads(Request $request)
	{
		$keyword = $request->input("keyword");
		$fromDate = $request->input("fromDate");
		$toDate = $request->input("toDate");
		$status = $request->input("status");
		$pid = $request->input("pid");
	
		$objProperty = new Seekads();
	
		$objAllProperties = $objProperty->getAllSeekProperty("","","",$keyword,$fromDate,$toDate,$status,$pid);
	
		$totalData = count($objAllProperties);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$properties = $objProperty->getAllSeekProperty($start, $limit, "", $keyword,$fromDate,$toDate,$status,$pid);
		}
		else
		{
			$search = $request->input('search.value');
			$properties = $objProperty->getAllSeekProperty($start, $limit, $search, $keyword,$fromDate,$toDate,$status,$pid);
			$totalFiltered = count($properties);
		}
	
		$data = array();
		if(!empty($properties) && count($properties)>0)
		{
			foreach($properties as $post)
			{
				$nestedData['checkboxes'] = '<input type="checkbox" name="chkProperty['.$post->id.']" class="chkProperties" value="'.$post->id.'" />';
				$nestedData['property_id'] = $post->id;
				$nestedData['property_name'] = $post->title;
				$nestedData['area_name'] = $post->name;
				$nestedData['owner'] = $post->fname.' '.$post->lname;
				$nestedData['date_added'] = $post->date;
				if($post->is_active==1)
				{
					$nestedData['inactivate_activate'] = 'Active';
				}
				else
				{
					$nestedData['inactivate_activate'] = 'Inactive';
				}
				
				$edit = '<a href="#"><i class="fa fa-pencil-square-o"></i></a>';
				$externalLink = '<a href="#" target="_blank"><i class="fa fa-external-link"></i>';
				$userProfile = '<a href="#"><i class="fa fa-file-text-o"></i></a>';
	
				$nestedData['action'] = $edit.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$externalLink.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
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
	
	public function deleteProperties(Request $request)
	{
		$keyboard = $request->input('kw');
		$fromDate = $request->input('fd');
		$toDate = $request->input('td');
		$status = $request->input('sts');
		$propertyId = $request->input('prt');
		
		$postPrp = $request->input('chkProperty');
		
		$objProperty = new Seekads();
		if(!empty($postPrp) && count($postPrp)>0)
		{
			foreach($postPrp as $property)
			{
				$objProperty->deleteProperty($property);
			}
		}
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record deleted successfully.');
		return redirect('admin/seekads/index?txtKeyword='.$keyboard.'&txtFromDate='.$fromDate.'&txtToDate='.$toDate.'&cmbStatus='.$status.'&txtPid='.$propertyId.'&btnSubmit=');
	}
}
