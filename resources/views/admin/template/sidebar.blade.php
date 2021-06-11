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
                    <li class="{{ $action_name == "add_user_view" ? 'active' : '' }}"><a href="{{ url('admin/add_user') }}">Add New</a></li>
                    <li class="{{ $action_name == "users" ? 'active' : '' }}"><a href="{{ url('admin/users') }}">Approved Users</a></li>
                    <li class="{{ $action_name == "pending_user" ? 'active' : '' }}"><a href="{{ url('admin/pending_user') }}">Pending User</a></li>
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
                    <li class="{{ $action_name == "add_sms" ? 'active' : '' }}"><a href="{{ url('admin/add_sms') }}">Add SMS</a></li>
                    <li class="{{ $action_name == "sms_list" ? 'active' : '' }}"><a href="{{ url('admin/sms_list') }}">SMS List</a></li>  
                    <li class="{{ $action_name == "add_donar" ? 'active' : '' }}"><a href="{{ url('admin/add_donar') }}">Add Donor</a></li>  
                    <li class="{{ $action_name == "customer_list" ? 'active' : '' }}"><a href="{{ url('admin/customer_list') }}">Donor List</a></li>  
                    <li class="{{ $action_name == "donation" ? 'active' : '' }}"><a href="{{ url('admin/donation') }}">Add Donation</a></li>
                    <li class="{{ $action_name == "show_donation" ? 'active' : '' }}"><a href="{{ url('admin/show_donation') }}">Donation List</a></li>
                    <li class="{{ $action_name == "assign_list" ? 'active' : '' }}"><a href="{{ url('admin/assign_list') }}">Assign List</a></li>
                </ul>
            </li> 
            <li class="{{ $controller_name == "IncentiveController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "add_incentive" ? 'active' : '' }}"><a href="{{ url('admin/add_incentive') }}">Add Incentive</a></li>
                    <li class="{{ $action_name == "incentive_list" ? 'active' : '' }}"><a href="{{ url('admin/incentive_list') }}">Incentive List</a></li>
                    <li class="{{ $action_name == "incentive_report" ? 'active' : '' }}"><a href="{{ url('admin/incentive_report') }}">Incentive Report</a></li> 
                    <li class="{{ $action_name == "collection_report" ? 'active' : '' }}"><a href="{{ url('admin/collection_report') }}">Collection List Report</a></li> 
                </ul>
            </li> 
            
             
             
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>