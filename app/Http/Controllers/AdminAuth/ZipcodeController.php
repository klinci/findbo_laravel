<?php

namespace App\Http\Controllers\AdminAuth;
use App\Area;
use App\Zipcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZipcodeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.zipcode.zipcode');
	}
	
	public function ajaxZipcode(Request $request)
	{
		$objZipcode = new Zipcode();
	
		$objAllZipcode = $objZipcode->getAllZipcode("","");
	
		$totalData = count($objAllZipcode);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$zipcodes = $objZipcode->getAllZipcode($start, $limit);
		}
		else
		{
			$search = $request->input('search.value');
			$zipcodes = $objZipcode->getAllZipcode($start, $limit);
			$totalFiltered = count($zipcodes);
		}
	
		$data = array();
		if(!empty($zipcodes) && count($zipcodes)>0)
		{
			foreach($zipcodes as $post)
			{
				$nestedData['id'] = $post->id;
				$nestedData['city_name'] = $post->city_name;
				$nestedData['code'] = $post->code;
				$nestedData['area_name'] = $post->name;
	
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$areas = Area::all('id', 'name');
		
		return view('admin.zipcode.create',['areas'=>$areas]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$postCityName = $request->input("city_name");
		$postCode = $request->input("code");
		$postAreaId = $request->input("area_id");
		
		$zipcode = new Zipcode([
				'city_name'=>$postCityName,
				'code'=>$postCode,
				'area_id'=>$postAreaId
			]);
		$zipcode->save();
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record inserted successfully.');
		return redirect('admin/zipcode/index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
