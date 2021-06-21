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
             
             
            <li class="{{ $controller_name == "IncentiveController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu"> 
                    <li class="{{ $action_name == "incentive_report" ? 'active' : '' }}"><a href="{{ url('finance/incentive_report') }}">Incentive Report</a></li> 
                    <li class="{{ $action_name == "collection_report" ? 'active' : '' }}"><a href="{{ url('finance/collection_report') }}">Collection List Report</a></li> 
                    <li class="{{ $action_name == "resource_report" ? 'active' : '' }}"><a href="{{ url('finance/resource_report') }}">Resource Report</a></li> 
                </ul>
            </li> 
            
             
             
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>