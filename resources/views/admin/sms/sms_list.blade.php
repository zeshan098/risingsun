@extends('admin.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">SMS Lists</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                <!--<div class="box-body table-responsive no-padding">-->
                    <table id="users_list" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Payment Type</th>
                                <th>Donation Type</th> 
                                <th>SMS TEXT</th> 
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sms_list as $sms_list)
                            <tr> 
                                <td>{{ $sms_list->payment_type }}</td>
                                <td>{{ $sms_list->donation_type }}</td> 
                                <td>{{ $sms_list->sms_text }}</td> 
                                <td><a href="{{url('admin/update_sms',$sms_list->id)}}"><i class="fa fa-edit fa-2" aria-hidden="true"></i></a> ||
                                <a href="{{url('admin/delete_sms',$sms_list->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>
                                 
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