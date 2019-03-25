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
		$price = 0;
		$location = "";

		$limit = 20;

		if($request->page) {
			$page = $request->page;
		}

		if($request->refineSubmit) {
			$page = 1;
		}

		if($request->location) {
			$location = $request->location;
		}

		if($request->sortby) {
			$sortBy = $request->sortby;
		}

		if($request->sortorder) {
			$sortOrder = $request->sortorder;
		}

		if($request->keywords) {
			$keyword = $request->keywords;
		}

		if($request->txtPrice) {
			$price = $request->txtPrice;
		}

		$getArea = '';
		$arrOfArea = array();
		if($request->area) {
			$getArea = implode(",", $request->area);
			$arrOfArea = $request->area;
		}

		$getType = '';
		$arrOfType = array();
		if($request->type) {
			$getType = implode(",",$request->type);
			$arrOfType = $request->type;
		}

		$getMinPrice = 0;
		if($request->minPrice) {
			$getMinPrice = $request->minPrice;
		}

		$getMaxPrice = 0;
		if($request->maxPrice) {
			$getMaxPrice = $request->maxPrice;
		}

		$getMinArea = '';
		if($request->minArea) {
			$getMinArea = $request->minArea;
		}

		$getMaxArea = '';
		if($request->maxArea) {
			$getMaxArea = $request->maxArea;
		}

		$getMinRooms = '';
		if($request->minRooms) {
			$getMinRooms = $request->minRooms;
		}

		$getMaxRooms = '';
		if($request->maxRooms) {
			$getMaxRooms = $request->maxRooms;
		}

		$getRental = '';
		$arrOfRental = [];
		if($request->rental) {
			$getRental = implode(",", $request->rental);
			$arrOfRental = $request->rental;
		}

		$getPets = '';
		if($request->pets) {
			$getPets = $request->pets;
		}

		$getFurnished = '';
		if($request->furnished) {
			$getFurnished = $request->furnished;
		}

		$getBusinessContract = '';
		if($request->businesscontract) {
			$getBusinessContract = $request->businesscontract;
		}

		$getGarage = '';
		if($request->garage) {
			$getGarage = $request->garage;
		}

		$getBalcony = '';
		if($request->balcony) {
			$getBalcony = $request->balcony;
		}

		$getLift = '';
		if($request->lift) {
			$getLift = $request->lift;
		}

		$getGarden = '';
		if($request->garden) {
			$getGarden = $request->garden;
		}

		$getSenior = '';
		if($request->senior) {
			$getSenior = $request->senior;
		}

		$getYouth = '';
		if($request->youth) {
			$getYouth = $request->youth;
		}

		$getHandicap = '';
		if($request->handicap) {
			$getHandicap = $request->handicap;
		}

		$offset = ($page * $limit) - $limit;

		$arrOfParams = [
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
			'handicap' => $getHandicap,
			'offset' => $offset,
			'limit' => $limit
		];

		$results =  $this->propertyQueries($arrOfParams,'getData');
		$total =  $this->propertyQueries($arrOfParams,'counter');
		$pagination = pagination($page,$limit,$total);

		$objPropertiesType = DB::table('properties')->where('type','<>','')->groupBy('type')->get();
		$objRentalPeriod = DB::table('rental_period')->orderBy('id','ASC')->get();
		$arrOfPriceRange = getPropertyPriceRange();
		$arrOfAreaRange = getPropertyAreaRange();

		return view('myads',[
			'result' => $results,
			'action' => $action,
			'keyword' => $keyword,
			'sortBy' => $sortBy,
			'sortOrder' => $sortOrder,
			'price' => $price,
			'pagination' => $pagination,
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

	private function propertyQueries($arrOfParams,$option)
	{

		$datePublished = date('Y-m-d', strtotime("-2 month"));
		$rentedDate = date('Y-m-d H:i:s',strtotime("-7 day"));

		$whereCls = 'properties.user_id='.Auth::user()->id.'';

		if(($arrOfParams["keyword"]!="" && $arrOfParams["keyword"]!="all") && (@$arrOfParams["code"]=="")) {
			$whereCls .= ' AND (properties.headline_eng LIKE "%'.$arrOfParams["keyword"].'%" OR properties.headline_dk LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.city_name LIKE "%'.$arrOfParams["keyword"].'%" OR zip_code.code LIKE "%'.$arrOfParams["keyword"].'%")';
		}

		if(@$arrOfParams["code"]!="") {
			$whereCls .= ' AND zip_code.code = "'.$arrOfParams["code"].'"';
		}

		if(@$arrOfParams["zipcode"]!="") {
			$whereCls .= ' AND properties.zip_code_id IN ('.$arrOfParams["zipcode"].')';
		}

		if(@$arrOfParams["price"]!="") {
			$whereCls .= ' AND properties.price_usd = "'.$arrOfParams["price"].'"';
		}

		if(@$arrOfParams["type"]!="") {
			$whereCls .= ' AND properties.type = "'.$arrOfParams["type"].'"';
		}

		if(@$arrOfParams["minPrice"]!="") {
			$whereCls .= ' AND properties.price_usd >= "'.$arrOfParams["minPrice"].'"';
		}

		if(@$arrOfParams["maxPrice"]!="") {
			$whereCls .= ' AND properties.price_usd <= "'.$arrOfParams["maxPrice"].'"';
		}

		if(@$arrOfParams["minArea"]!="") {
			$whereCls .= ' AND properties.size >= '.$arrOfParams["minArea"].'';
		}

		if(@$arrOfParams["maxArea"]!="") {
			$whereCls .= ' AND properties.size <= '.$arrOfParams["maxArea"].'';
		}

		if(@$arrOfParams["minRooms"]!="") {
			$whereCls .= ' AND properties.rooms >= '.$arrOfParams["minRooms"].'';
		}

		if(@$arrOfParams["maxRooms"]!="") {
			$whereCls .= ' AND properties.rooms <= '.$arrOfParams["maxRooms"].'';
		}

		if(@$arrOfParams["rental"]!="") {
			$whereCls .= ' AND properties.rental_period IN ('.$arrOfParams["rental"].')';
		}

		if(@$arrOfParams["pets"]!="") {
			$whereCls .= ' AND properties.pets_allowed="'.$arrOfParams["pets"].'"';
		}

		if(@$arrOfParams["furnished"]!="") {
			$whereCls .= ' AND properties.furnished="'.$arrOfParams["furnished"].'"';
		}

		if(@$arrOfParams["businesscontract"]!="") {
			$whereCls .= ' AND properties.business_contract="'.$arrOfParams["businesscontract"].'"';
		}

		if(@$arrOfParams["garage"]!="") {
			$whereCls .= ' AND properties.garage="'.$arrOfParams["garage"].'"';
		}

		if(@$arrOfParams["balcony"]!="") {
			$whereCls .= ' AND properties.balcony="'.$arrOfParams["balcony"].'"';
		}

		if(@$arrOfParams["lift"]!="") {
			$whereCls .= ' AND properties.lift="'.$arrOfParams["lift"].'"';
		}

		if(@$arrOfParams["garden"]!="") {
			$whereCls .= ' AND properties.garden="'.$arrOfParams["garden"].'"';
		}

		if(@$arrOfParams["senior"]!="") {
			$whereCls .= ' AND properties.seniorFriendly="'.$arrOfParams["senior"].'"';
		}

		if(@$arrOfParams["youth"]!="") {
			$whereCls .= ' AND properties.youthHousing="'.$arrOfParams["youth"].'"';
		}

		if(@$arrOfParams["handicap"]!="") {
			$whereCls .= ' AND properties.handicapFriendly="'.$arrOfParams["handicap"].'"';
		}

		if(@$arrOfParams['sortBy'] == 'date') {
			$orderBy = ' ORDER BY properties.package_type_id DESC, properties.date_published '.$arrOfParams['sort_order'];
		} else if(@$arrOfParams['sortBy']=='size') {
			$orderBy = ' ORDER BY properties.package_type_id DESC, properties.size '.$arrOfParams['sort_order'];
		} else if($arrOfParams['sortBy'] == 'price') {
			$orderBy = ' ORDER BY properties.package_type_id DESC, properties.price_usd '.$arrOfParams['sort_order'];
		}

		$data = Properties::select([
			'properties.id',
			'properties.headline_dk',
			'properties.headline_eng',
			'properties.description_dk',
			'properties.description_eng',
			'properties.thumbnail',
			'properties.price_usd',
			'properties.price_dk',
			'properties.package_type_id',
			'properties.price',
			'properties.size',
			'properties.bedrooms',
			'properties.action',
			'properties.status',
			'properties.type',
			'properties.rooms',
			'properties.is_available',
			'properties.date_published',
			'zip_code.city_name',
			'zip_code.code',
		])->join(
			'zip_code',
			'properties.zip_code_id','=',
			'zip_code.id'
		)->whereRaw($whereCls.$orderBy);

		if($option == 'getData') {
			return $data->offset($arrOfParams['offset'])->limit($arrOfParams['limit'])->get();
		}
		return $data->count();
	}

}
