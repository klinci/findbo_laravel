<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogCategories;
use Illuminate\Support\Facades\DB;

class BlogCategoriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.blog_categories.blog_categories');
	}
	
	public function ajaxBlogCategories(Request $request)
	{
		$objCat = new BlogCategories();
	
		$objAllBlogCategories = $objCat->getAllBlogCategories("","");
	
		$totalData = count($objAllBlogCategories);
		$totalFiltered = $totalData;
	
		$limit = $request->input('length');
		$start = $request->input('start');
	
		if(empty($request->input('search.value')))
		{
			$blogCategories = $objCat->getAllBlogCategories($start, $limit);
		}
		else
		{
			$search = $request->input('search.value');
			$blogCategories = $objCat->getAllBlogCategories($start, $limit);
			$totalFiltered = count($blogCategories);
		}
	
		$data = array();
		if(!empty($blogCategories) && count($blogCategories)>0)
		{
			foreach($blogCategories as $post)
			{
				$nestedData['id'] = $post->cat_id;
				$nestedData['name'] = $post->cat_title;
				
				$edit = '<a href="'.url('admin/blogcategories/'.$post->cat_id.'/edit').'"><i class="fa fa-pencil-square-o"></i></a>';
				$delete = '<a href="'.url('admin/blogcategories/'.$post->cat_id.'/destroy').'" onclick="return confirm(\'Are you sure to delete?\')"><i class="fa fa-trash-o"></i></a>';
				
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
		return view('admin.blog_categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {		
		BlogCategories::create([
			'cat_title' => $request->cat_title,
			'cat_seo_title' => $request->cat_title,
			'cat_created_date' => date('Y-m-d H:i:s'),
			'cat_meta_tags' => $request->cat_meta_tags,
			'cat_meta_description' => $request->cat_meta_description,
		]);

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record inserted successfully.');
		return redirect('admin/blogcategories/index');
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
		$objCat = new BlogCategories();
		$cats = $objCat->getBlogCatById($id);
		
		return view('admin.blog_categories.edit',['cats'=>$cats]);
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
		$postCatTitle = $request->input("cat_title");
		$postSeoTitle = $request->input("cat_seo_title");
		$postCatMetaTags = $request->input("cat_meta_tags");
		$postCatMetaDesc = $request->input("cat_meta_description");
		
		DB::table('blog_categories')
				->where('cat_id','=',$id)
				->update([
					'cat_title'=>$postCatTitle,
					'cat_seo_title'=>$postSeoTitle,
					'cat_meta_tags'=>$postCatMetaTags,
					'cat_meta_description'=>$postCatMetaDesc
				]);
		
		
		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record updated successfully.');
		return redirect('admin/blogcategories/index');
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{
		DB::table('blog_categories')
				->where('cat_id','=',$id)
				->delete();

		$request->session()->flash('message.level', 'success');
		$request->session()->flash('message.content', 'Record deleted successfully.');
		return redirect('admin/blogcategories/index');
	}
}
