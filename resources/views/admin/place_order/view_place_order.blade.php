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
                    <h3 class="box-title">Place Order</h3>
                </div>
                 
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                <!--<div class="box-body table-responsive no-padding">-->
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                               <th style="display:none"></th>
                               <th>Product Code</th>
                                <th>Product Name</th> 
                                <th>Vendor Name</th> 
                                <th>Qty</th>
                                <th>Cost</th> 
                                <th>Total</th>
                                <th>Bill #</th> 
                                <th>Date</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($product_lists as $product_lists)
                            <tr> 
                                <td style="display:none"></td>
                                <td>{{ $product_lists->code }}</td> 
                                <td>{{ $product_lists->product_name }}</td> 
                                <td>{{ $product_lists->vendor_name }}</td> 
                                <td>{{ $product_lists->qty }}</td> 
                                <td>{{ $product_lists->cost }}</td> 
                                <td>{{ $product_lists->total }}</td> 
                                <td>{{ $product_lists->bill_no }}</td> 
                                <td>{{ $product_lists->date }}</td>
                                
                                
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr> 
                               <th style="display:none"></th>
                               <th>Product Code</th>
                                <th>Product Name</th> 
                                <th>Vendor Name</th>
                                <th>Qty</th>
                                <th>Cost</th> 
                                <th>Total</th>
                                <th>Bill #</th> 
                                <th>Date</th> 
                            </tr>
                        </tfoot>
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

<script src="{{ asset("bower_components/admin-lte/dist/js/demo.js") }}"></script>
<script src="{{asset("bower_components/csv_js/dataTables.buttons.min.js") }}"></script>
<script src="{{asset("bower_components/csv_js/buttons.flash.min.js") }}"></script>
<script src="{{asset("bower_components/csv_js/jszip.min.js") }}"></script>
<script src="{{asset("bower_components/csv_js/pdfmake.min.js") }}"></script>
<script src="{{asset("bower_components/csv_js/vfs_fonts.js") }}"></script>
<script src="{{asset("bower_components/csv_js/buttons.html5.min.js") }}"></script>
<script src="{{asset("bower_components/csv_js/buttons.print.min.js") }}"></script>
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
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
@endsection