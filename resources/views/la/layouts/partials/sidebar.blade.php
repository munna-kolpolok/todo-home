<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('la-assets/img/user_no_image.jpg') }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        @if(LAConfigs::getByKey('sidebar_search'))
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
	                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        @endif
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- <li class="header">MODULES</li> -->
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url(config('laraadmin.adminRoute')) }}"><i class='fa fa-home'></i> <span>Dashboard</span></a></li>
            
            <!-- Menus -->
            <?php
            $parent_menu_id=Session::get('parent_menu_id');
            if(isset($parent_menu_id)){
                $user_id = Auth::id();

                //echo 'not munna';die();
                // $menuItems = DB::select("SELECT lm.* FROM `role_users` ru
                // inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                // inner join la_menus lm on(lm.`id`=rm.menu_id)
                // WHERE `user_id`=$user_id  
                // and lm.parent=$parent_menu_id 
                // and rm.acc_view='1'
                // and ru.deleted_at is null
                // and rm.deleted_at is null
                // order by lm.hierarchy asc
                // ");

                $menuItems = DB::select("SELECT lm.* FROM `role_users` ru
                inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                inner join la_menus lm on(lm.`id`=rm.menu_id)
                WHERE `user_id`=$user_id  
                and lm.parent=$parent_menu_id 
                and rm.acc_view='1'
                and ru.deleted_at is null
                and rm.deleted_at is null
                group by rm.menu_id
                order by lm.hierarchy asc
                ");

                foreach ($menuItems as $menu){
                    echo LAHelper::print_menu($menu);
                }
            }
            else
            {
                $user_id = Auth::id();
                //echo 'munna';die();
                // $menuItem = DB::select("SELECT lm.* FROM `role_users` ru
                // inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                // inner join la_menus lm on(lm.`id`=rm.menu_id)
                // WHERE `user_id`=$user_id  
                // and lm.parent='0' 
                // and rm.acc_view='1'
                // and rm.deleted_at is null 
                // and ru.deleted_at is null
                // order by lm.hierarchy asc");

                $menuItem = DB::select("SELECT lm.* FROM `role_users` ru
                inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                inner join la_menus lm on(lm.`id`=rm.menu_id)
                WHERE `user_id`=$user_id  
                and lm.parent='0' 
                and rm.acc_view='1'
                and rm.deleted_at is null 
                and ru.deleted_at is null
                group by rm.menu_id
                order by lm.hierarchy asc");
                
                if(count($menuItem)>0)
                {
                    $menuItem=$menuItem[0];
                    $parent_menu_id = $menuItem->id;
                    // $menuItems = DB::select("SELECT lm.* FROM `role_users` ru
                    // inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                    // inner join la_menus lm on(lm.`id`=rm.menu_id)
                    // WHERE `user_id`=$user_id  and lm.parent=$parent_menu_id 
                    // and rm.deleted_at is null
                    // and ru.deleted_at is null
                    // order by lm.hierarchy asc
                    // ");
                    $menuItems = DB::select("SELECT lm.* FROM `role_users` ru
                    inner join role_menu rm on(rm.`role_id`=ru.`role_id`)
                    inner join la_menus lm on(lm.`id`=rm.menu_id)
                    WHERE `user_id`=$user_id  and lm.parent=$parent_menu_id 
                    and rm.acc_view='1'
                    and rm.deleted_at is null
                    and ru.deleted_at is null
                    group by rm.menu_id
                    order by lm.hierarchy asc
                    ");
                    foreach ($menuItems as $menu){
                        echo LAHelper::print_menu($menu);
                    }
                }
                
            }  

            ?>
          
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>