@extends('executive.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Assign Lists</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                <!--<div class="box-body table-responsive no-padding">-->
                    <table id="users_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Receipt Track Number</th>
                                <th>Date</th>
                                <th>Name</th> 
                                <th>Phone #</th>
                                <th>Rupees</th> 
                                <th>Amount Type</th> 
                                <th>Payment Type</th> 
                                <th>Donation Type</th>
                                <th>User Name</th> 
                                <th>Status</th>  
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($assign_list as $show_donation)
                            <tr>
                            
                                <td><a href="{{route('executive.view_donation',$show_donation->id)}}">{{ $show_donation->receipt }}</a></td>
                                <td>{{ date('d-m-Y', strtotime($show_donation->enter_date))}}</td>
                                <td>{{ $show_donation->custname }}</td>
                                <td>{{ $show_donation->phone_no }}</td>
                                <td>{{ $show_donation->rupees }}</td>
                                <td>{{ $show_donation->amount_type }}</td>
                                <td>{{ $show_donation->payment_type }}</td>
                                <td>{{ $show_donation->donation_type }}</td>
                                <td>{{ $show_donation->first_name  }}</td>
                                <td>{{ $show_donation->status  }}</td> 
                                <td><a href="{{url('executive/edit_donation',$show_donation->id)}}">Edit</a> || 
                                <a href="{{url('executive/delete_donation',$show_donation->id)}}">Delete</a></td> 
                                 
                            </tr>
                        @endforeach
                        </tbody>
                         
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- jQuery 3 -->
<!--<script src="/bower_components/jquery/dist/jquery.min.js"></script>-->
<!-- Bootstrap 3.3.7 -->
<!--<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<!-- DataTables -->
<script src="{{ asset("bower_components/datatables.net/js/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js") }}"></script>
<!-- SlimScroll -->
<script src="{{ asset("bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}"></script>
<!-- FastClick -->
<script src="{{ asset("bower_components/fastclick/lib/fastclick.js") }}"></script>
<!-- AdminLTE App -->
<!--<script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset("bower_components/admin-lte/dist/js/demo.js") }}"></script>
<!-- page script -->
<script>
    $(function () {
        $('#users_list').DataTable({
            responsive: true,
            autoWidth: false,
            "scrollX": true,
        });
    });
</script>
@endsection