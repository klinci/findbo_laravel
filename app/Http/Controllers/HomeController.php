<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Seekads;
use Illuminate\Support\Facades\DB;
use App\Properties;
use App\Repositories\PropertyRepository;


// for describe function
use App\User;
use App\Admin;
use App\SeekerPackages;

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
    	$term = $request->input('term');
    	
    	$arr = array();
    	//--- first find cities list ---
    	$objFindCities = DB::select("SELECT * FROM zip_code 
				WHERE (city_name LIKE '".$term."%') 
				AND is_display_on_search=1
				ORDER BY city_name ASC");
    	if(!empty($objFindCities) && count($objFindCities)>0)
    	{
    		foreach($objFindCities as $findCities)
    		{
    			if($findCities->city_name!="")
    			{
    				$arr[] = array('label'=>$findCities->city_name, 'category'=>'By', 'code'=>'','searchBy'=>'city_name');
    			}
    		}
    	}
    	
    	
    	//--- second find zipcode ----
    	$objFindZipcode = DB::select("SELECT * FROM zip_code 
				WHERE code LIKE '".$term."%'
				ORDER BY code ASC");
    	if(!empty($objFindZipcode) && count($objFindZipcode)>0)
    	{
    		foreach($objFindZipcode as $zipcode)
    		{
    			if($zipcode->city_name!="")
    			{
    				$arr[] = array('label'=>$zipcode->code.' '.$zipcode->city_name.'', 'category'=>'post nr.', 'code'=>$zipcode->code,'searchBy'=>'zipcode');
    			}
    		}
    	}
    	
    	echo json_encode($arr);
    	exit;
    }
}
