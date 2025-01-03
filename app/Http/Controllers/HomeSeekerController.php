<?php

namespace App\Http\Controllers;

use App\Area;
use App\Mail\HomeSeekerContact;
use App\Messsages;
use Illuminate\Mail\Message;
use App\Conversation;
use App\Seekgallery;
use App\Seekads;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeSeekerController extends Controller
{
	public function __construct() {
		$this->middleware('auth')->except('index');
		// $this->middleware('active')->only(['create','store']);
	}

	public function index($id)
	{

		\Session::put('redirected', url()->current());

		if($id > 0) {

			$l_user_id = 0;
			$is_paid_member = 0;
			$checkUser = 0;
			$active_pack_id = 0;
			$isAdmin = "";

			if(Auth::user()) {

				$l_user_id = Auth::user()->id;

				$objUser = User::find($l_user_id);
				$is_paid_member = $objUser->is_paid_member;

				$isAdmin = $objUser->isAdmin;
				$today_date = date('Y-m-d H:i:s');

				if(($objUser->package_expiry_date>$today_date) && ($objUser->seek_package_id == 2)) {
					$active_pack_id = $objUser->seek_package_id;
				}elseif(($objUser->package_expiry_date>$today_date) && ($objUser->seek_package_id == 1)) {
					$active_pack_id = $objUser->seek_package_id;
				}

			}

			$objHomeSeeker = Seekads::getHomeSeekerById($id);

			if(!$objHomeSeeker) {
				return redirect()->route('home');
			}

			$objSeekGallery = DB::table('seekGallery')->where('property_id','=',$id)->orderBy('id','desc')->first();

			if(!$objSeekGallery) {
				return redirect()->route('home');
			}

			$thumbnail = '';
			if(!empty($objSeekGallery) && count($objSeekGallery)>0) {
				$thumbnail = $objSeekGallery->path;
			}

			$objHomeSeekerProperty = DB::table('properties')
				->where('user_id', $l_user_id)
				->where('status','=',1)
				->where('is_available','=',1)->limit(20)
				->get();

			if(!$objHomeSeekerProperty) {
				return redirect()->route('home');
			}

			//----- for right side ------
			$arrOfProperty = Seekads::getHomeSeekerPropertyByLocation($objHomeSeeker->location,$id);

			if(!$arrOfProperty) {
				return redirect()->route('home');
			}

			return view('homeseeker', [
				'objHomeSeeker' => $objHomeSeeker,
				'arrOfProperty' => $arrOfProperty,
				'l_user_id' => $l_user_id,
				'is_paid_member' => $is_paid_member,
				'active_pack_id' => $active_pack_id,
				'isAdmin' => $isAdmin,
				'thumbnail' => $thumbnail,
				'objHomeSeekerProperty' => $objHomeSeekerProperty
			]);

		} else {
			return redirect()->route('home');
		}
	}

	public function contact(Request $request)
	{

		$date = date('Y-m-d H:i:s');

		$validator = \Validator::make($request->all(), [
			'message' => 'required',
			'user_id' => 'required',
			'property_id' => 'required'
		]);

		if($validator->fails()) {
			return redirect()->back();
		}

		$conversationCreate = Conversation::create([
			'user_one' => Auth::user()->id,
			'user_two' => $request->user_id,
		]);

		if($conversationCreate) {

			$message = Messsages::create([
				'message_text' => $request->message,
				'conversation_fk' => $conversationCreate->id,
				'user_sender_fk' => Auth::user()->id,
				'user_receiver_fk' => $request->user_id,
				'isSeen' => 'false',
				'relatedProperty' => $request->property_id
			]);

			$user = User::find($request->user_id);

			if($user) {
				try {
					$obj = new \stdClass();
					$obj->receiver_fname = $user->fname;
					$obj->sender_fname = Auth::user()->fname;
					Mail::to($request->user_email)->send(new HomeSeekerContact($obj));
					if($obj) {
						$message = 1;
					} else {
						$message = 0;
					}
				} catch (\Exception $e) {
					$message = 0;
				}
			}
		}

		if(\Session::has('redirected')) {
			return redirect(\Session::get('redirected'))
				->with('message',$message);
		}

		return redirect()->back()->with('message',$message);
	}

	public function activation($id,$act)
	{
		if(Auth::check())
		{
			//$objSeekProperty = Seekads::find($id);
			$objSeekProperty = DB::table('seekProperty')
								->where('id','=',$id)
								->first();

			$user_row = User::find(Auth::user()->id);

			$today_date = date('Y-m-d H:i:s');
			if(($objSeekProperty->userFk == Auth::user()->id) && ($user_row->package_expiry_date>$today_date))
			{
				DB::table('seekProperty')
						->where('id','=',$id)
						->update(['is_active'=>$act]);
			}

			return redirect()->back();
		}
		else
		{
			// return redirect('home_seeker/'.$id);
			return redirect()->back();
		}
	}

	public function createAds($id)
	{
		$objSeekAds = Seekads::getHomeSeekerById($id);
		$objArea = Area::all();

		return view('create_ads',['objSeekAds'=>$objSeekAds,'objArea'=>$objArea]);
	}

	/**
	* Displays the form for editing a new home seeker ad.
	*
	* @return Illuminate\Http\Response
	*/
	public function edit($id) {
		$objSeekAds = Seekads::getHomeSeekerById($id);
		if (!$objSeekAds) {
			// return redirect('/');
			return redirect()->back();
		}
		$objArea = Area::all();
		return view('create_ads', [
			'objSeekAds' => $objSeekAds,
			'objArea' => $objArea,
			'method' => 'PUT',
		]);
	}

	/**
	* Displays the form for creating a new home seeker ad.
	*
	* @return Illuminate\Http\Response
	*/
	public function create()
	{

		if(Auth::user()->userType == '2' && Auth::user()->seek_package_id > 0 || Auth::user()->isAdmin == 'admin') {
			$objArea = Area::all();

			$seekAds = Seekads::where('userFk', Auth::user()->id)->first();
			if($seekAds) {
				return redirect()->route('home_seeker.edit', $seekAds->id);
			}

			return view('create_ads', [
				'objArea' => $objArea,
			]);
		}

		if(Auth::check() && (Auth::user()->userType == '2' && Auth::user()->seek_package_id == '0')) {
			 	return view('auth.notpaid');
		}
		return redirect()->back();
	}

	/**
	* Saves a new home seeker ad.
	*
	* @param Illuminate\Http\Request  $request
	* @return Illuminate\Http\Response
	*/
	public function store(Request $request) {
		$data = [
			'civilStatus' => $request->input('civil_status'),
			'title' => $request->input('title'),
			'description' => $request->input('desc'),
			'name' => $request->input('name'),
			'age' => $request->input('age'),
			'phone' => $request->input('phone'),
			'phone2' => $request->input('phone2'),
			'email' => $request->input('email'),
			'location' => $request->input('location'),
			'type' => $request->input('type'),
			'rentalPeriod' => $request->input('period'),
			'date' => date("Y-m-d"),
			'userFk' => Auth::id(),
			'is_active' => 1,
		];

		$data['maxRent'] = empty($request->input('maxRent')) ? 'N/A' : $request->input('maxRent');
		$data['minArea'] = empty($request->input('minArea')) ? 'N/A' : $request->input('minArea');
		$data['minRooms'] = empty($request->input('minRooms')) ? 'N/A' : $request->input('minRooms');

		$saved = Seekads::create($data);

		if(!file_exists("images"))
			@mkdir("images",0777);
		else @chmod("images",0777);

		if(!file_exists("images/propertyimages"))
			@mkdir("images/propertyimages",0777);
		else @chmod("images/propertyimages",0777);

		$imageFiles = $request -> file('files');

		if (!empty($imageFiles) && count($imageFiles) > 0) {

			for ($i = 0; $i < count($imageFiles); $i++) {

				$extension = $imageFiles[$i]->getClientOriginalExtension();
				$encryptName = md5(uniqid());
				$getimageName = $encryptName.'.'.$extension;
				$galleryPath = 'images/propertyimages/'.$getimageName;
				$imageFiles[$i] -> move('images/propertyimages', $getimageName);

				if ($i == 0) {
					$uploadedfile =	$imageFiles[$i] -> getPathName();
					$new_thumb_name = $encryptName . "_thumbnail." . $extension;

					$originalImage = 'images/propertyimages/'.$getimageName;
					list($width, $height) = getimagesize($originalImage);

					$this -> make_thumb($originalImage, "images/propertyimages/".$new_thumb_name, 97, 97, $extension);

					$thumbnail_large = "images/propertyimages/". $encryptName . "_thumbnail_large." . $extension;
					$this -> make_thumb($originalImage, $thumbnail_large, 241, 161, $extension);

					DB::table('seekProperty')
							->where('id', '=', $saved -> id)
							->update([
								'thumbnail' => "images/propertyimages/".$new_thumb_name,
								'thumbnail_large' => $thumbnail_large,
							]);
				}

				Seekgallery::create([
						'path' => $galleryPath,
						'property_id' => $saved -> id,
					]);
			}
		}

		// return redirect('home_seeker/' . $saved -> id);
		return redirect()->back();
	}

	/**
	* Updates a home seeker ad.
	*
	* @param Illuminate\Http\Request  $request
	* @return Illuminate\Http\Response
	*/
	public function update(Request $request) {
		$data = [
			'civilStatus' => $request->input('civil_status'),
			'title' => $request->input('title'),
			'description' => $request->input('desc'),
			'name' => $request->input('name'),
			'age' => $request->input('age'),
			'phone' => $request->input('phone'),
			'phone2' => $request->input('phone2'),
			'email' => $request->input('email'),
			'location' => $request->input('location'),
			'type' => $request->input('type'),
			'rentalPeriod' => $request->input('period'),
			'date' => date("Y-m-d"),
		];

		$data['maxRent'] = empty($request->input('maxRent')) ? 'N/A' : $request->input('maxRent');
		$data['minArea'] = empty($request->input('minArea')) ? 'N/A' : $request->input('minArea');
		$data['minRooms'] = empty($request->input('minRooms')) ? 'N/A' : $request->input('minRooms');

		Seekads::where('id', '=', $request->id)->update($data);

		if(!file_exists("images"))
			@mkdir("images",0777);
		else @chmod("images",0777);

		if(!file_exists("images/propertyimages"))
			@mkdir("images/propertyimages",0777);
		else @chmod("images/propertyimages",0777);

		$imageFiles = $request -> file('files');

		if (!empty($imageFiles) && count($imageFiles) > 0) {

			for ($i = 0; $i < count($imageFiles); $i++) {

				$extension = $imageFiles[$i]->getClientOriginalExtension();
				$encryptName = md5(uniqid());
				$getimageName = $encryptName.'.'.$extension;
				$galleryPath = 'images/propertyimages/'.$getimageName;
				$imageFiles[$i] -> move('images/propertyimages', $getimageName);

				if ($i == 0) {
					$uploadedfile =	$imageFiles[$i] -> getPathName();
					$new_thumb_name = $encryptName . "_thumbnail." . $extension;

					$originalImage = 'images/propertyimages/'.$getimageName;
					list($width, $height) = getimagesize($originalImage);

					$this -> make_thumb($originalImage, "images/propertyimages/".$new_thumb_name, 97, 97, $extension);

					$thumbnail_large = "images/propertyimages/". $encryptName . "_thumbnail_large." . $extension;
					$this -> make_thumb($originalImage, $thumbnail_large, 241, 161, $extension);

					DB::table('seekProperty')
							->where('id', '=', $request -> id)
							->update([
								'thumbnail' => "images/propertyimages/".$new_thumb_name,
								'thumbnail_large' => $thumbnail_large,
							]);
				}

				Seekgallery::create([
						'path' => $galleryPath,
						'property_id' => $request -> id,
					]);
			}
		}

		// return redirect('home_seeker/' . $request -> id);
		return redirect()->back();
	}

	/*
	public function submitAds(Request $request)
	{
		$civilStatus	= $request->input('civil_status');
		$title			= $request->input('title');
		$desc			= $request->input('desc');
		$name			= $request->input('name');
		$age			= $request->input('age');
		$phone			= $request->input('phone');
		$phone2			= $request->input('phone2');
		$email			= $request->input('email');
		$location		= $request->input('location');

		if(!empty($request->input('maxRent')))
		{	$maxRent = $request->input('maxRent');	}
		else
		{	$maxRent = "N/A";	}

		if(!empty($request->input('minArea')))
		{	$minArea = $request->input('minArea');	}
		else
		{	$minArea = "N/A";	}

		if(!empty($request->input('minRooms')))
		{	$minRooms = $request->input('minRooms');	}
		else
		{	$minRooms = "N/A";	}

		$type		= $request->input('type');
		$period		= $request->input('period');
		$date		= date("Y-m-d");

		DB::table('seekProperty')
			->where('id','=',$request->input('id'))
			->update([
				'civilStatus'=>$civilStatus,
				'title'=>$title,
				'description'=>$desc,
				'name'=>$name,
				'age'=>$age,
				'phone'=>$phone,
				'phone2'=>$phone2,
				'email'=>$email,
				'location'=>$location,
				'maxRent'=>$maxRent,
				'minArea'=>$minArea,
				'minRooms'=>$minRooms,
				'type'=>$type,
				'rentalPeriod'=>$period,
				'date'=>$date
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
					$new_thumb_name = $encryptName . "_thumbnail." . $extension;

					$new_width = 97;
					$new_height = 97;

					$originalImage = 'images/propertyimages/'.$getimageName;
					list($width,$height)=getimagesize($originalImage);

					$this->make_thumb($originalImage, "images/propertyimages/".$new_thumb_name, $new_width, $new_height, $extension);

					$new_width = 241;
					$new_height = 161;
					$thumbnail_large = "images/propertyimages/". $encryptName . "_thumbnail_large." . $extension;
					$this->make_thumb($originalImage, $thumbnail_large, $new_width, $new_height, $extension);

					DB::table('seekProperty')
							->where('id','=',$request->input('id'))
							->update([
								'thumbnail'=>"images/propertyimages/".$new_thumb_name,
								'thumbnail_large'=>$thumbnail_large
							]);
				}

				Seekgallery::create([
				'path'=>$galleryPath,
				'property_id'=>$request->input('id')
				]);
			}
		}

		return redirect('create_home_search_ads/'.$request->input('id'));

	}
	*/

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
}
