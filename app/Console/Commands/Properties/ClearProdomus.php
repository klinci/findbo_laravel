<?php

namespace App\Console\Commands\Properties;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearProdomus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-properties:prodomus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears outdated properties from prodomus.dk';

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
        $this -> info('clearing outdated properties from: prodomus');
        $properties = DB::select('select id, prop_url from properties where prop_site_name = "prodomus" and status != 3');
        $page = file_get_contents('https://prodomus.dk/ledige-boliger');
        preg_match_all('#id=(\d+)#', $page, $matches);
        $ids = $matches[1];
        foreach ($properties as $property) {
            $id = substr($property->prop_url, 38);
            if (!in_array($id, $ids)) {
                DB::table('properties')->where('id', $property->id)->update(['status' => 3]);
            }
        }
    }
}
