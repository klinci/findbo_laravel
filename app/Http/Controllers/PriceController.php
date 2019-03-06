<?php

namespace App\Http\Controllers;

use App\SeekerPackages;

use Illuminate\Http\Request;

class PriceController extends Controller
{
	public function index()
	{
		$green_pack_info = SeekerPackages::find(1);
		$blue_pack_info = SeekerPackages::find(2);
		
		return view('price',[
			'green_pack_info' => $green_pack_info,
			'blue_pack_info' => $blue_pack_info
		]);
	}
}
