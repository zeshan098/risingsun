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
                <h3 class="box-title">Customer Detail</h3>
            </div>
             
            <!-- /.box-header -->
            <!-- form start -->
            <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#contact-modal">Add customer</button>
            <!-- <a data-toggle="modal" data-target="#contact-modal" style="top: 4px;position: relative;">
                                            <span class="glyphicon glyphicon-plus-sign"></span>
                                        </a> -->
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
                                    <th>Customer Name</th>   
                                    <th>Company Name</th> 
                                    <th>Phone Number</th> 
                                    <th>City</th> 
                                    <th>Shop Address</th> 
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($customer_list as $customer_list)
                                <tr>
                                    <td style="display:none">YYYY/mm/dd</td>
                                    <td>{{ $customer_list->cust_name }}</td>   
                                    <td>{{ $customer_list->company }}</td>  
                                    <td>{{ $customer_list->ph_num }}</td>  
                                    <td>{{ $customer_list->city_name }}</td>  
                                    <td>{{ $customer_list->address }}</td>    
                                    <td><a href="{{url('admin/update_customer',$customer_list->id)}}"><i class="fa fa-fw fa-edit"></i></a> |
                                     <a href="{{url('admin/delete_customer',$customer_list->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>
                                     
                                     
                                   
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th style="display:none"></th>
                                    <th>Customer Name</th>   
                                    <th>Company Name</th> 
                                    <th>Phone Number</th> 
                                    <th>City</th> 
                                    <th>Shop Address</th> 
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
<div id="contact-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">×</a>
                <h3>Add Customer</h3>
            </div>
            <form id="contactFormDriver" method='POST' name="contact" action="{{url('admin/add_customer')}}" role="form">
                <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Alt Phone Number</label>
                        <input type="text" id="alt_ph_no" name="alt_ph_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">City</label>
                        <select name="city_id" class="form-control" required>
                            <option value="" selected>Select City</option>
                            @foreach($city_list as $city_list)
                            <option value="{{$city_list->id}}">{{$city_list->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Address</label>
                        <input type="text" id="address" name="address" class="form-control">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" id="submit">
                    </div>
            </form>
        </div>
    </div>
</div>
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
    $('body').on('submit', '#contactFormDriver', function(e) {

        e.preventDefault();
        $.ajax({
            url: "{{ url('admin/add_customer') }}",
            data: new FormData(this),
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                //loding..
            },
            success: function(result) {
                if (result) {
                    //  $('#brand_name').text(result);
                    location.reload();
                }
                console.log(result);
                $('#contact-modal').modal('hide');


            },

        });
    });
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