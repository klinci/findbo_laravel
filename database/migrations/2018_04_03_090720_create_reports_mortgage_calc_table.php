<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsMortgageCalcTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reports_mortgage_calc', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email')->nullable();
			$table->integer('loan')->nullable();
			$table->integer('years')->nullable();
			$table->integer('rate')->nullable();
			$table->string('start_date')->nullable();
			$table->integer('extra_monthly')->nullable();
			$table->integer('extra_yearly')->nullable();
			$table->integer('extra_yearly_month')->nullable();
			$table->integer('extra_one_time')->nullable();
			$table->string('extra_one_time_date')->nullable();
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
		Schema::dropIfExists('reports_mortgage_calc');
	}
}
