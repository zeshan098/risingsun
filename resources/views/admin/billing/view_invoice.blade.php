@extends('admin.template.admin_template')



@section('content')
<style>
  .error {
    color: red;
  }
</style>
<?php
//dd(\Route::current()->getName());
//dd($controller_name.' --- '.$action_name);
?>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header" style="text-align:center;font-weight: bolder;font-size: 47px;">
        <i class="fa fa-file-invoice"></i> Invoice Details
        <!-- <small class="pull-right">Date: 2/10/2014</small> -->
      </h2>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">

    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Invoice#: {{$total_invoice->bill_number}}</b><br>
      <b>Customer Name:</b> {{$total_invoice->company_name}}<br>
      <b>Date:</b> {{ $total_invoice->date }}<br>
      <b>Payment Type:</b> {{$total_invoice->payment_type}}

    </div>
    <br>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 box-body table-responsive">
      <table id="users_list" class="table table-striped">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Code</th>
            <th>Qty</th>
            <th>Selling Price</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($product_invoice as $product_invoice)
          <tr>
            <td>{{$product_invoice->product_name}}</td>
            <td>{{$product_invoice->code}}</td>
            <td>{{$product_invoice->qty}}</td>
            <td>{{$product_invoice->selling_price}} /PKR</td>
            <td>{{$product_invoice->discount}} /PKR</td>
            <td>{{$product_invoice->discounted_amount}} /PKR</td>
            <td>
              @if($product_invoice->is_returned == 1)
                Returned
              @else
                <a class="product_invoice_id" data-product_invoice_id="{{$product_invoice->id}}" data-toggle="modal" data-target="#exampleModalLong" href="#"><i class="fas fa-undo"></i> Return</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6">

    </div>
    <!-- /.col -->
    <div class="col-xs-6">
      <!-- <p class="lead">Amount Due 2/22/2014</p> -->

      <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
          <tr>
            <th style="width:50%">Subtotal:</th>
            <td>{{$total_invoice->total_amount}} /RS</td>
          </tr>
          <tr>
            <th>Total Discount:</th>
            <td>{{$total_invoice->total_discount}} /Rs</td>
          </tr>
          <tr>
            <th>Total:</th>
            <td>{{$total_invoice->discounted_amount}} /Rs</td>
          </tr>
          <tr>
            <th>Paid:</th>
            <td>{{$total_invoice->paid}} /Rs</td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->



</section>

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="return_product_form" method="POST" action="{{route('return_product')}}">
        @csrf
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLongTitle">Return Product</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Comments</h5>
          <textarea name="comments" rows="4" class="form-control" style="min-width: 100%"></textarea>
          <input id="modal_product_id" type="hidden" name="product_sale_id" />

          <!-- <div class="row" style="margin-top: 10px;">
            <div class="col-lg-4">
              <label>Returned Amount <br> (Check if any)</label>
            </div>
            <div class="col-lg-8">
              <div class="input-group">
                <span class="input-group-addon">
                  <input id="is_returned" type="checkbox" name="is_returned" value="1" aria-label="...">
                </span>
                <input id="returned_amount" type="number" name="returned_amount" class="form-control" aria-label="..." disabled>
              </div>
            </div>
          </div> -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
      </form>
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
  $(function() {
    $('#users_list').DataTable({
      "ordering": false,
      "searching": false,
      "paging": false,
      "bInfo": false,
    });
    $(".product_invoice_id").on("click", function() {
      var product_invoice_id = $(this).attr("data-product_invoice_id");
      $("#modal_product_id").val(product_invoice_id);
    });

    $("#is_returned").change(function(){
      if($(this).is(":checked")){
        $("#returned_amount").removeAttr("disabled");
      }else{
        $("#returned_amount").attr("disabled", "disabled");
      }
    });
    $("#return_product_form").validate({
      rules: {
        comments: {
          required: true,
          // minlength: 20
        },
      },
      messages: {
        comments: {
          required: "Please enter some data",
          // minlength: "Your data must be at least 20 characters"
        },
      }
    });
  });
</script>


@endsection