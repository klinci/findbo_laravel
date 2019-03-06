<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekPackageLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seeker_package_logs', function (Blueprint $table) {
			$table->increments('log_id');
			$table->integer('user_id')->nullable();
			$table->integer('package_status')->nullable();
			$table->dateTime('log_date')->nullable();
			$table->longText('log_comment')->nullable();
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
		Schema::dropIfExists('seeker_package_logs');
	}
}
