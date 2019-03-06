<?php

namespace App\Console\Commands\Properties;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearHousingcompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-properties:housingcompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears outdated properties from housingcompany.dk';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {        
        $this -> info('clearing outdated properties from: housingcompany');
        $properties = DB::select('select id, prop_url from properties where prop_site_name = "housingcompany" and status != 3');
        foreach ($properties as $property) {
            try {
                $file = file_get_contents($property->prop_url);
                if (preg_match('#<title>Page not found#', $file))
                    DB::table('properties')->where('id', $property->id)->update(['status' => '3']);
            } catch (\Exception $e) {
                DB::table('properties')->where('id', $property->id)->update(['status' => '3']);
            }
        }
    }
}
