<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyPackageHistoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('property_package_history', function (Blueprint $table) {
			$table->bigIncrements('history_id');
			$table->bigInteger('prop_id')->nullable();
			$table->integer('user_id')->nullable();
			$table->integer('package_type_id')->nullable();
			$table->dateTime('package_start_date')->nullable();
			$table->dateTime('package_expiry_date')->nullable();
			$table->string('transaction_id')->nullable();
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
		Schema::dropIfExists('property_package_history');
	}
}
