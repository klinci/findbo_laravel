<div style="min-width: 55px; max-width: 55px;" id="sidemenu">
	<ul class="nav-new" id="menu">
		<li><a class="logo-main" href="{{ url('admin/home') }}"><img src="{{ asset('public/admin/images/logo.png') }}" alt="FindBO" class="img-responsive"> </a></li>
		<li><a href="{{ url('admin/home') }}"> <i class="fa fa-dashboard"></i>Home</a></li>
		<li>
			<a>
				<i class="fa fa-building-o"></i> Properties<span class="caret" style="display: none;"></span> 
			</a>
			<ul style="display: none">
				<li class="menucls"><a href="{{ url('admin/properties/allproperties') }}">All Properties</a></li>
				<li class="menucls"><a href="{{ url('add_property') }}" target="_blank">Add Property</a></li>
				<li class="menucls"><a href="{{ url('admin/properties/pendingproperties') }}">Pending</a></li>
				<li class="menucls"><a href="{{ url('admin/properties/rejectedproperties') }}">Rejected</a></li>
			</ul>
		</li>
		<li>
			<a>
				<i class="fa fa-home"></i> Seek Ads<span class="caret" style="display: none;"></span> 
			</a>
			<ul style="display: none">
				<li class="menucls"><a href="{{ url('admin/seekads/index') }}">All Seek Ads</a></li>
			</ul>
		</li>
		<li>
			<a>
				<i class="fa fa-user"></i> Users<span class="caret" style="display: none;"></span> 
			</a>
			<ul style="display: none">
				<li class="menucls"><a href="{{ url('admin/users/index') }}">User List Page</a></li>
			</ul>
		</li>
		
		<li>
			<a>
				<i class="fa fa-filter"></i> Search Filters<span class="caret" style="display: none;"></span> 
			</a>
			<ul style="display: none">
				<li class="menucls"><a href="{{ url('admin/area/index') }}">Area Page</a></li>
				<li class="menucls"><a href="{{ url('admin/zipcode/index') }}">Zipcode Page</a></li>
				<li class="menucls"><a href="{{ url('admin/rental_period/index') }}">Rental Period Page</a></li>
			</ul>
		</li>
		
		<li>
			<a>
				<i class="fa fa-bold"></i> Blog<span class="caret" style="display: none;"></span> 
			</a>
			<ul style="display: none">
				<li class="menucls"><a href="{{ url('admin/blogcategories/index') }}">Categories</a></li>
				<li class="menucls"><a href="{{ url('admin/blogpost/create') }}">Add New Post</a></li>
				<li class="menucls"><a href="{{ url('admin/blogpost/index') }}">All Posts</a></li>
			</ul>
		</li>
		
	</ul>
</div>