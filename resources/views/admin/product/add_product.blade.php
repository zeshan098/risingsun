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
    <div class="row">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add Product</h3>
                <input type="button" class="btn btn-primary" onclick="location.href='category';" value="View Category" />
            </div>
            
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" action="{{ url('admin/add_product') }}" id="employee_form" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first_name">Item Code</label>
                            <input type="number" id="code" class="form-control" name="code" required>
                            <div id="screenNameError"></div>        
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required>
                                    
                        </div> 
                    </div>
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="first_name">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category</option>
                                @foreach($category as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"> 
                           <a data-toggle="modal" data-target="#contact-modal-1" style="top: 34px;position: relative;">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                            </a>
                    </div>
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="first_name">Select Brand</label>
                            <select name="brand_id" id="brand_name" class="form-control">
                            <option value="">Select Brand</option>
                              @foreach($brand as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        
                        </div>
                    </div>
                    <div class="col-md-1"> 
                           <a data-toggle="modal" data-target="#contact-modal-2" style="top: 34px;position: relative;">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                            </a>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="first_name">Selling Price</label>
                            <input type="text" class="form-control slip_no" id="slip_no" name="selling_price" required>
                                    
                        </div> 
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
                        <h3 class="box-title">Produt List</h3>
                    </div>
                </div>
            <div class="box-body table-responsive">
                    <!--<div class="box-body table-responsive no-padding">-->
                        <table id="users_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                <th style="display:none"></th>
                                    <th>Product Code</th> 
                                    <th>Product Name</th> 
                                    <th>Category Name</th>
                                    <th>Brand Name</th> 
                                    <th>Total Qty</th>  
                                    <th>Selling Price</th> 
                                    <th>Location</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($product_list as $product_list)
                                <tr>
                                    <td style="display:none">YYYY/mm/dd</td>
                                    <td>{{ $product_list->code }}</td> 
                                    <td>{{ $product_list->product_name }}</td> 
                                    <td>{{ $product_list->category }}</td> 
                                    <td>{{ $product_list->brand }}</td> 
                                    <td>{{ $product_list->qty }}</td> 
                                    <td>{{ $product_list->price }}</td>  
                                    <td>{{ $product_list->wh }}</td>
                                    <td><a href="{{url('admin/update_product',$product_list->id)}}"><i class="fa fa-fw fa-edit"></i></a> | <a href="{{url('admin/delete_product',$product_list->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td>    
                                     
                                   
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                <th style="display:none"></th>
                                     <th>Product Code</th> 
                                    <th>Product Name</th> 
                                    <th>Category Name</th>
                                    <th>Brand Name</th>  
                                    <th>Total Qty</th>  
                                    <th>Selling Price</th> 
                                    <th>Location</th>
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


<!-- Brand add form -->
    <div id="contact-modal-2" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Add Brand</h3>
                    </div>
                    <form id="contactFormDriver" method='POST' name="contact" action="{{url('admin/add_brand')}}" role="form">
                        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
                        <div class="modal-body">				
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                             
                            
                        <div class="modal-footer">					
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" id="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <!-- Brand add form -->
    <div id="contact-modal-1" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal">×</a>
                        <h3>Add Category</h3>
                    </div>
                    <form id="contactFormDrivers" method='POST' name="contact" action="{{url('admin/add_category')}}" role="form">
                        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
                        <div class="modal-body">				
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="category" class="form-control">
                            </div>
                             
                            
                        <div class="modal-footer">					
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" id="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
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
<script src="{{ asset("bower_components/datepicker/bootstrap-datepicker.min.js") }}"></script>
<script src="{{ asset("bower_components/datepicker/daterangepicker.js") }}"></script> 
<script>
$(function () {
    $('#users_list').DataTable();
});
</script>
<script>
$('body').on('submit','#contactFormDriver',function(e){

e.preventDefault();
$.ajax({
    url : "{{ url('admin/add_brand') }}",
    data: new FormData(this),
    type: 'POST',
    contentType: false,       
    cache: false,             
    processData:false, 
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
     },
    beforeSend: function(){
      //loding..
    },
    success:function(result){
     if (result){
        //  $('#brand_name').text(result);
        $('#brand_name').append($('<option />').attr("value", result[1]).text(result[0]).prop('selected', "selected"));
        value = $('#brand_name').val();
         $('#brand_name').val(value);
      }
      console.log(result);
      $('#contact-modal-2').modal('hide'); 


    },
     
});
});
 
</script>

<script>
$('body').on('submit','#contactFormDrivers',function(e){

e.preventDefault();
$.ajax({
    url : "{{ url('admin/add_category') }}",
    data: new FormData(this),
    type: 'POST',
    contentType: false,       
    cache: false,             
    processData:false, 
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
     },
    beforeSend: function(){
      //loding..
    },
    success:function(result){
     if (result){
        //  $('#brand_name').text(result);
        $('#category_id').append($('<option />').attr("value", result[0]).text(result[1]).prop('selected', "selected"));
        value = $('#category_id').val();
         $('#category_id').val(value);
      }
      console.log(result);
      $('#contact-modal-1').modal('hide'); 


    },
     
});
});
 
</script>

<script>
$(document).ready(function(){

$("#code").keyup(function(){

   var code = $(this).val().trim();

   if(code != ''){

      $.ajax({
         url: "{{ url('admin/check_code') }}",
         type: 'post',
         data: {code: code},
         headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
     },
         success: function(response){

             $('#screenNameError').html(response);

          }
      });
   }else{
      $("#screenNameError").html("");
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