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

		if($request->input('code'))
		{
			$getCode = $request->input('code');
		}

		if($request->input('refineSubmit'))
		{
			$page=1;
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

		$getArea = '';
		$arrOfArea = array();
		if($request->input('area'))
		{
			$getArea = implode(",",$request->input('area'));
			$arrOfArea = $request->input('area');
		}

		$getZipcode = '';
		$arrOfZip = array();
		if($request->input('zip'))
		{
			$getZipcode = implode(",",$request->input('zip'));
			$arrOfZip = $request->input('zip');
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

		$getRental = '';
		$arrOfRental = array();
		if($request->input('rental'))
		{
			$getRental = implode(",",$request->input('rental'));
			$arrOfRental = $request->input('rental');
		}


		$getPets = '';
		if($request->input('pets'))
		{
			$getPets = $request->input('pets');
		}

		$getFurnished = '';
		if($request->input('furnished'))
		{
			$getFurnished = $request->input('furnished');
		}

		$getBusinessContract = '';
		if($request->input('businesscontract'))
		{
			$getBusinessContract = $request->input('businesscontract');
		}

		$getGarage = '';
		if($request->input('garage'))
		{
			$getGarage = $request->input('garage');
		}

		$getBalcony = '';
		if($request->input('balcony'))
		{
			$getBalcony = $request->input('balcony');
		}

		$getLift = '';
		if($request->input('lift'))
		{
			$getLift = $request->input('lift');
		}

		$getGarden = '';
		if($request->input('garden'))
		{
			$getGarden = $request->input('garden');
		}

		$getSenior = '';
		if($request->input('senior'))
		{
			$getSenior = $request->input('senior');
		}

		$getYouth = '';
		if($request->input('youth'))
		{
			$getYouth = $request->input('youth');
		}

		$getHandicap = '';
		if($request->input('handicap'))
		{
			$getHandicap = $request->input('handicap');
		}

		$arrOfParams = array(
				'code'=>$getCode,
				'keyword'=>$keyword,
				'area'=>$getArea,
				'zipcode'=>$getZipcode,
				'sortBy'=>$sortBy,
				'sort_order'=>$sortOrder,
				'price'=>$price,
				'type'=>$getType,
				'minPrice'=>$getMinPrice,
				'maxPrice'=>$getMaxPrice,
				'minArea'=>$getMinArea,
				'maxArea'=>$getMaxArea,
				'minRooms'=>$getMinRooms,
				'maxRooms'=>$getMaxRooms,
				'rental'=>$getRental,
				'pets'=>$getPets,
				'furnished'=>$getFurnished,
				'businesscontract'=>$getBusinessContract,
				'garage'=>$getGarage,
				'balcony'=>$getBalcony,
				'lift'=>$getLift,
				'garden'=>$getGarden,
				'senior'=>$getSenior,
				'youth'=>$getYouth,
				'handicap'=>$getHandicap
		);

		/* echo '<pre>';
		print_r($arrOfParams);
		exit; */

		$objProperties = new Properties();
		$totalResult = $objProperties->getSearchProperties(0,0,$arrOfParams);

		$pagination = pagination($page,$per_page=10,count($totalResult));

		/* echo '<pre>';
		print_r($pagination);
		exit; */

		//dd($arrOfParams);
		$result = $objProperties->getSearchProperties($page,$limit,$arrOfParams);

		/* $objAreas = DB::table('areas')
					->orderBy('id','asc')
					->get(); */

		//$objZipcode = Zipcode::all()->where('is_display_on_search', 1)->orderBy('city_name','ASC');
		$objZipcode = DB::table('zip_code')
						->where('is_display_on_search', 1)
						->orderBy('city_name','ASC')
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

		return view('property',['result'=>$result,'action'=>$action,'keyword'=>$keyword,'sortBy'=>$sortBy,'sortOrder'=>$sortOrder,
							'price'=>$price,'pagination'=>$pagination,'objPropertiesType'=>$objPropertiesType,
							'priceRange'=>$arrOfPriceRange,'areaRange'=>$arrOfAreaRange,'objRentalPeriod'=>$objRentalPeriod,
							'arrOfZip'=>$arrOfZip,'arrOfType'=>$arrOfType,'minprice'=>$getMinPrice,'maxprice'=>$getMaxPrice,
							'minarea'=>$getMinArea, 'maxarea'=>$getMaxArea, 'minrooms'=>$getMinRooms,'getMaxRooms'=>$getMaxRooms,
							'arrOfRental'=>$arrOfRental,'pets'=>$getPets,'furnished'=>$getFurnished,'businessContract'=>$getBusinessContract,
							'garage'=>$getGarage,'balcony'=>$getBalcony,'lift'=>$getLift,'garden'=>$getGarden,'senior'=>$getSenior,
							'youth'=>$getYouth,'handicap'=>$getHandicap,'page'=>$page,'code'=>$getCode,'objZipcode'=>$objZipcode]);

	}

	public function propertyDetail($id)
	{
		$objProperty = Properties::getPropertyById($id);
		if (!$objProperty) {
			return redirect('property_detail');
		}

		$objGallery = Gallery::getGalleryByPropertyId($id);

		$active_pack_id = 0;
		$objWishlist = [];
		if(Auth::check())
		{
			$userId = Auth::user()->id;
			if($userId > 0)
			{
				$objUser = User::find($userId);

				$today_date = date('Y-m-d H:i:s');
				if((strtotime($objUser->package_expiry_date)>strtotime($today_date)) && ($objUser->seek_package_id == 2))
				{
					$active_pack_id = $objUser->seek_package_id;
				}
				elseif((strtotime($objUser->package_expiry_date)>strtotime($today_date)) && ($objUser->seek_package_id == 1))
				{
					$active_pack_id = $objUser->seek_package_id;
				}
			}

			$objWishlist = DB::table('wishlist')
				->where('property_fk','=',$objProperty->id)
				->where('user_id','=',Auth::user()->id)
				->first();
		}

		$relatedProperty = Properties::getRelatedProperty($objProperty->zip_code_id,$id);

		/* echo '<pre>';
		print_r($relatedProperty);
		exit; */

		$isAdmin = '';
		if(Auth::check())
		{
			$objUser = User::find(Auth::user()->id);
			$isAdmin = $objUser->isAdmin;
		}

		return view('property_detail',['objProperty'=>$objProperty,'objGallery'=>$objGallery,'active_pack_id'=>$active_pack_id,'objWishlist'=>$objWishlist,'relatedProperty'=>$relatedProperty,'isAdmin'=>$isAdmin]);
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
				'code'=>$getCode,
				'keyword'=>$keyword,
				'sortBy'=>$sortBy,
				'sort_order'=>$sortOrder,
				'price'=>$price,
				'type'=>$getType,
				'minPrice'=>$getMinPrice,
				'maxPrice'=>$getMaxPrice,
				'minArea'=>$getMinArea,
				'maxArea'=>$getMaxArea,
				'minRooms'=>$getMinRooms,
				'maxRooms'=>$getMaxRooms,
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
		if(Auth::user()->is_paid_member == '0') return redirect(url('package'));
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
		$propertyPosition = "$position, $floor"; // floor in database
		$company_name = $request->input('company_name');
		$country1 = $request->input('country1');
		$number1 = $request->input('number1');
		$phone1 = "$country1$number1"; // phonenumber1
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

		$objProperty = Properties::create([
				'package_type_id'=>$pack,
				'downpayment'=>$downpayment,
				'openHouseDate'=>$openHouseDate,
				'openHouseStartTime'=>$openHouseStartTime,
				'openHouseEndTime'=>$openHouseEndTime,
				'openHouseAddress'=>$openHouseAddress,
				'openHouseComment'=>$openHouseComment,
				'user_id'=>Auth::user()->id,
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
				'prop_seo_title'=>'',
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
				'price'=>$rent,
				'rentDeposit'=>$totalDeposit,
				'prepaidRent'=>$totalPrepaid,
				'expenses'=>$expenses,
				'pets_allowed'=>$pets,
				'pets_comment'=>$petcommnet,
				'balcony'=>$balcony,
				'garage'=>$garage,
				'parking_place'=>$parking_place,
				'lift'=>$lift,
				'garden'=>$garden,
				'scenic'=>$scenic,
				'sea'=>$sea,
				'near_sea'=>$nearsea,
				'near_forest'=>$nearforest,
				'business_contact'=>$businesscontact,
				'furnished'=>$furnished,
				'basement'=>$basement,
				'entry_phone'=>$entryphone,
				'business_contract'=>$businesscontract,
				'status'=>0,
				'is_available'=>1,
				'prop_site_name'=>'findbo',
				'property_url'=>$propertyURL
		]);

		$propertyId = $objProperty->id;

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
				$imageFiles[$i]->move('images/propertyimages', $getimageName);

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
		/*
		if($pack!=1)
		{
			return redirect("property_payment/".$propertyId.'/'.$pack);
		}
		else
		{
			return redirect("property");
		}
		*/
		//return redirect("property");
		return redirect("property_detail/" . $propertyId);
	}

	public function propertyPayment($id,$pid)
	{
		/* echo "<br>===>".$id.'===='.$pid;
		exit; */

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
			return redirect("/");
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

				return redirect('redirect');
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
		if (!$objProperty) {
			return redirect('property_detail');
		}
		$objArea = Area::all();
		$objRentalPeriod = Rentalperiod::all();
		$objZipCode = Zipcode::all();
		$totalDeposit	= $objProperty->rentDeposit;
		$price = $objProperty->price;
		$ar_depo = explode(' ',$totalDeposit);
		$depositValue = 0;
		if(!empty($ar_depo[1]))
		{
			$depositValue = $ar_depo[1];
		}
		$deposit = intval($depositValue/$price);

		$totalPrepaid	= $objProperty->prepaidRent;
		$ar_prepaid = explode(':',$totalPrepaid);
		$prepaidValue = 0;
		if(!empty($ar_prepaid[1]))
		{
			$prepaidValue = trim($ar_prepaid[1]);
		}
		$prepaid = intval($prepaidValue/$price);

		$objGallery = DB::table("gallery")
							->where('property_id','=',$id)
							->get();

		/* echo '<pre>';
		print_r($objGallery); */

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
			'price'=>$rent,
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

		return redirect("property_detail/".$propertyId);
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

		if(!empty($objWishlist) && count($objWishlist)>0)
		{
			DB::table('wishlist')
				->where('id','=',$objWishlist->id)
				->delete();
			echo "removed";
		}
		else
		{
			Wishlist::create([
				'property_fk'=>$q,
				'user_id'=>$i
			]);
			echo "added";
		}
		exit;
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

		return redirect('myads');
	}
}
