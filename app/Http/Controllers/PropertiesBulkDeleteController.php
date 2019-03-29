<?php

namespace App\Http\Controllers;

use Auth;
use App\Properties;
use App\Gallery;
use Illuminate\Http\Request;

class PropertiesBulkDeleteController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		if(Auth::user()->email == 'info@findbo.dk') {
			return view('properties_bulk_delete');
		}

		return redirect()->route('home');
	}

	private function queries($request,$option)
	{

		$properties = Properties::whereBetween('date_published', [
			$request->dateFrom,
			$request->dateEnd
		]);

		if($option == 'counter') {
			return $properties->count();
		}

		return $properties->get();

	}

	public function bulkDeletes(Request $request)
	{

		if(Auth::user()->email == 'info@findbo.dk') {

			if($request->dateFrom > $request->dateEnd) {
				return [
					'error' => 1,
					'message' => 'Date of more than the end date.'
				];
			}

			$counter = $this->queries($request,'counter');

			if($counter > 1000) {
				return [
					'error' => 1,
					'message' => 'Data too much count.'
				];
			}

			$properties = $this->queries($request,'query');
			if($properties) {
				$propertyItems = [];
				foreach ($properties as $n => $property) {
					$galleryItems = [];
					$galleries = Gallery::where('property_id', $property->id)->get();
					foreach ($galleries as $x => $gallery) {

						$galleryItems[$x] = $gallery->id;
						try {
							unlink(public_path($gallery->path));
						} catch (\Exception $e) {
						}

					}

					Gallery::whereIn('id', $galleryItems)->delete();
					try {
						unlink(public_path($property->thumbnail));
					} catch (\Exception $e) {
					}
					$propertyItems[$n] = $property->id;
				}

				Properties::whereIn('id', $propertyItems)->delete();
				return [
					'error' => 0,
					'message' => 'Properties has been deleted.'
				];

			}

			return [
				'error' => 0,
				'message' => 'Data not found.'
			];

		}
		return redirect()->route('home');
	}

}
