<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryToPost extends Model
{
	protected $table = 'blog_category_to_post';
	protected $fillable = [
		'cat_id','post_id'
	];
}
