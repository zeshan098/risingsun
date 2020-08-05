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
                  
                  <input id="message" value="{{ $vendor_name->name }}" style=" border: hidden; font-size: 22px; " readonly/> 
                    
                </div>
                 
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                <!--<div class="box-body table-responsive no-padding">-->
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                                <th style="display:none"></th> 
                                <th>Date</th>
                               <th>Payment</th>
                                <th>Paid Payment</th> 
                                <th>Remaining Payment</th>
                                <th>payment Date</th> 
                                <th>Payment Type</th>
                                <th>Payment Person</th> 
                                <th>Bank slip</th> 
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($payment_lists as $payment_lists)
                            <tr> 
                                <td style="display:none"></td>
                                <td>{{ $payment_lists->date }}</td> 
                                <td>{{ $payment_lists->payment }}</td> 
                                <td>{{ $payment_lists->paid_payment }}</td> 
                                <td>{{ $payment_lists->remaining_payment }}</td> 
                                <td>{{ $payment_lists->payment_date }}</td> 
                                <td>{{ $payment_lists->payment_type }}</td> 
                                <td>{{ $payment_lists->payment_person }}</td> 
                                <td>{{ $payment_lists->bank_slip_no }}</td> 
                                <td>{{ $payment_lists->status }}</td>
                                
                                
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr> 
                                <th style="display:none"></th>
                                <th>Date</th>
                                <th>Payment</th>
                                <th>Paid Payment</th> 
                                <th>Remaining Payment</th> 
                                <th>payment Date</th> 
                                <th>Payment Type</th>
                                <th>Payment Person</th> 
                                <th>Bank slip</th> 
                                <th>Status</th>  
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
            'copy',
            {
                extend: 'excel',
               messageTop: function() {
                  return $('#message').val()
                }
            },
            {
                extend: 'pdf',
                messageBottom: null
            },
            {
                extend: 'print',
                messageTop: function () {
                    printCounter++;
 
                    if ( printCounter === 1 ) {
                        return 'This is the first time you have printed this document.';
                    }
                    else {
                        return 'You have printed this document '+printCounter+' times';
                    }
                },
                messageBottom: null
            }
        ]
    } );
} );
</script>
@endsection