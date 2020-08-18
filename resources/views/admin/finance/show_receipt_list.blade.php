@extends('admin.template.admin_template')



@section('content')
<?php
//dd(\Route::current()->getName());
//dd($controller_name.' --- '.$action_name);
?>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}"> 
<link rel="stylesheet" href="{{ asset("bower_components/selecter/select2.min.css") }}">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Payment Receipt List</h3>
            </div>
             
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <label>Company name</label>
                        <select name="vendor_id" class="form-control select2 vendor_id" style="width: 100%;" required>
                        <option value="" selected>Select Customer</option>
                        @foreach($customer_list as $customer_list)
                            <option value="{{$customer_list->company_name}}">{{$customer_list->company_name}} </option>
                        @endforeach
                        </select>
                    </div>
                </div>
            </div> 
             
        </div>
        <br/>
        <!-- /.col -->
    </div>
    <!-- /.row -->
     <!-- /.row -->
     <div class="row"> 
         <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Receipt List</h3>
                    </div>
                </div>
            <div class="box-body table-responsive">
                    <!--<div class="box-body table-responsive no-padding">-->
                        <table id="users_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th style="display:none"></th>
                                <th>id</th>
                                <th>Company</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                            <tfoot>
                                <tr>
                                <th style="display:none"></th>
                                <th>id</th>
                                <th>Company</th>
                                <th>Amount</th>
                                <th>Date</th>
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
<script src="{{ asset("bower_components/selecter/select2.full.min.js") }}"></script> 
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
$(function () {
    
    //Initialize Select2 Elements
    $('.select2').select2()

   
  })

</script> 

<script type="text/javascript">
  $(document).ready(function(){

 

        // Search by userid
        $("select[name='vendor_id']").on("change",function(){
           var vendor_id = $(this).val();
                
            if(vendor_id != 0){
            fetchRecords(vendor_id);
            }

        });

    });

    function fetchRecords(id){
        console.log(id);
       $.ajax({
         url: 'show_list/'+id,
         type: 'get',
         dataType: 'json',
         success: function(response){

           
           $('#users_list tbody').empty(); // Empty <tbody>
            

           if(response['data'].length > 0){
              for(var i=0; i<response['data'].length; i++){
                 var id = response['data'][i].id;
                 var company_name = response['data'][i].company_name;
                 var amount = response['data'][i].amount;
                 var created_at = response['data'][i].created_at;
                 var status = response['data'][i].status;

                 var tr_str = "<tr>" + 
                   "<td align='center'>" + id +  "</td>" +
                   "<td align='center'>" + company_name + "</td>" +
                   "<td align='center'>" + amount +   "</td>" + 
                   "<td align='center'>" + created_at +   "</td>" + 
                   "<td align='center'>" + '<a href="/admin/delete_payment_record/' + id + '"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>' +
                   "</tr>";

                 $("#users_list tbody").append(tr_str);
              }
           }else{
              var tr_str = "<tr>" +
                  "<td align='center' colspan='5'>No record found.</td>" +
              "</tr>";

              $("#users_list tbody").append(tr_str);
           }

         }
       });
     }
  </script>
@endsection