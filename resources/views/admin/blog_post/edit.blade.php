@extends('admin.layout.index')

@section('pageTitle', 'Edit New Blog Post')

@section('styles')
<link rel="stylesheet" href="{{ asset('public/admin/js/jquery-ui-1.11.4.custom/jquery-ui.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('public/admin/js/timepicker/jquery-ui-timepicker-addon.css') }}" type="text/css" />
@endsection

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Edit New Blog Post</h3>
			</div>
			
			<div class="x_panel">
				<div class="row">
					<div class="col-md-12  col-sm-12 ptp10">
						@if(session()->has('message.level'))
						    <div class="alert alert-{{ session('message.level') }}"> 
						    {!! session('message.content') !!}
						    </div>
						@endif
					</div>
					
					<div class="clearfix"></div>
					
					<div class="col-md-12  col-sm-12 ptp10">
						
						<form class="form-horizontal form-label-left" name="frmBlogPost" id="frmBlogPost" action="{{ url('admin/blogpost/'.$blog_post->post_id) }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Post Title <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="post_title" name="post_title" class="form-control" type="text" value="{{ $blog_post->post_title }}" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Post SEO Title <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="post_seo_title" name="post_seo_title" class="form-control" type="text" value="{{ $blog_post->post_seo_title }}" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Description <span class="required">*</span></label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea name="post_description" id="post_description" class="form-control">{{ $blog_post->post_description }}</textarea>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Post Meta Tags</label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<textarea name="post_meta_tags" id="post_meta_tags" class="form-control">{{ $blog_post->post_meta_tags }}</textarea>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Post Meta Descriptions</label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<textarea name="post_meta_description" id="post_meta_description" class="form-control">{{ $blog_post->post_meta_description }}</textarea>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Status</label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<select name="post_status" id="post_status" class="form-control">
										<option value="0" {{ ($blog_post->post_status=='0')?" selected='selected'":""}}>Draft</option>
		                                <option value="1" {{ ($blog_post->post_status=='1')?" selected='selected'":""}}>Publish</option>
									</select>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Date</label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="post_created_date" name="post_created_date" class="form-control" type="text" value="{{ $blog_post->post_created_date }}" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Categories</label>
								<div class="col-md-4 col-sm-6 col-xs-12" >
									@if(!empty($blogcats) && count($blogcats)>0)
										@foreach($blogcats as $blogCat)
											<div class="form-check">
												<input type="checkbox" name="categories[]" class="form-check-input" id="cat_{{ $blogCat['cat_id'] }}" value="{{ $blogCat['cat_id'] }}" {{ ($blogCat['is_checked']==1)?' checked="checked"':''}}>
												<label class="form-check-label" for="cat_{{ $blogCat['cat_id'] }}"> {{ $blogCat['cat_title'] }}</label>
											</div>
										@endforeach
									@endif
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Featured Image  <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="post_image" name="post_image" class="form-control" type="file" value="" />
									@if($blog_post->post_image!="")
										<br>
										<img src="{{ asset('images/blog/posts/'.$blog_post->post_image) }}" width="150" />
									@endif
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-4">
									<button id="btnPost" name="btnPost" type="submit" class="btn btn-success">Submit</button>
									<button type="button" class="btn btn-primary" onclick="location.href='{{ url('admin/blogpost/index')}}'">Cancel</button>
								</div>
							</div>
											
						</form>
					
					</div>
				</div>
			</div>
		</div>
		<!-- Dashboard End -->
	</div>
</div>
@endsection

@section('scripts')

<script src="{{ asset('public/admin/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('public/admin/ckeditor/sample.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/admin/ckeditor/config.js') }}" type="text/javascript"></script>
  
  
<script src="{{ asset('public/admin/js/jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('public/admin/js/timepicker/jquery-ui-timepicker-addon.js') }}"></script>
  
<script src="{{ asset('public/admin/js/jquery.validate.js') }}"></script>
<script src="{{ asset('public/admin/js/additional-methods.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {

	$('#post_created_date').datetimepicker({dateFormat: "yy-mm-dd"});


	//<![CDATA[ 
	// This call can be placed at any point after the
	// <textarea>, or inside a <head><script> in a
	// window.onload event handler.

	// Replace the <textarea id="editor"> with an CKEditor
	// instance, using default configurations.
	CKEDITOR.replace('post_description',
    {
        filebrowserBrowseUrl :"{{ asset('public/admin/ckeditor/filemanager/browser/default/browser.html?Connector=public/admin/ckeditor/filemanager/connectors/php/connector.php') }}",
        filebrowserImageBrowseUrl : "{{ asset('public/admin/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=public/admin/ckeditor/filemanager/connectors/php/connector.php') }}",
        filebrowserFlashBrowseUrl :"{{ asset('public/admin/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=public/admin/ckeditor/filemanager/connectors/php/connector.php') }}",
		filebrowserUploadUrl  :"{{ asset('public/admin/ckeditor/filemanager/connectors/php/upload.php?Type=File') }}",
		filebrowserImageUploadUrl : "{{ asset('public/admin/ckeditor/filemanager/connectors/php/upload.php?Type=Image') }}",
		filebrowserFlashUploadUrl : "{{ asset('public/admin/ckeditor/filemanager/connectors/php/upload.php?Type=Flash') }}" 
	}); 
	
	//]]>

	$("#frmBlogPost").validate({
		rules: {
			"post_title": {
				required: true
			},
			"post_seo_title": {
				required: true
			},
			"post_description": {
				required: true
			},
			"post_image": {
				extension: "jpg|jpeg|png|bmp|gif"
			}
		},
		messages: {
			"post_title": {
				required: "Please enter post title."
			},
			"post_seo_title": {
				required: "Please enter post seo title."
			},
			"post_description": {
				required: "Please enter post description."
			},
			"post_image": {
				extension: "Only allow jpg, jpeg, png, bmp and gif files allowed."
			}
		}
	});
});
</script>
@endsection