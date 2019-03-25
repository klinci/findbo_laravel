<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{

	const GOOGLE_API_KEY = 'AIzaSyAYUsbSwwhQVXhVTb-75P0TeJmxuggQ8lE';
	const MAPBOX_API_KEY = 'pk.eyJ1IjoicXVkcmF0IiwiYSI6ImNqdGx3djl5ZjBjd2o0NG9qZXUxYXhwNDUifQ.GFMfjCztPEePtlLjjiEndw';

	public function index(Request $request)
	{
		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($request->address).'&key='.self::GOOGLE_API_KEY,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HEADER => 0, #0 ? 1 : 0,
			CURLOPT_TIMEOUT => 10,
		]);

		$data 	= curl_exec($ch);
		$error 	= curl_error($ch);
		$info 	= curl_getinfo($ch);

		if($data) {
			$data =  json_decode($data,true);
			if($data['status'] != 'OK') {
				return $this->getLatLongFromOtherWebsite($request->address);
			}
			return $data;
		} else {
			return [
				'status' => 'error',
				'message' => $error
			];
		}
	}

	private function cutString($string,$start,$end)
	{
		$str = explode($start,$string);
		$str = explode($end,$str[1]);
		return $str[0];
	}

	public function getLatLongFromOtherWebsite($address)
	{
		try {

			$getContent = file_get_contents('https://a.tiles.mapbox.com/geocoding/v5/mapbox.places/'.urlencode($address).'.json?access_token='.self::MAPBOX_API_KEY);
			$data =  json_decode($getContent, true);
			return [
				'status' => 'OK',
				'results' => [
					[
					 	'geometry' => [
					 		'location' => [
					 			'lat' => $data['features'][0]['geometry']['coordinates'][1],
					 			'lng' =>  $data['features'][0]['geometry']['coordinates'][0]
					 		]
					 	]
					]
				]
			];
		} catch (\Exception $e) {
			return [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}
	}

}
