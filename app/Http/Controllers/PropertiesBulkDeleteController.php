<?php

namespace App\Http\Controllers;

use Auth;
use App\Properties;
use App\Gallery;
use App\ActivePackages;
use App\PropertyHunted;
use App\PropertyPackageHistory;
use App\Seekgallery;
use App\Wishlist;
use Illuminate\Http\Request;

class PropertiesBulkDeleteController extends Controller
{

	public function __construct()
	{
		// $this->middleware('auth');
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

					/*
					* Delete Gallery
					*/
					Gallery::whereIn('id', $galleryItems)->delete();
					try {
						unlink(public_path($property->thumbnail));
					} catch (\Exception $e) {
					}
					$propertyItems[$n] = $property->id;

					/*
					* Delete Active Packages
					*/
					$packageItems = [];
					$activePackages = ActivePackages::where('property_fk', $property->id)->get();
					if($activePackages) {
						foreach ($activePackages as $packageNumber => $activePackage) {
							$packageItems[$packageNumber] = $activePackage->id;
						}
						ActivePackages::whereIn('id', $packageItems)->delete();
					}

					/*
					* Delete Property Hunted
					*/
					$propertyHuntedItems = [];
					$propertyHunteds = PropertyHunted::where('property_id', $property->id)->get();
					if($propertyHunteds) {
						foreach ($propertyHunteds as $propertyHuntedNumber => $propertyHunted) {
							$propertyHuntedItems[$propertyHuntedNumber] = $propertyHunted->id;
						}
						PropertyHunted::whereIn('id', $propertyHuntedItems)->delete();
					}

					/*
					* Delete Property Package History
					*/
					$PropertPackageHistoryItems = [];
					$PropertPackageHistories = PropertyPackageHistory::where('prop_id', $property->id)->get();
					if($PropertPackageHistories) {
						foreach ($PropertPackageHistories as $PropertPackageHistoryNumber => $PropertPackageHistory) {
							$PropertPackageHistoryItems[$PropertPackageHistoryNumber] = $PropertPackageHistory->id;
						}
						PropertyPackageHistory::whereIn('id', $PropertPackageHistoryItems)->delete();
					}

					/*
					* Delete Seek Gallery
					*/
					$seekGalleryItems = [];
					$seekGalleries = Seekgallery::where('property_id', $property->id)->get();
					if($seekGalleries) {
						foreach ($seekGalleries as $seekGalleryNumber => $seekGallery) {

							try {
								unlink(public_path($seekGallery->path));
							} catch (\Exception $e) {
							}

							$seekGalleryItems[$seekGalleryNumber] = $seekGallery->id;
						}
						Seekgallery::whereIn('id', $seekGalleryItems)->delete();
					}

					/*
					* Delete Wishlist
					*/
					$WishlistItems = [];
					$Wishlists = Wishlist::where('property_fk', $property->id)->get();
					if($Wishlists) {
						foreach ($Wishlists as $WishlistNumber => $Wishlist) {

							$WishlistItems[$WishlistNumber] = $Wishlist->id;
						}
						Wishlist::whereIn('id', $WishlistItems)->delete();
					}

				} // End foreach properties

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
