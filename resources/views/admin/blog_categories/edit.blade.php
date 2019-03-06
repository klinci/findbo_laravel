@extends('admin.layout.index')

@section('pageTitle', 'Edit Category')

@section('content')
<div class="clearfix midpart">
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="maintitle">
				<h3 class="topspace">Edit Category</h3>
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
						
						<form class="form-horizontal form-label-left" name="frmBlogCategories" id="frmBlogCategories" action="{{ url('admin/blogcategories/'.$cats->cat_id) }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							
							<input type="hidden" name="id" id="id" value="{{ $cats->cat_id }}">
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Category Title <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="cat_title" name="cat_title" class="form-control" type="text" value="{{ $cats->cat_title }}" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">SEO Title <span class="required">*</span></label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<input id="cat_seo_title" name="cat_seo_title" class="form-control" type="text" value="{{ $cats->cat_seo_title }}" />
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Category Meta Tags</label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<textarea name="cat_meta_tags" id="cat_meta_tags" class="form-control">{{ $cats->cat_meta_tags }}</textarea>
								</div>
							</div>
							
							<div class="item form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Category Meta Descriptions </label>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<textarea name="cat_meta_description" id="cat_meta_description" class="form-control">{{ $cats->cat_meta_description }}</textarea>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-4 col-md-6 col-md-offset-4">
									<button id="btnCat" name="btnCat" type="submit" class="btn btn-success">Submit</button>
									<button id="btnCat" name="btnCat" type="button" class="btn btn-primary" onclick="location.href='{{ url('admin/blogcategories/index')}}'">Cancel</button>
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
<script src="{{ asset('public/admin/js/jquery.validate.js') }}"></script>
<script type="text/javascript">
$(document).ready(function () {
	$("#frmBlogCategories").validate({
		rules: {
			"cat_title": {
				required: true
			},
			"cat_seo_title": {
				required: true
			}
		},
		messages: {
			"cat_title": {
				required: "Please enter category title."
			},
			"cat_seo_title": {
				required: "Please enter category seo title."
			}
		}
	});
});
</script>
@endsection