@extends('admin.template.admin_template')



@section('content')
<?php
//dd(\Route::current()->getName());
//dd($controller_name.' --- '.$action_name);
?>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<!-- Main content -->
<section class="content">
     

    <!-- /.row -->
    <div class="row">
    <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Category</h3>
                    </div>
                </div>
            <div class="box-body table-responsive">
                    <!--<div class="box-body table-responsive no-padding">-->
                        <table id="users_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th style="display:none"></th>
                                    <th>Name</th> 
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($category as $category)
                                <tr>
                                    <td style="display:none">YYYY/mm/dd</td>
                                    <td>{{ $category->name }}</td> 
                                    <td><a href="{{url('admin/update_category',$category->id)}}"><i class="fa fa-fw fa-edit"></i></a> | <a href="{{url('admin/delete_category',$category->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td> 
                                   
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th style="display:none"></th>
                                    <th>Pump Name</th> 
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
    </div>
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
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
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
<script src="{{ asset("bower_components/datepicker/bootstrap-datepicker.min.js") }}"></script>
<script src="{{ asset("bower_components/datepicker/daterangepicker.js") }}"></script> 
<script>
$(function () {
    $('#users_list').DataTable();
});
</script>
 
@endsection