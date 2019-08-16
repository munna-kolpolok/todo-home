<!-- Main Header -->
<header class="main-header">

	@if(LAConfigs::getByKey('layout') != 'layout-top-nav')
	<!-- Logo -->
	<a href="{{ url(config('laraadmin.adminRoute')) }}" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
		 {{ LAConfigs::getByKey('sitename_part2') }}</span>
	</a>
	@endif

	<!-- Header Navbar -->
	<nav class="navbar navbar-static-top" role="navigation">

	<?php
		$user_id = Auth::id();

		// $menuItems = DB::select("SELECT lm.* FROM `role_users` ru
		// inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
		// inner join la_menus lm on(lm.`id`=rm.menu_id)
		// WHERE `user_id`=$user_id  
		// and lm.parent='0' 
	 //    and rm.acc_view='1'
		// and rm.deleted_at is null 
		// and ru.deleted_at is null
		// order by lm.hierarchy asc");

		$menuItems = DB::select("SELECT lm . *
		FROM  `role_users` ru
		INNER JOIN role_menu rm ON ( rm.`role_id` = ru.`role_id` ) 
		INNER JOIN la_menus lm ON ( lm.`id` = rm.menu_id ) 
		WHERE  `user_id` =$user_id
		AND lm.parent =  '0'
		AND rm.acc_view =  '1'
		AND rm.deleted_at IS NULL 
		AND ru.deleted_at IS NULL 
		group by rm.menu_id
		ORDER BY lm.hierarchy ASC ");

	?>
	
	@if(LAConfigs::getByKey('layout') == 'layout-top-nav')
		<div class="container">

			<div class="navbar-header">
				<a href="{{ url(config('laraadmin.adminRoute')) }}" class="navbar-brand"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>{{ LAConfigs::getByKey('sitename_part2') }}</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			</div>
			@include('la.layouts.partials.top_nav_menu')
			@include('la.layouts.partials.notifs')
		</div><!-- /.container-fluid -->
	@else
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle b-l" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
			<i class="fa fa-bars"></i>
		</button>
		<div class="navbar-collapse collapse" id="bs-example-navbar-collapse-1" style="float: left">
			  <ul class="nav navbar-nav">
                
                @foreach ($menuItems as $menu)
					<li><a href="{{ url(config('laraadmin.adminRoute')).'/module/'.$menu->id }}" >{{ Lang::get('messages.'.$menu->name) }}</a></li>
				@endforeach
				              	
			  </ul>
        </div>


		@include('la.layouts.partials.notifs')
	@endif
	
	</nav>
</header>
