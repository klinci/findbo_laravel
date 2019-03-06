<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('properties', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type')->nullable();
			$table->string('size')->nullable();
			$table->integer('bedrooms')->nullable();
			$table->integer('bathrooms')->nullable();
			$table->integer('garage')->nullable();
			$table->integer('parking_place')->nullable();
			$table->integer('pets_allowed')->nullable();
			$table->string('pets_comment')->nullable();
			$table->integer('furnished')->nullable();
			$table->integer('basement')->nullable();
			$table->integer('entry_phone')->nullable();
			$table->string('thumbnail')->nullable();
			$table->date('date_published')->nullable();
			$table->integer('user_id')->nullable();
			$table->string('price_usd')->nullable();
			$table->string('price_dk')->nullable();
			$table->integer('area_id')->nullable();
			$table->string('location1')->nullable();
			$table->string('location2')->nullable();
			$table->string('address')->nullable();
			$table->integer('zip_code_id')->nullable();
			$table->longText('description_eng')->nullable();
			$table->integer('package_type_id')->nullable();
			$table->dateTime('package_start_date')->nullable();
			$table->dateTime('package_expiry_date')->nullable();
			$table->string('floor_side')->nullable();
			$table->string('headline_dk')->nullable();
			$table->string('headline_eng')->nullable();
			$table->string('prop_seo_title')->nullable();
			$table->longText('description_dk')->nullable();
			$table->string('rental_period')->nullable();
			$table->string('action')->nullable();
			$table->string('housenum')->nullable();
			$table->string('floor')->nullable();
			$table->string('phonenum1')->nullable();
			$table->string('phonenum2')->nullable();
			$table->string('vacant')->nullable();
			$table->integer('shareFriendly')->nullable();
			$table->integer('handicapFriendly')->nullable();
			$table->integer('youthHousing')->nullable();
			$table->string('seniorFriendly')->nullable();
			$table->integer('rooms')->nullable();
			$table->string('rentDeposit')->nullable();
			$table->string('prepaidRent')->nullable();
			$table->integer('expenses')->nullable();
			$table->integer('balcony')->nullable();
			$table->integer('lift')->nullable();
			$table->integer('garden')->nullable();
			$table->integer('scenic')->nullable();
			$table->integer('sea')->nullable();
			$table->integer('near_sea')->nullable();
			$table->integer('near_forest')->nullable();
			$table->integer('business_contact')->nullable();
			$table->integer('business_contract')->nullable();
			$table->string('status')->nullable();
			$table->integer('is_available')->nullable();
			$table->integer('is_featured_property')->nullable();
			$table->dateTime('rented_date')->nullable();
			$table->string('groundarea')->nullable();
			$table->string('year')->nullable();
			$table->string('energy')->nullable();
			$table->string('payment')->nullable();
			$table->string('gross')->nullable();
			$table->string('net')->nullable();
			$table->string('company_name')->nullable();
			$table->string('email')->nullable();
			$table->string('email2')->nullable();
			$table->string('vacantDate')->nullable();
			$table->string('openHouseAddress')->nullable();
			$table->longText('openHouseComment')->nullable();
			$table->string('openHouseEndTime')->nullable();
			$table->string('openHouseStartTime')->nullable();
			$table->date('openHouseDate')->nullable();
			$table->string('downpayment')->nullable();
			$table->string('prop_site_name')->nullable();
			$table->longText('prop_url')->nullable();
			$table->longText('property_url')->nullable();
			$table->tinyInteger('is_from_scrap')->nullable();
			$table->integer('auto_id')->nullable();
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
		Schema::dropIfExists('properties');
	}
}
