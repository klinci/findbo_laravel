<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogCategories extends Model
{
	protected $fillable = [
		'cat_title','cat_seo_title','cat_created_date','cat_meta_tags','cat_meta_description'
	];
	
	public function getAllBlogCategories($start="",$limit="")
	{
		if($start=="" && $limit=="")
		{
			$blogCategories = DB::table('blog_categories')
						->orderBy('cat_id','desc')
						->get();
		}
		else
		{
			$blogCategories = DB::table('blog_categories')
						->offset($start)
						->limit($limit)
						->orderBy('cat_id','desc')
						->get();
		}
			
		return $blogCategories;
	}
	
	public function getBlogCatById($id)
	{
		return DB::table('blog_categories')
				->where('cat_id','=',$id)
				->first();
	}
}
