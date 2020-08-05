@extends('admin.template.admin_template')



@section('content')
<?php
//dd(\Route::current()->getName());
//dd($controller_name.' --- '.$action_name);
?>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ asset("bower_components/toaster/custom.css") }}">
<link rel="stylesheet" href="{{ asset("bower_components/selecter/select2.min.css") }}">
<link rel="stylesheet" href="{{ asset("bower_components/toaster/pedding.css") }}">
<link rel="stylesheet" href="{{ asset("bower_components/admin-lte/dist/css/AdminLTE.min.css") }}">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add City</h3>
            </div>
             
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ url('admin/add_city') }}" id="employee_form" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="box-body">
                    <div class="form-group">
                        <label for="first_name">City Name</label>
                        <input type="text" class="form-control" name="name" required>
                                
                    </div>
                     
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" id ="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
     <!-- /.row -->
     <div class="row"> 
         <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cities List</h3>
                    </div>
                </div>
            <div class="box-body table-responsive">
                    <!--<div class="box-body table-responsive no-padding">-->
                        <table id="users_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th style="display:none"></th>
                                    <th>City Name</th>   
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($city as $city)
                                <tr>
                                    <td style="display:none">YYYY/mm/dd</td>
                                    <td>{{ $city->name }}</td>     
                                    <td><a href="{{url('admin/update_city',$city->id)}}"><i class="fa fa-fw fa-edit"></i></a> |
                                     <a href="{{url('admin/delete_city',$city->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>
                                     
                                   
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th style="display:none"></th>
                                    <th>City Name</th>  
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
<script src="{{ asset("bower_components/datepicker/daterangepicker.js") }}"></script> 
<!--selectjs-->
<script src="{{ asset("bower_components/selecter/select2.full.min.js") }}"></script>  
<script src="{{ asset("bower_components/moment/moment.js") }}"></script> 
<script>
$(function () {
    $('#users_list').DataTable();
});
</script>
<script>
//Date picker

    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight:'TRUE',
        // startDate: '-0d',
        autoclose: true,
    })
</script>
<script>
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif
</script> 
@endsection