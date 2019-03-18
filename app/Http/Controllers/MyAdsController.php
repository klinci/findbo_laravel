<?php

namespace App\Http\Controllers;

use Auth;
use App\Properties;
use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MyAdsController extends Controller
{

	public function __construct() {
		$this->middleware('auth');
		$this->middleware('landlord')->only(['index']);
	}

	public function index(Request $request)
	{
		$loggedInUserId = Auth::user()->id;

		$keyword = "all";
		$page = 1;
		$sortBy = "date";
		$sortOrder = "desc";
		$action = "rent";
		$price = "";
		$location = "";

		$limit=10;

		if($request->input('page')) {
			$page = $request->input('page');
		}

		if($request->input('refineSubmit')) {
			$page=1;
		}

		if($request->input('location')) {
			$location = $request->input('location');
		}

		if($request->input('sortby')) {
			$sortBy = $request->input('sortby');
		}

		if($request->input('sortorder')) {
			$sortOrder = $request->input('sortorder');
		}

		if($request->input('keywords')) {
			$keyword=$request->input('keywords');
		}

		if($request->input('txtPrice')) {
			$price = $request->input('txtPrice');
		}

		$getArea = '';
		$arrOfArea = array();
		if($request->input('area')) {
			$getArea = implode(",",$request->input('area'));
			$arrOfArea = $request->input('area');
		}

		$getType = '';
		$arrOfType = array();
		if($request->input('type')) {
			$getType = implode(",",$request->input('type'));
			$arrOfType = $request->input('type');
		}

		$getMinPrice = '';
		if($request->input('minPrice')) {
			$getMinPrice = $request->input('minPrice');
		}

		$getMaxPrice = '';
		if($request->input('maxPrice')) {
			$getMaxPrice = $request->input('maxPrice');
		}

		$getMinArea = '';
		if($request->input('minArea'))
		{
			$getMinArea = $request->input('minArea');
		}

		$getMaxArea = '';
		if($request->input('maxArea')) {
			$getMaxArea = $request->input('maxArea');
		}

		$getMinRooms = '';
		if($request->input('minRooms')) {
			$getMinRooms = $request->input('minRooms');
		}

		$getMaxRooms = '';
		if($request->input('maxRooms')) {
			$getMaxRooms = $request->input('maxRooms');
		}

		$getRental = '';
		$arrOfRental = array();
		if($request->input('rental')) {
			$getRental = implode(",",$request->input('rental'));
			$arrOfRental = $request->input('rental');
		}


		$getPets = '';
		if($request->input('pets')) {
			$getPets = $request->input('pets');
		}

		$getFurnished = '';
		if($request->input('furnished')) {
			$getFurnished = $request->input('furnished');
		}

		$getBusinessContract = '';
		if($request->input('businesscontract')) {
			$getBusinessContract = $request->input('businesscontract');
		}

		$getGarage = '';
		if($request->input('garage')) {
			$getGarage = $request->input('garage');
		}

		$getBalcony = '';
		if($request->input('balcony')) {
			$getBalcony = $request->input('balcony');
		}

		$getLift = '';
		if($request->input('lift')) {
			$getLift = $request->input('lift');
		}

		$getGarden = '';
		if($request->input('garden')) {
			$getGarden = $request->input('garden');
		}

		$getSenior = '';
		if($request->input('senior')) {
			$getSenior = $request->input('senior');
		}

		$getYouth = '';
		if($request->input('youth')) {
			$getYouth = $request->input('youth');
		}

		$getHandicap = '';
		if($request->input('handicap')) {
			$getHandicap = $request->input('handicap');
		}

		$arrOfParams = array(
				'keyword' => $keyword,
				'area' => $getArea,
				'sortBy' => $sortBy,
				'sort_order' => $sortOrder,
				'price' => $price,
				'type' => $getType,
				'minPrice' => $getMinPrice,
				'maxPrice' => $getMaxPrice,
				'minArea' => $getMinArea,
				'maxArea' => $getMaxArea,
				'minRooms' => $getMinRooms,
				'maxRooms' => $getMaxRooms,
				'rental' => $getRental,
				'pets' => $getPets,
				'furnished' => $getFurnished,
				'businesscontract' => $getBusinessContract,
				'garage' => $getGarage,
				'balcony' => $getBalcony,
				'lift' => $getLift,
				'garden' => $getGarden,
				'senior' => $getSenior,
				'youth' => $getYouth,
				'handicap' => $getHandicap
		);

		$objProperties = new Properties();
		$totalResult = $objProperties->getSearchProperties(0,0,$arrOfParams,$loggedInUserId);

		$per_page = 10;
		$pagination = pagination($page,$per_page,count($totalResult));

		/* echo '<pre>';
		print_r($pagination);
		exit; */

		$result = $objProperties->getSearchProperties($page,$limit,$arrOfParams,$loggedInUserId);

		$objAreas = DB::table('areas')
					->orderBy('id','asc')
					->get();

		$objPropertiesType = DB::table('properties')
							->where('type','<>','')
							->groupBy('type')
							->get();

		$objRentalPeriod = DB::table('rental_period')
							->orderBy('id','ASC')
							->get();

		$arrOfPriceRange = getPropertyPriceRange();
		$arrOfAreaRange = getPropertyAreaRange();

		/* echo $page;
		exit; */


		return view('myads',[
			'result' => $result,
			'action' => $action,
			'keyword' => $keyword,
			'sortBy' => $sortBy,
			'sortOrder' => $sortOrder,
			'price' => $price,
			'pagination' => $pagination,
			'objAreas' => $objAreas,
			'objPropertiesType' => $objPropertiesType,
			'priceRange' => $arrOfPriceRange,
			'areaRange' => $arrOfAreaRange,
			'objRentalPeriod' => $objRentalPeriod,
			'arrOfArea' => $arrOfArea,
			'arrOfType' => $arrOfType,
			'minprice' => $getMinPrice,
			'maxprice' => $getMaxPrice,
			'minarea' => $getMinArea,
			'maxarea' => $getMaxArea,
			'minrooms' => $getMinRooms,
			'getMaxRooms' => $getMaxRooms,
			'arrOfRental' => $arrOfRental,
			'pets' => $getPets,
			'furnished' => $getFurnished,
			'businessContract' => $getBusinessContract,
			'garage' => $getGarage,
			'balcony' => $getBalcony,
			'lift' => $getLift,
			'garden' => $getGarden,
			'senior' => $getSenior,
			'youth' => $getYouth,
			'handicap' => $getHandicap,
			'page' => $page
		]);

	}
}
