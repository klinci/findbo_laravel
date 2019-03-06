<?php

namespace App\Http\Controllers\AdminAuth;
use App\Area;
use App\Zipcode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.area.area');
	}
	
	public function ajaxArea(Request $request)
	{
		$objArea = new Area();
	
		$objAllArea = $objArea->getAllArea("","");
	
		$totalData = count($objAllArea);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$areas = $objArea->getAllArea($start, $limit);
		}
		else
		{
			$search = $request->input('search.value');
			$areas = $objArea->getAllArea($start, $limit);
			$totalFiltered = count($areas);
		}
	
		$data = array();
		if(!empty($areas) && count($areas)>0)
		{
			foreach($areas as $post)
			{
				$nestedData['id'] = $post->id;
				$nestedData['name'] = $post->name;
	
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
		return view('admin.area.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$postAreaName = $request->input("name");
		$postCityName = $request->input("city_name");
		$postCityZipcode = $request->input("code");
		
		$area = new Area([
				'name'=>$postAreaName
			]);
		$area->save();
		
		$areaId = $area->id;
		
		$zipcode = new Zipcode([
				'code'=>$postCityZipcode,
				'city_name'=>$postCityName,
				'area_id'=>$areaId
			]);
		$zipcode->save();
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record inserted successfully.');
		return redirect('admin/area/index');
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
