<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("bower_components/admin-lte/dist/img/user-512-160x160.png") }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->first_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu</li>
            <li class="{{ $controller_name == "UserController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Users Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "add_user_view" ? 'active' : '' }}"><a href="{{ url('executive/update_password/' . Auth::user()->id ) }}">Update Password</a></li>
                    
                </ul>
            </li> 
             
            <li class="{{ $controller_name == "DonationsController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Donation</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ $action_name == "donation" ? 'active' : '' }}"><a href="{{ url('executive/donation') }}">Add Donation</a></li> 
                    <li class="{{ $action_name == "show_donation" ? 'active' : '' }}"><a href="{{ url('executive/show_donation') }}">Donation List</a></li> 
                    <li class="{{ $action_name == "assign_list" ? 'active' : '' }}"><a href="{{ url('executive/assign_list') }}">Assign List</a></li> 
                </ul>
            </li> 
            
             
             
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>