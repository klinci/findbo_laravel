<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivePackagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('active_packages', function (Blueprint $table) {
			$table->increments('id');
			$table->integer("property_fk")->nullable();
			$table->integer("user_fk")->nullable();
			$table->integer("pack_fk")->nullable();
			$table->dateTime("date_added")->nullable();
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
		Schema::dropIfExists('active_packages');
	}
}
