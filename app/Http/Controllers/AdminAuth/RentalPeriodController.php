<?php

namespace App\Http\Controllers\AdminAuth;
use App\Rentalperiod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class RentalPeriodController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.rental_period.rental_period');
	}
	
	public function ajaxRentalPeriod(Request $request)
	{
		$objRentalPeriod = new Rentalperiod();
	
		$objAllRentalPeriod = $objRentalPeriod->getAllRentalPeriod("","");
	
		$totalData = count($objAllRentalPeriod);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$rental_period = $objRentalPeriod->getAllRentalPeriod($start, $limit);
		}
		else
		{
			$search = $request->input('search.value');
			$rental_period = $objRentalPeriod->getAllRentalPeriod($start, $limit);
			$totalFiltered = count($areas);
		}
	
		$data = array();
		if(!empty($rental_period) && count($rental_period)>0)
		{
			foreach($rental_period as $post)
			{
				$nestedData['id'] = $post->id;
				$nestedData['name'] = $post->rental_name;
	
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
		return view("admin.rental_period.create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$postRentalName = $request->get("rental_name");
		
		$rental_period = new Rentalperiod([
				'rental_name'=>$postRentalName
				]);
		$rental_period->save();
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record inserted successfully.');
		return redirect('admin/rental_period/index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{

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

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{

	}
}
