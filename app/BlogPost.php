<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;

class BlogPost extends Model
{
	protected $fillable = [
	'post_title','post_seo_title','post_description','post_meta_tags','post_meta_description','post_created_date','post_status','posted_by_id','post_image','post_thumbnail'
			];

	public function getAllBlogPost($start="",$limit="")
	{
		if($start=="" && $limit=="")
		{
			$blogPosts = DB::table('blog_posts')
			->join('users','users.id','=','blog_posts.posted_by_id')
			->orderBy('post_id','desc')
			->get();
		}
		else
		{
			$blogPosts = DB::table('blog_posts')
			->join('users','users.id','=','blog_posts.posted_by_id')
			->offset($start)
			->limit($limit)
			->orderBy('post_id','desc')
			->get();
		}
			
		return $blogPosts;
	}

	public function blogPostCategory($postId=0)
	{
		$arrOfBlogCat = array();

		$objBlogCat = DB::table('blog_categories')
					->orderBy('cat_id','ASC')
					->get();
		if(!empty($objBlogCat) && count($objBlogCat)>0)
		{
			foreach($objBlogCat as $blogCat)
			{
				$isChecked = 0;
				if($postId > 0)
				{
					$objPostCat = DB::table('blog_category_to_post')
					->where('cat_id','=',$blogCat->cat_id)
					->where('post_id','=',$postId)
					->first();
					if(!empty($objPostCat) && count($objPostCat)>0)
					{
						$isChecked = 1;
					}
				}

				$arrOfBlogCat[] = array(
						'cat_id'=>$blogCat->cat_id,
						'cat_title'=>$blogCat->cat_title,
						'is_checked'=>$isChecked
				);

			}
		}
		return $arrOfBlogCat;
	}

	public function user() {
		return $this->belongsTo('App\User', 'posted_by_id');
	}

	public function getShortDescriptionAttribute() {
		if (strlen($this->attributes['post_description']) > 200)
			return strip_tags(substr($this->attributes['post_description'], 0, 200)) . '...';
		return strip_tags($this->attributes['post_description']);
	}

	public function getDateAttribute() {
		return date("M d, Y", strtotime($this->attributes['post_created_date']));
	}

	public function getDescriptionAttribute() {
		return html_entity_decode($this->attributes['post_description']);
	}

	public function getPostedByNameAttribute() {
		return $this->user->fname . ' ' . $this->user->lname;
	}

}
