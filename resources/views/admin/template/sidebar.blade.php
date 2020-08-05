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
            <!-- Optionally, you can add icons to the links -->
<!--            <li class="active"><a href="#"><i class="fa fa-link"></i> <span>Users Management</span></a></li>
            <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>-->
            <li class="{{ $controller_name == "DashboardController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "add_user_view" ? 'active' : '' }}"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                     
                </ul>
            </li>
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
                </ul>
            </li>
            
            <li class="{{ $controller_name == "BillingController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Invoice</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "city" ? 'active' : '' }}"><a href="{{ url('admin/city') }}">Add Cities</a></li> 
                    <li class="{{ $action_name == "invoice" ? 'active' : '' }}"><a href="{{ url('admin/invoice') }}">Create Invoice</a></li> 
                    <li class="{{ $action_name == "invoice_list" ? 'active' : '' }}"><a href="{{ url('admin/invoice_list') }}">Invoice List</a></li> 
                
                </ul>
            </li> 
            <li class="{{ $controller_name == "InventoryController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Inventory</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "vendor" ? 'active' : '' }}"><a href="{{ url('admin/vendor') }}">Add Vendor</a></li> 
                    <li class="{{ $action_name == "product" ? 'active' : '' }}"><a href="{{ url('admin/product') }}">Add Product</a></li> 
                    <li class="{{ $action_name == "place_order" ? 'active' : '' }}"><a href="{{ url('admin/place_order') }}">Place Order</a></li>
                    <li class="{{ $action_name == "view_place_order" ? 'active' : '' }}"><a href="{{ url('admin/view_place_order') }}">Place Order Report</a></li>    
                
                
                </ul>
            </li>

            <li class="{{ $controller_name == "VendorPaymentController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-group"></i> <span>Vendor Payment</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "show" ? 'active' : '' }}"><a href="{{ url('admin/show') }}">Vendor Payment</a></li>   
                    <li class="{{ $action_name == "vendor_payment_report" ? 'active' : '' }}"><a href="{{ url('admin/vendor_payment_report') }}">Vendor Payment Report</a></li>   
                
                </ul>
            </li>
            <li class="{{ $controller_name == "FinanceController" ? 'active' : '' }} treeview">
                <a href="#"><i class="fa fa-money"></i> <span>Finance</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $action_name == "get_statement" ? 'active' : '' }}"><a href="{{ url('admin/statement') }}">Statement</a></li>
                    <li class="{{ $action_name == "get-payment-receipt" ? 'active' : '' }}"><a href="{{ url('admin/get-payment-receipt') }}">Payment Receipt</a></li>
                    <li class="{{ $action_name == "get-payment-balance" ? 'active' : '' }}"><a href="{{ url('admin/get-payment-balance') }}">Add Old balance</a></li>
                </ul>
            </li>
             
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>