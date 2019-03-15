<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBirchejendommeUrlsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
        Schema::create('birchejendomme_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('property_url');
            $table->integer('is_synced');
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
  	Schema::dropIfExists('birchejendomme_urls');
  }
}
