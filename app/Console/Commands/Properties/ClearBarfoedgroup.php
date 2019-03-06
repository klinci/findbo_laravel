<?php

namespace App\Console\Commands\Properties;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearBarfoedgroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-properties:barfoedgroup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears outdated properties from barfoedgroup.dk';

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
        $this -> info('clearing outdated properties from: barfoedgroup');
        $properties = DB::select('select id, prop_url from properties where prop_site_name = "barfoedgroup" and status != 3');
        foreach ($properties as $property) {
            $handle = fopen($property->prop_url, 'r');
            if (!$handle) continue;
            
            $part = fread($handle, 2048);
            if (preg_match('#<title>Se ledige lejeboliger#', $part))
                DB::table('properties')->where('id', $property->id)->update(['status' => 3]);
            fclose($handle);
        }
    }
}
