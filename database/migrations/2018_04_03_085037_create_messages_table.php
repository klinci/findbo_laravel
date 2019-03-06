<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function (Blueprint $table) {
			$table->increments('id');
			$table->longText('message_text')->nullable();
			$table->dateTime('time')->nullable();
			$table->integer('conversation_fk')->nullable();
			$table->integer('user_sender_fk')->nullable();
			$table->integer('user_receiver_fk')->nullable();
			$table->string('isSeen')->nullable();
			$table->integer('relatedProperty')->nullable();
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
		Schema::dropIfExists('messages');
	}
}
