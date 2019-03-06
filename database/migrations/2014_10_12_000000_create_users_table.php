<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cust_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('city')->nullable();
            $table->string('password')->nullable();
            $table->string('country')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->longText("bio")->nullable();
            $table->string("profile_picture")->nullable();
            $table->integer("newsletter")->nullable();
            $table->integer("active")->nullable();
            $table->string("code")->nullable();
            $table->longText("token")->nullable();
            $table->string("isAdmin")->nullable();
            $table->dateTime("timeJoined")->nullable();
            $table->string("isBan")->nullable();
            $table->string("oauth_uid")->nullable();
            $table->string("oauth_provider")->nullable();
            $table->string("username")->nullable();
            $table->string("twitter_oauth_token")->nullable();
            $table->string("twitter_oauth_token_secret")->nullable();
            $table->integer("userType")->nullable();
            $table->string("temp_hash")->nullable();
            $table->integer("seek_package_id")->nullable();
            $table->dateTime("package_start_date")->nullable();
            $table->dateTime("package_expiry_date")->nullable();
            $table->integer("auto_renew_seek_package")->nullable();
            $table->integer("auto_renew_counter")->nullable();
            $table->integer("is_paid_member")->nullable();
            $table->integer("hunting_email_unsubscribe")->nullable();
            $table->date("sp_renew_tried_date")->nullable();
            $table->string("ip_address")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
