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
                <h3 class="box-title">Add Product Qty</h3>
            </div>
             
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ url('admin/add_order_qty') }}" id="employee_form" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="box-body">
                <table  class="table table-hover small-text" id="tb">
                    <tr class="tr-header">
                        <th>Product</th>
                        <th>Vendor</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Bill#</th> 
                        <th>Date</th>
                        <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
                        <tr>
                        <td><select name="product_id[]" class="form-control">
                        <option value="" selected>Select Product</option>
                                @foreach($product_list as $product_list)
                                    <option value="{{$product_list->id}}">{{$product_list->product_name}}</option>
                                @endforeach
                        </select></td>
                        <td><select name="vender_id[]" class="form-control">
                        <option value="" selected>Select Vendor</option>
                             @foreach($vendor as $vendor)
                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endforeach
                        </select></td>
                        <td><input type="text" name="received_qty[]" class="form-control"></td>
                        <td><input type="text" name="rate[]" class="form-control"></td>
                        <td><input type="text" name="bill_no[]" class="form-control"></td>
                        <td><input type="text" name="date[]" class="form-control datepicker" autocomplete="OFF"></td> 
                        <td><a href='javascript:void(0);'  class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
                    </tr>
                </table>
                      
                     
                    
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
$(function () {
    
    //Initialize Select2 Elements
    $('.select2').select2()

   
  })

</script>
<script>
//Date picker

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE', 
        autoclose: true,
    })
</script>
<script>
$(function(){
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE', 
        autoclose: true,
    }); 
    $('#addMore').on('click', function() {
        

        $(".datepicker").datepicker("destroy");
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val(''); 
              $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight:'TRUE', 
            autoclose: true,
       });      
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
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