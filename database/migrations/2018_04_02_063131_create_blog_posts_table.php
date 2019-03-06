<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_posts', function (Blueprint $table) {
			$table->increments('post_id');
			$table->string("post_title")->nullable();
			$table->string("post_seo_title")->nullable();
			$table->longText("post_description")->nullable();
			$table->longText("post_meta_tags")->nullable();
			$table->longText("post_meta_description")->nullable();
			$table->dateTime("post_created_date")->nullable();
			$table->integer("post_status")->nullable();
			$table->integer("posted_by_id")->nullable();
			$table->string("post_image")->nullable();
			$table->string("post_thumbnail")->nullable();
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
		Schema::dropIfExists('blog_posts');
	}
}
