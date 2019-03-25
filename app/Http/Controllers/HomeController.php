<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Properties;
use App\User;
use App\Admin;
use App\Zipcode;
use App\Area;
use App\SeekerPackages;
use App\Seekads;
use App\Repositories\PropertyRepository;

class HomeController extends Controller
{

    public function __construct() {
        $this -> properties = new PropertyRepository;
    }

    /**
    * Property repository.
    *
    * @var \App\Repositories\PropertyRepository;
    */
    private $properties;

    /**
    * Sandbox method for testing and developing new features.
    *
    * @return mixed
    */
    public function describe() {

/*
        $logs = DB::select('select count(log_id) as count, u.email, u.fname, u.lname, user_id from seeker_package_logs as logs left join users as u on u.id = logs.user_id where user_id > 13000 group by user_id order by user_id asc');
        print '<table>';
        foreach ($logs as $log) {
            print '<tr><td>' . $log->user_id . '</td><td>' . $log->fname . '</td><td>' . $log->lname . '</td><td>' . $log->email . '</td><td>' . $log->count . "</td></tr>\n";
        }
        print '</table>';

/*
        dd(Seekads::find(471));
        //dd(User::find(10199));
        //dd(Properties::find(46953));
        dd(Properties::find(47110)->update(['description_dk' => '2 stuer, Soveværelse med skab, Mindre køkken, Bad med brus. Dørtelefon - fælles vaskekælder - fælles cykelskur']));
    	//dd(Properties::pluck('price'));
        dd(DB::select('select id, price_usd from properties where not price = price_usd'));
        //dd(Properties::find(26921));
        dd(DB::select('select id, price_usd from properties where price_usd > 15000 limit 10'));
        //dd(DB::select('select count(id) from properties where not price = price_usd'));

        
        $properties = DB::select('select id, price_usd from properties where not price = price_usd');
        foreach ($properties as $p) {
            if (!preg_match('#^[0-9.]+$#', $p->price_usd))
                dd($p);
        } print 'all good';

    	//dd(Properties::find(46956)->delete());

    	//$property = Properties::create();
    	//dd($property);

        //dd(DB::select('select count(id) from properties where not price_usd = null'));
        //dd(DB::table('properties')->where('price_dk', '!=', null)->count());
        
  
        /* CLEAR FINDBOLIG SCRIPT
        $properties = DB::select('select id, prop_url from properties where prop_site_name = "findbolig" and status != 3');
        //dd(count($properties));
        foreach ($properties as $property) {
            $file = file_get_contents($property->prop_url);
            if (preg_match('#<h1>Bolig ikke fundet</h1>#', $file))
                DB::table('properties')->where('id', $property->id)->update(['status' => '3']);
        }
        CLEAR FINDBOLIG SCRIPT */

        //dd($properties);
        //$file = 'https://www.findbolig.nu/Findbolig-nu/Find%20bolig/Ledige%20boliger/Boligpraesentation/Boligen.aspx?aid=30781&s=2';
        //$file = file_get_contents('http://www.findbolig.nu/bolig.aspx?aid=23617&amp;s=2');
        //dd(preg_match('#<h1>Bolig ikke fundet</h1>#', $file));
        //dd(DB::select('select id, prop_url from properties where prop_site_name = "findbolig" and status != 3'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $objSeekAds = new Seekads();
		$newHomeSeeker = $objSeekAds->getNewHomeSeeker();
		$priceRange = getPropertyPriceRange();

		return view('welcome', [
            'newHomeSeeker' => $newHomeSeeker,
            'priceRange' => $priceRange,
            'aalborgCount' => $this->properties->countWhereCityNameLike('Aalborg'),
            'copenhagenCount' => $this->properties->countWhereCityNameLike('København'),
            'aarhusCount' => $this->properties->countWhereCityNameLike('Århus'),
            'odenseCount' => $this->properties->countWhereCityNameLike('Odense'),
        ]);
    }

    public function autoSearch(Request $request)
    {
        $term = $request->term;
        $items = [];

        $searchsByCities = Zipcode::select([
            'city_name'
        ])->where(
            'city_name','LIKE', $term.'%'
        )->limit(50)->get();
        if($searchsByCities) {
            foreach($searchsByCities as $searchsByCity) {
                $items[] = [
                    'label' => $searchsByCity->city_name,
                    'category' => 'By City',
                    'code' => '',
                    'searchBy' => 'city_name'
                ];
            }
        }

        $searchsByZipCodes = Zipcode::select([
            'city_name',
            'code',
        ])->where(
            'code','LIKE', $term.'%'
        )->limit(50)->get();
        if($searchsByZipCodes) {
            foreach($searchsByZipCodes as $searchsByZipCode) {
                $items[] = [
                    'label' => $searchsByZipCode->code.' '.$searchsByZipCode->city_name,
                    'category' => 'Post nr.',
                    'code' => $searchsByZipCode->code,
                    'searchBy' => 'zipcode'
                ];
            }
        }

        $searchsByRegions = Area::select([
            'name'
        ])->where(
            'name','LIKE', $term.'%'
        )->where(
            'is_region','1'
        )->limit(50)->get();
        if($searchsByRegions) {
            foreach($searchsByRegions as $searchsByRegion) {
                $items[] = [
                    'label' => $searchsByRegion->name,
                    'category' => 'Region',
                    'code' => '',
                    'searchBy' => 'region'
                ];
            }
        }

        $searchsByProperties = Properties::groupBy('headline_eng','headline_dk')->select([
            'headline_dk',
            'headline_eng',
        ])->where(
            'headline_dk','LIKE','%'.$term.'%'
        )->orWhere(
            'headline_eng','LIKE', '%'.$term.'%'
        )->where('is_available','!=', 0)->where('status','!=',0)->limit(50)->get();

        if($searchsByProperties) {
            foreach($searchsByProperties as $searchsByProperty) {
                if(empty($searchsByProperty->headline_eng)) {
                    $name = $searchsByProperty->headline_dk;
                } else {
                    $name = $searchsByProperty->headline_eng;
                }
                $items[] = [
                    'label' => $name,
                    'category' => 'Properties',
                    'code' => '',
                    'searchBy' => 'properties'
                ];
            }
        }

        return $items;

    }

}
