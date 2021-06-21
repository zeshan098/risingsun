@extends('finance.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href='{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}'>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Report</h3>
                </div>
                <!-- /.box-header -->
            <form method="POST" action="{{ url('finance/incentive_reporting') }}" class="form">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="box-body">
                
                    
                    
                    <div class="form-group">
                        <label for="first_name">From Date:</label>
                        <input type="text" class="form-control pull-right datepicker"
                                       name="from_date" autocomplete="off" id="datepicker" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">To Date:</label>
                        <input type="text" class="form-control pull-right datepickers"
                                       name="to_date" autocomplete="off" id="datepicker" required>
                    </div> 
                    
                   
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
               
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
<script src='{{ asset("bower_components/datatables.net/js/jquery.dataTables.min.js") }}'></script>
<script src='{{ asset("bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js") }}'></script>
<!-- SlimScroll -->
<script src='{{ asset("bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}'></script>
<!-- FastClick -->
<script src='{{ asset("bower_components/fastclick/lib/fastclick.js") }}'></script>
<!-- AdminLTE App -->
<!--<script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src='{{ asset("bower_components/admin-lte/dist/js/demo.js") }}'></script>
<!-- page script -->

<script src='{{ asset("bower_components/datepicker/bootstrap-datepicker.min.js") }}'></script>
<script src='{{ asset("bower_components/datepicker/daterangepicker.js") }}'></script>
<script>
    $(function () {
        $('#users_list').DataTable({
            responsive: true,
            autoWidth: false,
            "scrollX": true,
        });
    });
</script>
<script>
//Date picker

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
    })
    $('.datepickers').datepicker({
        format: 'yyyy-mm-dd',
    })
</script>

 
@endsection