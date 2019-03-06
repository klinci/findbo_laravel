<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;

class BlogController extends Controller
{
	/**
	* Shows all blog posts
	*
	* @return void
	*/
    public function index() {
    	return view('blog', [
            'posts' => BlogPost::orderBy('post_created_date', 'desc')->get(),
            'latest' => BlogPost::orderBy('post_created_date', 'desc')->take(3)->get(),
        ]);
    }

    /**
    * Shows a single blog post with a given ID.
    *
    * @param int  $id
    * @return void
    */
    public function show($id) {
    	return view('blogpost', [
            'post' => BlogPost::where('post_seo_title', $id)->first(),
            'latest' => BlogPost::orderBy('post_created_date', 'desc')->take(3)->get()
        ]);
    }

}
