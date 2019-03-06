<?php

namespace App\Http\Controllers\AdminAuth;

use App\BlogCategoryToPost;

use App\BlogCategories;
use App\BlogPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

class BlogPostController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.blog_post.blog_post');
	}
	
	public function ajaxBlogPosts(Request $request)
	{
		$objPost = new BlogPost();
	
		$objAllBlogPosts = $objPost->getAllBlogPost("","");
	
		$totalData = count($objAllBlogPosts);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$blogPosts = $objPost->getAllBlogPost($start, $limit);
		}
		else
		{
			$search = $request->input('search.value');
			$blogPosts = $objPost->getAllBlogPost($start, $limit);
			$totalFiltered = count($blogPosts);
		}
	
		$data = array();
		if(!empty($blogPosts) && count($blogPosts)>0)
		{
			foreach($blogPosts as $post)
			{
				$nestedData['id'] = $post->post_id;
				$nestedData['name'] = $post->post_title;
				if($post->post_status==1)
				{
					$nestedData['status'] = 'Published';
				}
				else
				{
					$nestedData['status'] = 'Draft';
				}
				$nestedData['created_date'] = date('Y-m-d',strtotime($post->post_created_date));
	
				$edit = '<a href="'.url('admin/blogpost/'.$post->post_id.'/edit').'"><i class="fa fa-pencil-square-o"></i></a>';
				$delete = '<a href="'.url('admin/blogpost/'.$post->post_id.'/destroy').'" onclick="return confirm(\'Are you sure to delete?\')"><i class="fa fa-trash-o"></i></a>';
	
				$nestedData['action'] = $edit.'&nbsp;<span style="margin: 0 2px;color:#ddd;">|</span>&nbsp;'.
						$delete;
	
				$data[] = $nestedData;
			}
		}
	
		$json_data = array(
				"draw"            => intval($request->input('draw')),
				"recordsTotal"    => intval($totalData),
				"recordsFiltered" => intval($totalFiltered),
				"data"            => $data
		);
	
		echo json_encode($json_data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//$objBlogCat = new BlogCategories();
		
		$objBlogCat = DB::table('blog_categories')
					->orderBy('cat_id','ASC')
					->get();
		
		return view('admin.blog_post.create',['blogcats'=>$objBlogCat]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$postTitle = $request->input("post_title");
		$post_seo_title = $postTitle;
		$postDesc = $request->input("post_description");
		$postMetaTags = $request->input("post_meta_tags");
		$postMetaDesc = $request->input("post_meta_description");
		$postCreateDate = $request->input("post_created_date");
		$postStatus = $request->input("post_status");
		$postedById = 37;// Findbo admin        Auth::user()->id;
		$postCategories = $request->input("categories");
		
		$is_post_seo_title_present = false;
		$post_seo_postfix = 0;
		while(!$is_post_seo_title_present)
		{
			$temp_post_seo_title = $post_seo_title;
			if(!empty($post_seo_postfix))
			{	$temp_post_seo_title = $temp_post_seo_title.'-'.$post_seo_postfix;	}
		
			$temp_post_seo_title = preg_replace('~[^\\pL0-9_]+~u', '-', $temp_post_seo_title);
			$temp_post_seo_title = trim($temp_post_seo_title, "-");
			$temp_post_seo_title = iconv("utf-8", "us-ascii//TRANSLIT", $temp_post_seo_title);
			$temp_post_seo_title = strtolower($temp_post_seo_title);
			$temp_post_seo_title = preg_replace('~[^-a-z0-9_]+~', '', $temp_post_seo_title);
				
			$objBlogPost = DB::table("blog_posts")
			->where('post_seo_title','=',$temp_post_seo_title)
			->get();
			if(!empty($objBlogPost) && count($objBlogPost)>0)
			{
				$post_seo_postfix++;
			}
			else
			{
				$is_post_seo_title_present = true;
				$post_seo_title = $temp_post_seo_title;
			}
		}

		$objBlogPost = BlogPost::create([
					'post_title'=>$postTitle,
					'post_seo_title'=>$post_seo_title,
					'post_description'=>$postDesc,
					'post_meta_tags'=>$postMetaTags,
					'post_meta_description'=>$postMetaDesc,
					'post_created_date'=>$postCreateDate,
					'post_status'=>$postStatus,
					'posted_by_id'=>$postedById,
				]);
		$postId = $objBlogPost->id;
		
		if(!empty($postCategories) && count($postCategories)>0)
		{
			foreach($postCategories as $cat)
			{
				BlogCategoryToPost::create([
					'cat_id'=>$cat,
					'post_id'=>$postId
				]);
			}
		}
		
		if(!file_exists("images"))
		{
			@mkdir("images",0777);
		}
		else
		{
			@chmod("images",0777);
		}
		
		if(!file_exists("images/blog"))
		{
			@mkdir("images/blog",0777);
		}
		else
		{
			@chmod("images/blog",0777);
		}
		
		if(!file_exists("images/blog/posts"))
		{
			@mkdir("images/blog/posts",0777);
		}
		else
		{
			@chmod("images/blog/posts",0777);
		}
		
		if($request->file('post_image'))
		{
			$extension = $request->post_image->getClientOriginalExtension();
			$encryptName = md5(uniqid());
			$getimageName = $encryptName.'.'.$extension;
			$request->post_image->move('images/blog/posts', $getimageName);
			
			$uploadedfile =	$request->file('post_image')->getPathName();
			$new_thumb_name = $encryptName . "_thumb." . $extension;
			
			$new_width = 360;
			$new_height = 242;
			
			$originalImage = 'images/blog/posts/'.$getimageName;
			list($width,$height)=getimagesize($originalImage);
			
			$this->make_thumb($originalImage, "images/blog/posts/".$new_thumb_name, $new_width, $new_height, $extension);
			
			$new_width = 766;
			$new_height = $new_width*($height/$width);
			$new_main_filename = $encryptName . "_image." . $extension;
			
			$this->make_thumb($originalImage, "images/blog/posts/".$new_main_filename, $new_width, $new_height, $extension);
			
			DB::table('blog_posts')
				->where('post_id','=',$postId)
				->update([
					'post_image'=>$new_main_filename,
					'post_thumbnail'=>$new_thumb_name
				]);
		}
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record inserted successfully.');
		return redirect('admin/blogpost/index');
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$objBlogPost = DB::table('blog_posts')
						->where('post_id','=',$id)
						->first();
		
		/* $objBlogCat = DB::table('blog_categories')
						->orderBy('cat_id','ASC')
						->get();
		
		$blogPostCat = DB::table('blog_category_to_post')
						->where('post_id','=',$id)
						->get(); */
		
		$objBlogPostCats = new BlogPost();
		$blogCats = $objBlogPostCats->blogPostCategory($id);
		
		return view('admin.blog_post.edit',['blog_post'=>$objBlogPost, 'blogcats'=>$blogCats]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$postTitle = $request->input("post_title");
		$post_seo_title = $request->input("post_seo_title");
		$postDesc = $request->input("post_description");
		$postMetaTags = $request->input("post_meta_tags");
		$postMetaDesc = $request->input("post_meta_description");
		$postCreateDate = $request->input("post_created_date");
		$postStatus = $request->input("post_status");
		$postCategories = $request->input("categories");
		
		$objBlogPost = DB::table('blog_posts')
					->where('post_id','=',$id)
					->update([
						'post_title'=>$postTitle,
						'post_seo_title'=>$post_seo_title,
						'post_description'=>$postDesc,
						'post_meta_tags'=>$postMetaTags,
						'post_meta_description'=>$postMetaDesc,
						'post_created_date'=>$postCreateDate,
						'post_status'=>$postStatus,
				]);
		$postId = $id;
		
		if(!empty($postCategories) && count($postCategories)>0)
		{
			DB::table('blog_category_to_post')
					->where('post_id','=',$id)
					->delete();
					
			foreach($postCategories as $cat)
			{
				BlogCategoryToPost::create([
				'cat_id'=>$cat,
				'post_id'=>$postId
				]);
			}
		}
		
		if(!file_exists("images"))
		{
			@mkdir("images",0777);
		}
		else
		{
			@chmod("images",0777);
		}
		
		if(!file_exists("images/blog"))
		{
			@mkdir("images/blog",0777);
		}
		else
		{
			@chmod("images/blog",0777);
		}
		
		if(!file_exists("images/blog/posts"))
		{
			@mkdir("images/blog/posts",0777);
		}
		else
		{
			@chmod("images/blog/posts",0777);
		}
		
		if($request->file('post_image'))
		{
			$extension = $request->post_image->getClientOriginalExtension();
			$encryptName = md5(uniqid());
			$getimageName = $encryptName.'.'.$extension;
			$request->post_image->move('images/blog/posts', $getimageName);
				
			$uploadedfile =	$request->file('post_image')->getPathName();
			$new_thumb_name = $encryptName . "_thumb." . $extension;
				
			$new_width = 360;
			$new_height = 242;
				
			$originalImage = 'images/blog/posts/'.$getimageName;
			list($width,$height)=getimagesize($originalImage);
				
			$this->make_thumb($originalImage, "images/blog/posts/".$new_thumb_name, $new_width, $new_height, $extension);
			
			$new_width = 766;
			$new_height = $new_width*($height/$width);
			$new_main_filename = $encryptName . "_image." . $extension;
				
			$this->make_thumb($originalImage, "images/blog/posts/".$new_main_filename, $new_width, $new_height, $extension);
				
			DB::table('blog_posts')
			->where('post_id','=',$postId)
			->update([
			'post_image'=>$new_main_filename,
			'post_thumbnail'=>$new_thumb_name
			]);
		}
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record updated successfully.');
		return redirect('admin/blogpost/index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		DB::table('blog_category_to_post')
		->where('post_id','=',$id)
		->delete();
		
		DB::table('blog_posts')
		->where('post_id','=',$id)
		->delete();
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record deleted successfully.');
		return redirect('admin/blogpost/index');
	}
	
	function resizeImage($upfile, $dstfile, $new_width, $new_height, $extension)
	{
		$size = getimagesize($upfile);
		$width = $size[0];
		$height = $size[1];
			
		if ($width > $height)
		{
			$limiting_dim = $height;
		}
		else
		{
			$limiting_dim = $width;
		}
			
		switch (strtolower($extension))
		{
			case 'png':
				$src = ImageCreateFrompng($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagealphablending($dst, false);
					
				// turning on alpha channel information saving (to ensure the full range
				// of transparency is preserved)
				imagesavealpha($dst, true);
				$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
				imagefilledrectangle($dst, 0, 0, $new_width, $new_height, $transparent);
					
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				Imagepng($dst, $dstfile);
				break;
			case 'gif':
				$src = ImageCreateFromGif($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagegif($dst, $dstfile);
				break;
			case 'jpeg':
			case 'jpg':
			default:
				$src = ImageCreateFromJpeg($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imageinterlace( $dst, true);
				imagejpeg($dst, $dstfile, 100);
				break;
		}
	}
	
	function make_thumb($upfile, $dstfile, $new_width, $new_height, $extension)
	{
		$size = getimagesize($upfile);
		$width = $size[0];
		$height = $size[1];
		 
		if ($width > $height)
		{
			$limiting_dim = $height;
		}
		else
		{
			$limiting_dim = $width;
		}
		 
		switch (strtolower($extension))
		{
			case 'png':
				$src = ImageCreateFrompng($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagealphablending($dst, false);
				 
				// turning on alpha channel information saving (to ensure the full range
				// of transparency is preserved)
				imagesavealpha($dst, true);
				$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
				imagefilledrectangle($dst, 0, 0, $new_width, $new_height, $transparent);
				 
				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				Imagepng($dst, $dstfile);
				break;
			case 'gif':
				$src = ImageCreateFromGif($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				imagegif($dst, $dstfile);
				break;
			case 'jpeg':
			case 'jpg':
			default:
				$src = ImageCreateFromJpeg($upfile);
				$dst = ImageCreateTrueColor($new_width, $new_height);
				imagecopyresampled($dst, $src, 0, 0, ($width- $limiting_dim) / 2, ($height - $limiting_dim) / 2, $new_width, $new_height, $limiting_dim, $limiting_dim);
				imageinterlace( $dst, true);
				imagejpeg($dst, $dstfile, 100);
				break;
		}
	}
	
	
}
