<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;

use App\Wishlist;

use App\Mail\PropertyAdReport;

use App\Mail\PropertyPurchase;

use App\PropertyPackageHistory;

use App\Transactions;

use App\Zipcode;

use App\Rentalperiod;

use App\Area;

use phpDocumentor\Reflection\DocBlock\Tags\Property;
use App\Services\MailService;

use App\User;
use Auth;
use App\Properties;
use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PropertyController extends Controller
{
	public function __construct() {
		$this->middleware('auth')->except(['index', 'sendReportEmail', 'propertyDetail', 'noProperty']);
		$this->middleware('active')->only(['addProperty', 'insertProperty']);
		$this->middleware('approved')->only(['addProperty', 'insertProperty']);
	}

	public function index(Request $request)
	{
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

		$getCode = '';
		if($request->code) {
			$getCode = $request->code;
		}

		$getZipcode = '';
		$arrOfZip = array();
		if($request->zip) {
			$getZipcode = implode(",",$request->zip);
			$arrOfZip = $request->input('zip');
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
		$objZipcode = DB::table('zip_code')->where('is_display_on_search', 1)->orderBy('city_name','ASC')->get();
		$objPropertiesType = DB::table('properties')->where('type','<>','')->groupBy('type')->get();
		$objRentalPeriod = DB::table('rental_period')->orderBy('id','ASC')->get();
		$arrOfPriceRange = getPropertyPriceRange();
		$arrOfAreaRange = getPropertyAreaRange();

		return view('property', [
			'result' => $results,
			'action' => $action,
			'keyword' => $keyword,
			'sortBy' => $sortBy,
			'sortOrder' =>$sortOrder,
			'price' => $price,
			'pagination' => $pagination,
			'objPropertiesType' => $objPropertiesType,
			'priceRange' => $arrOfPriceRange,
			'areaRange' => $arrOfAreaRange,
			'objRentalPeriod' => $objRentalPeriod,
			'arrOfZip' => $arrOfZip,
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
			'page' => $page,
			'code' => $getCode,
			'objZipcode' => $objZipcode
		]);
	}

	private function propertyQueries($arrOfParams,$option)
	{

		$datePublished = date('Y-m-d', strtotime("-2 month"));
		$rentedDate = date('Y-m-d H:i:s',strtotime("-7 day"));

		$whereCls = "
			(
				(properties.is_available=1) OR ((properties.is_available=0) AND (DATE(properties.rented_date) >= '".$rentedDate."') AND (properties.status=1))
			)
		";

		if($arrOfParams["keyword"] != "all") {
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

		if(@$arrOfParams["businesscontract"] != "") {
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

	public function propertyDetail($id,$slugTitle = null)
	{

		$objProperty = Properties::select([
			'properties.*',
			'users.email as user_email',
			'zip_code.id as zip_code_id',
			'zip_code.code',
			'zip_code.city_name',
			'areas.name as area_name'
		])->leftJoin(
			'zip_code',
			'properties.zip_code_id','=',
			'zip_code.id'
		)->leftJoin(
			'users',
			'properties.user_id','=',
			'users.id'
		)->leftJoin(
			'areas',
			'properties.area_id','=',
			'areas.id'
		)->where('properties.id', $id)->first();

		if(!$objProperty) {
			return redirect(route('home.properties'));
		}

		$headline = str_slug($objProperty->headline_eng,'-');
		if(empty($headline) && is_null($headline)) {
			$headline = str_slug($objProperty->headline_dk,'-');
		}

		if(is_null($slugTitle)) {
			return redirect()->route('property_detail.show.withId',[
				$objProperty->id,
				$headline,
			]);
		}

		$objGallery = Gallery::getGalleryByPropertyId($id);

		$active_pack_id = 0;
		$objWishlist = [];

		if(Auth::check()) {
			$userId = Auth::user()->id;

			if($userId) {
				$objUser = User::find($userId);

				$today_date = date('Y-m-d H:i:s');

				if($objUser->seek_package_id != 0) {
					if(strtotime($objUser->package_expiry_date) > strtotime($today_date)) {
						$active_pack_id = $objUser->seek_package_id;
					} else {
						$active_pack_id = $objUser->seek_package_id;
					}
				}
			}

			$objWishlist = DB::table('wishlist')->where('property_fk','=',$objProperty->id)->where('user_id','=',Auth::user()->id)->first();
		}

		$relatedProperty = Properties::getRelatedProperty($objProperty->zip_code_id,$id);

		$isAdmin = '';
		if(Auth::check()) {
			$objUser = User::find(Auth::user()->id);
			$isAdmin = $objUser->isAdmin;
		}

		return view('property_detail', [
			'objProperty' => $objProperty,
			'objGallery' => $objGallery,
			'active_pack_id' => $active_pack_id,
			'objWishlist' => $objWishlist,
			'relatedProperty' => $relatedProperty,
			'isAdmin' => $isAdmin
		]);

	}

	public function noProperty()
	{
		return view('no_property');
	}

	public function addProperty()
	{
		$objArea = Area::all();
		$objRentalPeriod = Rentalperiod::all();

		$objZipCode = Zipcode::all();

		return view('add_property',['objArea'=>$objArea,'objRentalPeriod'=>$objRentalPeriod,'objZipCode'=>$objZipCode]);
	}

	public function map(Request $request)
	{
		$keyword="all";
		$page=1;
		$sortBy="date";
		$sortOrder="desc";
		$action="rent";
		$price="";
		$location = "";
		$getCode = "";

		$limit=10;

		if($request->input('page'))
		{
			$page=$request->input('page');
		}

		if($request->input('refineSubmit'))
		{
			$page=1;
		}

		if($request->input('code'))
		{
			$getCode = $request->input('code');
		}

		if($request->input('location'))
		{
			$location = $request->input('location');
		}

		if($request->input('sortby'))
		{
			$sortBy = $request->input('sortby');
		}

		if($request->input('sortorder'))
		{
			$sortOrder = $request->input('sortorder');
		}

		if($request->input('keywords'))
		{
			$keyword=$request->input('keywords');
		}

		if($request->input('txtPrice'))
		{
			$price = $request->input('txtPrice');
		}

		$getType = '';
		$arrOfType = array();
		if($request->input('type'))
		{
			$getType = implode(",",$request->input('type'));
			$arrOfType = $request->input('type');
		}

		$getMinPrice = '';
		if($request->input('minPrice'))
		{
			$getMinPrice = $request->input('minPrice');
		}

		$getMaxPrice = '';
		if($request->input('maxPrice'))
		{
			$getMaxPrice = $request->input('maxPrice');
		}

		$getMinArea = '';
		if($request->input('minArea'))
		{
			$getMinArea = $request->input('minArea');
		}

		$getMaxArea = '';
		if($request->input('maxArea'))
		{
			$getMaxArea = $request->input('maxArea');
		}

		$getMinRooms = '';
		if($request->input('minRooms'))
		{
			$getMinRooms = $request->input('minRooms');
		}

		$getMaxRooms = '';
		if($request->input('maxRooms'))
		{
			$getMaxRooms = $request->input('maxRooms');
		}

		$arrOfParams = array(
				'code' => $getCode,
				'keyword' => $keyword,
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
		);


		$objProperties = new Properties();

		$result = $objProperties->getSearchProperties(0,0,$arrOfParams);

		$objPropertiesType = DB::table('properties')
			->where('type','<>','')
			->groupBy('type')
			->get();

		$arrOfPriceRange = getPropertyPriceRange();
		$arrOfAreaRange = getPropertyAreaRange();

		return view('map',['result'=>$result,'action'=>$action,'keyword'=>$keyword,'sortBy'=>$sortBy,'sortOrder'=>$sortOrder,
				'price'=>$price,'objPropertiesType'=>$objPropertiesType,
				'priceRange'=>$arrOfPriceRange,
				'arrOfType'=>$arrOfType,'minprice'=>$getMinPrice,'maxprice'=>$getMaxPrice,
				'minarea'=>$getMinArea, 'maxarea'=>$getMaxArea, 'minrooms'=>$getMinRooms,'getMaxRooms'=>$getMaxRooms,
				'areaRange'=>$arrOfAreaRange,'code'=>$getCode
			]);
	}

	public function insertProperty(Request $request)
	{

		$headline_dk = $request->headline_dk;
		$headline_eng = $request->headline_eng;
		$text_dk = $request->text_dk; // in the database description_dk
		$text_eng = $request->text_eng; // in the database description_eng
		$areas = $request->areas; // area_id in database
		$zipcode = $request->city; // zip_code_id in database
		$address = $request->address; // address in database
		$location1 = $request->location1; // location1 in database
		$location2 = $request->location2; // location2 in database
		$housenum = $request->housenum; // housenum in database
		$position = $request->position;
		$floor = $request->floor;
		$propertyPosition = "$position, $floor"; // floor in database
		$company_name = $request->company_name;
		$country1 = $request->country1;
		$number1 = $request->number1;
		$phone1 = "$country1$number1"; // phonenumber1
		$number2 = $request->number2;
		$country2 = $request->country2;
		$phone2 = "$country2.$number2"; // phonenumber2
		$vacant = $request->vacant; // vacant in database
		$action = $request->action; // action in database
		$email = $request->emailadd; // action in database
		$propertyURL = trim($request->txtURL); // action in database
		$email2 = $request->emailadd2;
		$groundarea = $request->groundarea;
		$year = $request->year;
		$payment = $request->payment;
		$gross = $request->gross;
		$net = $request->net;
		$downpayment = $request->downpayment;
		$type = $request->type;  // type in database
		$rentalperiod = $request->rentalperiod; // rentalperiod in the database
		$size = $request->size;  // size in database
		$rooms = $request->rooms; // rooms in database
		$bathroom = 0;//$_POST['bathroom'];  // bathroom in the database
		$bedroom = 0; //$_POST['bedroom'];  // bedroom in the database
		$rent = $request->rent; // price in database
		$deposit = $request->deposit;
		$depositValue = $request->depositValue;
		$totalDeposit = "DKK $depositValue"; // rentDeposit in the database
		$prepaid = $request->prepaid;
		$prepaidValue = $request->prepaidValue;
		$totalPrepaid = "$prepaid: $prepaidValue"; //prepaidRent in the database
		$expenses = 0;
		$lift = "0";
		$energy = "N/A";

		$petcommnet = $request->petcomment;
		$openHouseDate = $request->openHouseDate;
		$openHouseStartTime = $request->openHouseStartTime;
		$openHouseEndTime = $request->openHouseEndTime;
		$openHouseAddress = $request->openHouseAddress;
		$openHouseComment = $request->openHouseComment;

		if(empty($headline_eng)) {
			$headline_eng = $headline_dk;
		}

		if(empty($text_eng)) {
			$text_eng = $text_dk;
		}

		if(!empty($request->energy)) {
			$energy = $request->energy;
		}

		if(!empty($request->vacantDate)) {
			$vacantDate = $request->vacantDate;
			$vacantDate = date("Y-m-d", strtotime($vacantDate));
		} else {
			$vacantDate  = "0000-00-00";
		}

		if(!empty($request->sharefriendly)) {
			$sharefriendly = $request->sharefriendly;
		} else {
			$sharefriendly = "0";
		}

		if(!empty($request->handicapfriendly)) {
			$handicapfriendly = $request->handicapfriendly;
		} else {
			$handicapfriendly = "0";
		}

		if(!empty($request->youthhousing)) {
			$youthhousing = $request->youthhousing;
		} else {
			$youthhousing = "0";
		}

		if(!empty($request->pets)) {
			$pets = $request->pets;
		} else {
			$pets = 1;
		}

		if(!empty($request->seniorfriendly)) {
			$seniorfriendly = $request->seniorfriendly;
		} else {
			$seniorfriendly = 0;
		}

		if($request->expenses > 0) {
			$expenses = $request->expenses; // expneses in the database
		}

		if(!empty($request->openHouseDate)) {
			$openHouseDate = $request->openHouseDate;
			$openHouseDate= date("Y-m-d", strtotime($openHouseDate));
		} else {
			$openHouseDate = '0000-00-00';
		}

		if(!empty($request->openHouseStartTime)) {
			$openHouseStartTime = $request->openHouseStartTime;
		} else {
			$openHouseStartTime = "";
		}

		if(!empty($request->openHouseEndTime)) {
			$openHouseEndTime = $request->openHouseEndTime;
		} else {
			$openHouseEndTime = "";
		}

		if(!empty($request->openHouseAddress)) {
			$openHouseAddress = $request->openHouseAddress;
		} else {
			$openHouseAddress = "";
		}

		//-------------
		$openHouseComment = "";
		if(!empty($request->openHouseComment)) {
			$openHouseComment = $request->openHouseComment;
		}

		$email2 = "Not specified";
		if(!empty($request->emailadd2)) {
			$email2 = $request->emailadd2;
		}

		$balcony = "0";
		if(!empty($request->balcony)) {
			$balcony = $request->balcony;
		}

		$garage = '0';
		if(!empty($request->input('garage'))) {
			$garage = $request->input('garage');
		}

		if(!empty($request->lift)) {
			$lift = $request->lift;
		}

		$lift = "0";
		if(!empty($request->lift)) {
			$lift = $request->lift;
		}

		$parking_place = '0';
		$garden = "0";
		if(!empty($request->garden)) {
			$garden = $request->garden;
		}

		$scenic = "0";
		if(!empty($request->scenic)) {
			$scenic = $request->scenic;
		}

		$sea = "0";
		if(!empty($request->sea)) {
			$sea = $request->sea;
		}

		$nearsea = "0";
		if(!empty($request->nearsea)) {
			$nearsea = $request->nearsea;
		}

		$nearforest = "0";
		if(!empty($request->nearforest)) {
			$nearforest = $request->nearforest;
		}

		$businesscontact = "0";
		if(!empty($request->businesscontact)) {
			$businesscontact = $request->businesscontact;
		}

		$furnished = 0;
		if(!empty($request->furnished)) {
			$furnished = $request->furnished;
		}

		$basement = 0;
		if(!empty($request->basement)) {
			$basement = $request->basement;
		}

		$entryphone = 0;
		if(!empty($request->entryphone)) {
			$entryphone = $request->entryphone;
		}

		$businesscontract = "0";
		if(!empty($request->businesscontract)) {
			$businesscontract = $request->businesscontract;
		}

		$date = date("Y-m-d");
		$pack = $request->package_type_id;

		$objProperty = Properties::create([
				'package_type_id' => $pack,
				'downpayment' => $downpayment,
				'openHouseDate' => $openHouseDate,
				'openHouseStartTime' => $openHouseStartTime,
				'openHouseEndTime' => $openHouseEndTime,
				'openHouseAddress' => $openHouseAddress,
				'openHouseComment' => $openHouseComment,
				'user_id' => Auth::user()->id,
				'vacantDate' => $vacantDate,
				'company_name' => $company_name,
				'email' => $email,
				'email2' => $email2,
				'groundarea' => $groundarea,
				'year' => $year,
				'energy' => $energy,
				'payment' => $payment,
				'gross' => $gross,
				'net' => $net,
				'location1' => $location1,
				'location2' => $location2,
				'action' => $action,
				'date_published' => $date,
				'headline_dk' => $headline_dk,
				'description_dk' => $text_dk,
				'headline_eng' => $headline_eng,
				'description_eng' => $text_eng,
				'prop_seo_title'=>'',
				'area_id' => $areas,
				'zip_code_id' => $zipcode,
				'address' => $address,
				'housenum' => $housenum,
				'floor' => $propertyPosition,
				'phonenum1' => $phone1,
				'phonenum2' => $phone2,
				'vacant' => $vacant,
				'type' => $type,
				'rental_period' => $rentalperiod,
				'shareFriendly' => $sharefriendly,
				'handicapFriendly' => $handicapfriendly,
				'youthHousing' => $youthhousing,
				'seniorFriendly' => $seniorfriendly,
				'size' => $size,
				'rooms' => $rooms,
				'bathrooms' => $bathroom,
				'bedrooms' => $bedroom,
				'price' => $rent,
				'price_usd' => $rent,
				'rentDeposit' => $totalDeposit,
				'prepaidRent' => $totalPrepaid,
				'expenses' => $expenses,
				'pets_allowed' => $pets,
				'pets_comment' => $petcommnet,
				'balcony' => $balcony,
				'garage' => $garage,
				'parking_place' => $parking_place,
				'lift' => $lift,
				'garden' => $garden,
				'scenic' => $scenic,
				'sea' => $sea,
				'near_sea' => $nearsea,
				'near_forest' => $nearforest,
				'business_contact' => $businesscontact,
				'furnished' => $furnished,
				'basement' => $basement,
				'entry_phone' => $entryphone,
				'business_contract' => $businesscontract,
				'status' => 0,
				'is_available' => 1,
				'is_from_scrap' => 0,
				'prop_site_name'=>'findbo',
				'property_url' => $propertyURL
		]);

		$propertyId = $objProperty->id;
		// $imageFiles = $request->file('image_files');
		$imageFiles = $request->image_files;
		// return $imageFiles;

		if(count($imageFiles) > 0) {

			for($i = 0; $i < count($imageFiles); $i++) {

				$extension = 'jpg';
				if(strpos($imageFiles[$i], 'image/png')) {
					$extension = 'png';
				}

				$fileName = md5(uniqid());
				$path = 'images/propertyimages/';
				$filePath = public_path($path.$fileName.".".$extension);
				$xpath = @copy($imageFiles[$i], $filePath);

				if($i == 0) {
					DB::table('properties')->where('id','=',$propertyId)->update([
						'thumbnail' => $path.$fileName.".".$extension
					]);
				}

				Gallery::create([
					'path' => $path.$fileName.".".$extension,
					'property_id' => $propertyId
				]);

			}
		}

		if($objProperty) {
			$redirectTo = 'bolig_detaljer/'.$objProperty->id.'/'.str_slug($objProperty->headline_dk);
		} else {
			$redirectTo = '/';
		}

		return redirect(url($redirectTo));

	}

	public function propertyPayment($id,$pid)
	{
		if($id > 0 && $pid > 0)
		{
			$objFreePackage = DB::table('payment')
							->where('id','=',1)
							->first();

			$objGreenPackages = DB::table('payment')
							->where('id','=',2)
							->first();

			$objBluePackages = DB::table('payment')
						->where('id','=',3)
						->first();

			return view('property_payment',['id'=>$id,'pid'=>$pid, 'objFreePackage'=>$objFreePackage, 'objGreenPackages'=>$objGreenPackages, 'objBluePackages'=>$objBluePackages ]);
		}
		else
		{
			return redirect()->back();
		}
	}

	public function purchaseProperty(Request $request)
	{
		$token = $request->input('stripeToken');
		$pack = $request->input('selected_pack');
		$propertyId = $request->input('prop_id');

		$objPackage = DB::table('payment')
						->where('id','=',$pack)
						->first();

		$selected_pack_price = $objPackage->price;
		$selected_pack_days = $objPackage->duration;
		if($pack == 3)
		{
			$selected_pack_name  = $objPackage->postBlue;
		}
		else
		{
			$selected_pack_name  = $objPackage->postGreen;
		}

		include(app_path() . '/modules/Stripe/lib/Util/Set.php');
		include(app_path() . '/modules/Stripe/lib/Object.php');
		include(app_path() . '/modules/Stripe/lib/ApiResource.php');
		include(app_path() . '/modules/Stripe/lib/SingletonApiResource.php');
		include(app_path() . '/modules/Stripe/lib/Error/Base.php');

		$lib_path = app_path() . '/modules/Stripe/lib/';
		$allClasses = scandir($lib_path);
		foreach ($allClasses as $class)
		{
			if ($class == '.' || $class == '..')
				continue;

			if (is_dir($lib_path.$class))
			{	$allSubClasses = scandir($lib_path.$class);
			foreach ($allSubClasses as $subClass)
			{	if ($subClass == '.' || $subClass == '..')
				continue;

			if (!is_dir($lib_path.$class.'/'.$subClass))
				include_once $lib_path.$class.'/'.$subClass;
			}
			continue;
			}
			include_once $lib_path.$class;
		}


		\Stripe\Stripe::setApiKey("sk_live_QzQTc1EOLHMyfFYTb9AqG2Gw");	//live

		try
		{
			$charge_info = \Stripe\Charge::create(array(
					"amount" => ($selected_pack_price * 100), // amount in cents, again
					"currency" => "DKK",
					"source" => $token,
					"description" => $selected_pack_name)
			);

			if($charge_info)
			{
				$package_start_date	= date('Y-m-d H:i:s');
				$package_expiry_date= date('Y-m-d H:i:s',strtotime("+$selected_pack_days day"));

				if($charge_info->status == 'succeeded')
				{
					DB::table('properties')
						->where('id','=',$propertyId)
						->update([
							'package_type_id'=>$pack,
							'package_start_date'=>$package_start_date,
							'package_expiry_date'=>$package_expiry_date
					]);
				}

				$objTransaction = Transactions::create([
					'prop_id'=>$propertyId,
					'charge_id'=>$charge_info->id,
					'transaction_id'=>$charge_info->balance_transaction,
					'created_date'=>date('Y-m-d H:i:s',$charge_info->created),
					'status'=>$charge_info->status,
					'amount'=>floatval($charge_info->amount/100),
					'currency'=>$charge_info->currency,
					'paid'=>$charge_info->paid,
					'object_id'=>$charge_info->source->id,
					'object'=>$charge_info->source->object,
					'brand'=>$charge_info->source->brand,
					'last4'=>$charge_info->source->last4,
					'dynamic_last4'=>$charge_info->source->dynamic_last4,
					'funding'=>$charge_info->source->funding,
					'exp_month'=>$charge_info->source->exp_month,
					'exp_year'=>$charge_info->source->exp_year,
					'fingerprint'=>$charge_info->source->fingerprint,
					'name'=>$charge_info->source->name,
					'address_line1'=>$charge_info->source->address_line1,
					'address_line2'=>$charge_info->source->address_line2,
					'address_city'=>$charge_info->source->address_city,
					'address_state'=>$charge_info->source->address_state,
					'address_zip'=>$charge_info->source->address_zip,
					'address_country'=>$charge_info->source->address_country,
					'cvc_check'=>$charge_info->source->cvc_check,
					'address_line1_check'=>$charge_info->source->address_line1_check,
					'address_zip_check'=>$charge_info->source->address_zip_check,
					'failure_code'=>$charge_info->failure_code,
					'failure_message'=>$charge_info->failure_message,
					'description'=>$charge_info->description,
					'package_type_id'=>$pack,
					'metadata'=>json_encode($charge_info->metadata),
					'receipt_email'=>$charge_info->receipt_email,
					'receipt_number'=>$charge_info->receipt_number,
				]);

				$transaction_last_id = $objTransaction->id;

				PropertyPackageHistory::create([
					'prop_id'=>$propertyId,
					'user_id'=>Auth::user()->id,
					'package_type_id'=>$pack,
					'package_start_date'=>$package_start_date,
					'package_expiry_date'=>$package_expiry_date,
					'transaction_id'=>$charge_info->balance_transaction
				]);

				$to = $charge_info->source->name;
				$subject = 'FindBo - '.__('messages.email_sub_payment_processed');

				$objDemo = new \stdClass();
				$objDemo->subject = $subject;
				$objDemo->description = $charge_info->description;
				$objDemo->amount = $charge_info->amount;
				$objDemo->days = $selected_pack_days;
				$objDemo->balance_transaction = $charge_info->balance_transaction;

				Mail::to($to)->send(new PropertyPurchase($objDemo));

				return redirect(route('redirect'));
			}
		}
		catch(\Stripe\Error\Card $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_1');
		}
		catch (\Stripe\Error\InvalidRequest $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}
		catch (\Stripe\Error\Authentication $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');

		}
		catch (\Stripe\Error\ApiConnection $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');

		}
		catch (\Stripe\Error $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');

		}
		catch(Exception $e)
		{
			$error_code = $e->getHttpStatus();
			if(4 == intval($error_code/100))
				$error_message = __('messages.payment_message_2');
		}

		return view('stripe_message',['error_message'=>$error_message]);

	}

	function make_thumb($upfile, $dstfile, $new_width, $new_height, $extension)
	{
		$size = getimagesize($upfile);
		$width = $size[0];
		$height = $size[1];

		if ($width > $height)
		{
			$limiting_dim = $height;
		}
		else
		{
			$limiting_dim = $width;
		}

		switch (strtolower($extension))
		{
			case 'png':
				$src = ImageCreateFrompng($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagealphablending($dst, false);

				// turning on alpha channel information saving (to ensure the full range
				// of transparency is preserved)
				imagesavealpha($dst, true);
				$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
				imagefilledrectangle($dst, 0, 0, $new_width, $new_height, $transparent);

				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				Imagepng($dst, $dstfile);
				break;
			case 'gif':
				$src = ImageCreateFromGif($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				imagegif($dst, $dstfile);
				break;
			case 'jpeg':
			case 'jpg':
			default:
				$src = ImageCreateFromJpeg($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				imageinterlace( $dst, true);
				imagejpeg($dst, $dstfile, 100);
				break;
		}
	}

	public function editProperty($id)
	{
		$objProperty = Properties::find($id);

		if(!$objProperty) {
			return redirect()->back();
		}

		$objArea 					= Area::all();
		$objRentalPeriod 	= Rentalperiod::all();
		$objZipCode 			= Zipcode::all();
		$totalDeposit			= $objProperty->rentDeposit;
		$ar_depo 					= explode(' ',$totalDeposit);
		$depositValue 		= 0;

		if(!empty(trim($objProperty->price_usd))) {
			$price = $objProperty->price_usd;
		} else if(!empty(trim($objProperty->price_dk))) {
			$price = $objProperty->price_dk;
		} else {
			$price = $objProperty->price;
		}

		if(!isset($ar_depo[1])) {
			$depositValue = $ar_depo[1];
		}

		$deposit = $depositValue/$price;

		$totalPrepaid	= $objProperty->prepaidRent;
		$ar_prepaid = explode(':',$totalPrepaid);
		$prepaidValue = 0;

		if(!empty(trim($ar_prepaid[1]))) {
			$prepaidValue = trim($ar_prepaid[1]);
		}

		$prepaid = intval($prepaidValue/$price);
		$objGallery = DB::table("gallery")->where('property_id','=',$id)->get();
		return view('edit_property',['objArea'=>$objArea,'objRentalPeriod'=>$objRentalPeriod,'objZipCode'=>$objZipCode, 'objProperty'=>$objProperty, 'deposit'=>$deposit, 'depositValue'=>$depositValue, 'prepaid'=>$prepaid, 'prepaidValue'=>$prepaidValue,'objGallery'=>$objGallery]);
	}

	public function deletePropertyImage(Request $request)
	{
		if($request->input("id")>0)
		{
			$galleryId = $request->input("id");
			$folder_path = 'images/propertyimages/';

			//DB::table('gallery')->where('id', $request->input("id"))->delete();
			$objGallery = Gallery::find($galleryId);

			$hasThumb = false;
			$objPropertyImage = DB::table('gallery')
					->where('property_id','=',$objGallery->property_id)
					->orderBy('id','ASC')
					->get();


			if(!empty($objPropertyImage) && count($objPropertyImage)>0)
			{
				if($objPropertyImage[0]->id == $galleryId)
				{
					$hasThumb = true;
				}
			}
			if($hasThumb)
			{
				if(!empty($objPropertyImage) && count($objPropertyImage)>1)
				{
					$second_img_record = $objPropertyImage[1];

					$new_thumb_name = $folder_path . md5(rand().microtime()) .'_0_image.jpg';
					$source_image = imagecreatefromjpeg($second_img_record->path);
					$width = imagesx($source_image);
					$height = imagesy($source_image);

					$newwidth=241;
					$newheight=161;
					$tmp=imagecreatetruecolor($newwidth,$newheight);
					imagecopyresampled($tmp,$source_image,0,0,0,0,$newwidth,$newheight,$width,$height);
					imagejpeg($tmp,$new_thumb_name,90);


					DB::table('properties')
							->where('id','=',$objGallery->property_id)
							->update([
								'thumbnail'=>$new_thumb_name
							]);

				}
				else
				{
					DB::table('properties')
					->where('id','=',$objGallery->property_id)
					->update([
					'thumbnail'=>'images/propertyimages/ikke_navngivet_thumb.png'
					]);
				}
			}

			DB::table('gallery')->where('id', $galleryId)->delete();

			$objPropertyImage1 = DB::table('gallery')
				->where('property_id','=',$objGallery->property_id)
				->orderBy('id','ASC')
				->get();

			if(count($objPropertyImage1)==0)
			{
				Gallery::create([
							'property_id'=>$objGallery->property_id,
							'path'=>'images/propertyimages/ikke_navngivet_main.png'
						]);
			}

			$response = array();
			$response['status'] = 'OK';
			echo json_encode($response);
			exit;

		}
		else
		{
			$response = array();
			$response['status'] = 'no';
			echo json_encode($response);
			exit;
		}
	}

	public function updateProperty(Request $request)
	{
		$headline_dk = $request->input('headline_dk'); // In the database headline_dk
		$headline_eng = $request->input('headline_eng'); // In the database headline_eng

		if(empty($headline_eng))
		{
			$headline_eng = $headline_dk;
		}

		$text_dk = $request->input('text_dk'); // in the database description_dk

		$text_eng = $request->input('text_eng'); // in the database description_eng

		if(empty($text_eng))
		{
			$text_eng = $text_dk;
		}

		$areas = $request->input('areas'); // area_id in database
		$zipcode = $request->input('city'); // zip_code_id in database
		$address = $request->input('address'); // address in database
		$location1 = $request->input('location1'); // location1 in database
		$location2 = $request->input('location2'); // location2 in database
		$housenum = $request->input('housenum'); // housenum in database
		$position = $request->input('position');
		$floor = $request->input('floor');
		//echo '<br>===>'.$propertyPosition = "$position, $floor"; // floor in database
		$propertyPosition = $position; // floor in database

		$company_name = $request->input('company_name');
		$country1 = $request->input('country1');
		$number1 = $request->input('number1');
		//$phone1 = "$country1$number1"; // phonenumber1
		$phone1 = $request->input('phonenum1');
		$number2 = $request->input('number2');
		$country2 = $request->input('country2');
		$phone2 = "$country2$number2"; // phonenumber2
		$vacant = $request->input('vacant'); // vacant in database
		$action = $request->input('action'); // action in database

		$email = $request->input('emailadd'); // action in database
		$propertyURL = trim($request->input('txtURL')); // action in database

		$email2 = $request->input('emailadd2');
		$groundarea = $request->input('groundarea');
		$year = $request->input('year');
		if(empty($request->input('energy')))
		{
			$energy = "N/A";
		}
		else
		{
			$energy = $request->input('energy');
		}

		$payment = $request->input($_POST['payment']);
		$gross = $request->input('gross');
		$net = $request->input('net');
		$downpayment = $request->input('downpayment');

		if(!empty($request->input('vacantDate')))
		{
			$vacantDate = $request->input('vacantDate');
			$vacantDate = date("Y-m-d", strtotime($vacantDate));
		}
		else
		{
			$vacantDate  = "0000-00-00";
		}

		if(!empty($request->input('sharefriendly'))){
			$sharefriendly = $request->input('sharefriendly');
		}
		else{
			$sharefriendly = "0";
		}

		if(!empty($request->input('handicapfriendly'))){
			$handicapfriendly = $request->input('handicapfriendly');
		}
		else{
			$handicapfriendly = "0";
		}

		$type = $request->input('type');  // type in database
		$rentalperiod = $request->input('rentalperiod'); // rentalperiod in the database

		if(!empty($request->input('youthhousing'))){
			$youthhousing = $request->input('youthhousing');
		}
		else{
			$youthhousing = "0";
		}

		if(!empty($request->input('pets')))
		{
			$pets = $request->input('pets'); // pets in the database varchar yes, no, contact landowner
		}
		else
		{
			$pets = 1;
		}

		if(!empty($request->input('seniorfriendly'))){
			$seniorfriendly = $request->input('seniorfriendly'); // seniorfriendly in the database varchar yes, no, contact landowner
		}
		else
		{
			$seniorfriendly = 0;
		}

		$size = $request->input('size');  // size in database
		$rooms = $request->input('rooms'); // rooms in database
		$bathroom = 0;//$_POST['bathroom'];  // bathroom in the database
		$bedroom = 0; //$_POST['bedroom'];  // bedroom in the database
		$rent = $request->input('rent'); // price in database
		$deposit = $request->input('deposit');
		$depositValue = $request->input('depositValue');
		$totalDeposit = "DKK $depositValue"; // rentDeposit in the database
		$prepaid = $request->input('prepaid');
		$prepaidValue = $request->input('prepaidValue');
		$totalPrepaid = "$prepaid: $prepaidValue"; //prepaidRent in the database
		$expenses = 0;
		if($request->input('expenses') > 0)
		{
			$expenses = $request->input('expenses'); // expneses in the database
		}
		$petcommnet = $request->input('petcomment');
		$openHouseDate = $request->input('openHouseDate');
		$openHouseStartTime = $request->input('openHouseStartTime');
		$openHouseEndTime = $request->input('openHouseEndTime');
		$openHouseAddress = $request->input('openHouseAddress');
		$openHouseComment = $request->input('openHouseComment');



		if(!empty($request->input('openHouseDate')))
		{
			$openHouseDate = $request->input('openHouseDate');
			$openHouseDate= date("Y-m-d", strtotime($openHouseDate));
		}
		else{
			$openHouseDate = '0000-00-00';
		}

		if(!empty($request->input('openHouseStartTime')))
		{
			$openHouseStartTime = $request->input('openHouseStartTime');
		}
		else{
			$openHouseStartTime = "";
		}

		if(!empty($request->input('openHouseEndTime')))
		{
			$openHouseEndTime = $request->input('openHouseEndTime');
		}
		else
		{
			$openHouseEndTime = "";
		}

		if(!empty($request->input('openHouseAddress')))
		{
			$openHouseAddress = $request->input('openHouseAddress');
		}
		else
		{
			$openHouseAddress = "";
		}

		//-------------

		if(!empty($request->input('openHouseComment'))){
			$openHouseComment = $request->input('openHouseComment');
		}
		else{
			$openHouseComment = "";
		}

		if(!empty($request->input('emailadd2'))){
			$email2 = $request->input('emailadd2');
		}
		else{
			$email2 = "Not specified";
		}

		if(!empty($request->input('balcony'))){
			$balcony = $request->input('balcony');
		}
		else{
			$balcony = "0";
		}

		$garage = '0';
		if(!empty($request->input('garage')))
		{
			$garage = $request->input('garage');
		}

		if(!empty($request->input('lift')))
		{
			$lift = $request->input('lift');
		}
		else
		{
			$lift = "0";
		}

		$parking_place = '0';

		if(!empty($request->input('garden')))
		{
			$garden = $request->input('garden');
		}
		else
		{
			$garden = "0";
		}

		if(!empty($request->input('scenic')))
		{
			$scenic = $request->input('scenic');
		}
		else
		{
			$scenic = "0";
		}

		if(!empty($request->input('sea')))
		{
			$sea = $request->input('sea');
		}
		else
		{
			$sea = "0";
		}

		if(!empty($request->input('nearsea')))
		{
			$nearsea = $request->input('nearsea');
		}
		else
		{
			$nearsea = "0";
		}

		if(!empty($request->input('nearforest')))
		{
			$nearforest = $request->input('nearforest');
		}
		else
		{
			$nearforest = "0";
		}

		if(!empty($request->input('businesscontact')))
		{
			$businesscontact = $request->input('businesscontact');
		}
		else
		{
			$businesscontact = "0";
		}

		$furnished = 0;
		if(!empty($request->input('furnished')))
		{
			$furnished = $_POST['furnished'];
		}

		$basement = 0;
		if(!empty($request->input('basement')))
		{
			$basement = $_POST['basement'];
		}

		$entryphone = 0;
		if(!empty($request->input('entryphone')))
		{
			$entryphone = $request->input('entryphone');
		}

		if(!empty($request->input('businesscontract')))
		{
			$businesscontract = $request->input('businesscontract');
		}
		else
		{
			$businesscontract = "0";
		}

		$date = date("Y-m-d");

		$pack = $request->input('package_type_id');
		$propertyId = $request->input('id');

		DB::table('properties')
			->where('id','=',$propertyId)
			->update([
			'package_type_id'=>$pack,
			'downpayment'=>$downpayment,
			'openHouseDate'=>$openHouseDate,
			'openHouseStartTime'=>$openHouseStartTime,
			'openHouseEndTime'=>$openHouseEndTime,
			'openHouseAddress'=>$openHouseAddress,
			'openHouseComment'=>$openHouseComment,
			'vacantDate'=>$vacantDate,
			'company_name'=>$company_name,
			'email'=>$email,
			'email2'=>$email2,
			'groundarea'=>$groundarea,
			'year'=>$year,
			'energy'=>$energy,
			'payment'=>$payment,
			'gross'=>$gross,
			'net'=>$net,
			'location1'=>$location1,
			'location2'=>$location2,
			'action'=>$action,
			'date_published'=>$date,
			'headline_dk'=>$headline_dk,
			'description_dk'=>$text_dk,
			'headline_eng'=>$headline_eng,
			'description_eng'=>$text_eng,
			'area_id'=>$areas,
			'zip_code_id'=>$zipcode,
			'address'=>$address,
			'housenum'=>$housenum,
			'floor'=>$propertyPosition,
			'phonenum1'=>$phone1,
			'phonenum2'=>$phone2,
			'vacant'=>$vacant,
			'type'=>$type,
			'rental_period'=>$rentalperiod,
			'shareFriendly'=>$sharefriendly,
			'handicapFriendly'=>$handicapfriendly,
			'youthHousing'=>$youthhousing,
			'seniorFriendly'=>$seniorfriendly,
			'size'=>$size,
			'rooms'=>$rooms,
			'bathrooms'=>$bathroom,
			'bedrooms'=>$bedroom,
			'price' => $rent,
			'price_usd' => $rent,
			'price_dk' => $rent,
			'rentDeposit'=>$totalDeposit,
			'prepaidRent'=>$totalPrepaid,
			'expenses'=>$expenses,
			'pets_allowed'=>$pets,
			'pets_comment'=>$petcommnet,
			'balcony'=>$balcony,
			'garage'=>$garage,
			'lift'=>$lift,
			'garden'=>$garden,
			'furnished'=>$furnished,
			'basement'=>$basement,
			'entry_phone'=>$entryphone,
			'business_contract'=>$businesscontract,
			]);


		if(!file_exists("images"))
		{
			@mkdir("images",0777);
		}
		else
		{
			@chmod("images",0777);
		}

		if(!file_exists("images/propertyimages"))
		{
			@mkdir("images/propertyimages",0777);
		}
		else
		{
			@chmod("images/propertyimages",0777);
		}

		$imageFiles = $request->file('files');

		/* echo '<pre>';
			print_r($_FILES["files"]);
		print_r($imageFiles);
		//exit; */


		if(!empty($imageFiles) && count($imageFiles)>0)
		{
			for($i = 0; $i<count($imageFiles);$i++)
			{
				$extension = $imageFiles[$i]->getClientOriginalExtension();

				$encryptName = md5(uniqid());
				$getimageName = $encryptName.'.'.$extension;
				$galleryPath = 'images/propertyimages/'.$getimageName;
				$imageFiles[$i]->move('images/propertyimages/', $getimageName);

				if($i==0)
				{
					$uploadedfile =	$imageFiles[$i]->getPathName();
					$new_thumb_name = $encryptName . "_thumb." . $extension;

					$new_width = 241;
					$new_height = 161;

					$originalImage = 'images/propertyimages/'.$getimageName;
					list($width,$height)=getimagesize($originalImage);

					$this->make_thumb($originalImage, "images/propertyimages/".$new_thumb_name, $new_width, $new_height, $extension);

						DB::table('properties')
							->where('id','=',$propertyId)
							->update([
							'thumbnail'=>"images/propertyimages/".$new_thumb_name
					]);
				}

				Gallery::create([
					'path'=>$galleryPath,
					'property_id'=>$propertyId
				]);
			}
		}

		return redirect(url("bolig_detaljer/".$propertyId));
	}

	/**
	* Sends an e-mail to Findbo with a user's report regarding a property.
	*
	* @return \Illuminate\Http\Request
	* @return \Illuminate\Http\Response
	*/
	public function sendReportEmail(Request $request) {
		$mailer = new MailService;
		$mailer -> sendReportMail($request->all());
		echo json_encode([
			'status' => 'success',
			'message' => 'report sent successfully',
		]);
	}

	public function addRemoveWishlist(Request $request)
	{
		$q = $request->input('q');
		$i = $request->input('i');

		$objWishlist = DB::table('wishlist')
			->where('property_fk','=',$q)
			->where('user_id','=',$i)
			->first();

		if(!empty($objWishlist) && count($objWishlist) > 0 ) {
			DB::table('wishlist')
				->where('id','=',$objWishlist->id)
				->delete();
			return "removed";
		} else {
			Wishlist::create([
				'property_fk'=>$q,
				'user_id'=>$i
			]);
			return "added";
		}
	}

	public function deleteProperty(Request $request)
	{
		$id = $request->input('forDelete');
		$objGallery = DB::table('gallery')
						->where('property_id','=',$id)
						->get();
		if(!empty($objGallery) && count($objGallery)>0)
		{
			foreach($objGallery as $gallery)
			{
				$path = $gallery->path;
				if(($path != 'images/propertyimages/ikke_navngivet_main.png') && ($path != 'images/propertyimages/genericGallery.jpg') && file_exists($path))
					unlink($path);
			}
		}
		$objProperty = new Properties();
		$objProperty->deleteProperty($id);
		return redirect(route('home.properties'));
	}
}
