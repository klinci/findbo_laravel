<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekpropertyTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seekproperty', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('profileType')->nullable();
			$table->string('civilStatus')->nullable();
			$table->string('title')->nullable();
			$table->longText('description')->nullable();
			$table->string('name')->nullable();
			$table->integer('age')->nullable();
			$table->string('phone')->nullable();
			$table->string('phone2')->nullable();
			$table->string('email')->nullable();
			$table->string('location')->nullable();
			$table->string('maxRent')->nullable();
			$table->string('minArea')->nullable();
			$table->integer('minRooms')->nullable();
			$table->string('type')->nullable();
			$table->string('rentalPeriod')->nullable();
			$table->integer('userFk')->nullable();
			$table->date('date')->nullable();
			$table->string('thumbnail')->nullable();
			$table->string('thumbnail_large')->nullable();
			$table->integer('is_active')->nullable();
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
		Schema::dropIfExists('seekproperty');
	}
}
