<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekerPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seeker_packages', function (Blueprint $table) {
			$table->increments('id');
			$table->float('price',10,2)->nullable();
			$table->integer('duration')->nullable();
			$table->string('name')->nullable();
			$table->longText('desc')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seeker_packages');
    }
}
