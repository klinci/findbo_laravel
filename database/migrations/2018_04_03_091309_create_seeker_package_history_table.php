<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekerPackageHistoryTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seeker_package_history', function (Blueprint $table) {
			$table->bigIncrements('history_id');
			$table->integer('user_id')->nullable();
			$table->string('cust_id')->nullable();
			$table->integer('seek_package_id')->nullable();
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
		Schema::dropIfExists('seeker_package_history');
	}
}
