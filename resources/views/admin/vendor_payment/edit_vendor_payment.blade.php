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
                <h3 class="box-title">Vendor Due Payment <strong>{{$vendor_record->name}}</strong></h3>
            </div>
             
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ url('admin/paid_payment', $vendor_record->id) }}" id="employee_form" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="box-body">
                     <div class="form-group" style="display:none">
                        <label for="first_name">vendor_id</label>
                        <input type="number" class="form-control" id="vendor_id" name="vendor_id" value="{{$vendor_record->vendor_id}}" >
                                
                    </div>
                    <div class="form-group">
                        <label for="first_name">Due Payment</label>
                        <input type="number" class="form-control" id="payment" name="payment" value="{{$vendor_record->payment}}" >
                                
                    </div>
                    <div class="form-group">
                        <label for="first_name">Paid Payment</label>
                        <input type="number" class="form-control" id="paid_payment" name="paid_payment" value="{{$vendor_record->paid_payment}}" >
                                
                    </div>
                    <div class="form-group">
                        <label for="first_name">Remaining Payment</label>
                        <input type="number" class="form-control" id="remaining_payment" name="remaining_payment" value="{{$vendor_record->remaining_payment}}">
                                
                    </div> 
                    <div class="form-group">
                        <label for="first_name">Payment Type</label>
                        <input type="text" class="form-control" name="payment_type" value="{{$vendor_record->payment_type}}" placeholder="Cash,Cheque">
                                
                    </div>
                    <div class="form-group">
                        <label for="first_name">Payment Person</label>
                        <input type="text" class="form-control" name="payment_person" value="{{$vendor_record->payment_person}}" >
                                
                    </div> 
                    <div class="form-group">
                        <label for="first_name">Bank slip #</label>
                        <input type="text" class="form-control" name="bank_slip_no" value="{{$vendor_record->bank_slip_no}}" placeholder="123456789">
                                
                    </div>  
                    <div class="form-group">
                        <label for="first_name">Date</label>
                        <input type="text"  class="form-control datepicker" name="payment_date" autocomplete="off" />
                                
                    </div>
                    <div class="form-group">
                        <label for="first_name">Remarks</label>
                        <input type="text" class="form-control" name="remarks" value="{{$vendor_record->remarks}}"  >
                                
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
<script>
$(function() {

$('#payment, #paid_payment').keyup(function(){
   updateTotal(); 
});

var updateTotal = function () {
  var input1 = parseInt($('#payment').val());
  var input2 = parseInt($('#paid_payment').val());
  if (isNaN(input1) || isNaN(input2)) {
      if(!input2){
          $('#remaining_payment').val($('#payment').val());
      }

      if(!input1){
            $('#remaining_payment').val($('#paid_payment').val());
      }

  } else {          
        $('#remaining_payment').val(input1 - input2);
  }
};

// var output_total = $('#remaining_payment');

// var total = input1 + input2;

// output_total.val(total);

});
 </script>
@endsection