<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_categories', function (Blueprint $table) {
			$table->increments('cat_id');
			$table->string('cat_title')->nullable();
			$table->string('cat_seo_title')->nullable();
			$table->dateTime('cat_created_date')->nullable();
			$table->longText('cat_meta_tags')->nullable();
			$table->longText('cat_meta_description')->nullable();
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
		Schema::dropIfExists('blog_categories');
	}
}
