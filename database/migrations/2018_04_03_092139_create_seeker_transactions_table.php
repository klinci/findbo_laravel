<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeekerTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seeker_transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('user_id')->nullable();
			$table->string('charge_id')->nullable();
			$table->string('transaction_id')->nullable();
			$table->dateTime('created_date')->nullable();
			$table->string('status')->nullable();
			$table->float('amount',10,2)->nullable();
			$table->string('currency')->nullable();
			$table->integer('paid')->nullable();
			$table->string('object_id')->nullable();
			$table->string('object')->nullable();
			$table->string('brand')->nullable();
			$table->string('last4')->nullable();
			$table->string('dynamic_last4')->nullable();
			$table->string('funding')->nullable();
			$table->integer('exp_month')->nullable();
			$table->integer('exp_year')->nullable();
			$table->string('fingerprint')->nullable();
			$table->string('name')->nullable();
			$table->longText('address_line1')->nullable();
			$table->longText('address_line2')->nullable();
			$table->string('address_city')->nullable();
			$table->string('address_state')->nullable();
			$table->string('address_zip')->nullable();
			$table->string('address_country')->nullable();
			$table->string('cvc_check')->nullable();
			$table->string('address_line1_check')->nullable();
			$table->string('address_zip_check')->nullable();
			$table->string('failure_code')->nullable();
			$table->longText('failure_message')->nullable();
			$table->longText('description')->nullable();
			$table->integer('seek_package_id')->nullable();
			$table->longText('metadata')->nullable();
			$table->string('receipt_email')->nullable();
			$table->string('receipt_number')->nullable();
			$table->integer('action_by')->nullable();
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
		Schema::dropIfExists('seeker_transactions');
	}
}
