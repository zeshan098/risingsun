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

    <!-- /.row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Payment Receipt</h3>
                        <input type="button" class="btn btn-primary" onclick="location.href='show_receipt_list';" value="Delete Receipt" />
                    </div>
                    <form method="post" action="{{ route('post-payment-receipt') }}" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <select name="company_name" id="customer_name" class="form-control select2">
                                            <option value="" selected>Select Customer</option>
                                            @foreach($customer_list as $customer_list)
                                            <option value="{{$customer_list->company_name}}">{{$customer_list->company_name}} ({{$customer_list->name}})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="company_name">Amount</label>
                                        <input type="text" name="amount" id="amount" value="" class="form-control" required/>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" id="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <!--<div class="box-body table-responsive no-padding">-->
                    <table id="payment_receipt" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Company</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if($PaymentReceipts != null)
                            @foreach($PaymentReceipts as $PaymentReceipt)
                            <tr>
                                <td>{{ $PaymentReceipt->id }}</td>
                                <td>{{ $PaymentReceipt->company_name }}</td>
                                <td>{{ $PaymentReceipt->amount }}</td>
                                <td>{{ $PaymentReceipt->created_at }}</td>
                                <!-- <td><a href="{{route('delete_payment_record', $PaymentReceipt->id)}}"><i class="fa fa-trash fa-2" aria-hidden="true"></i></a></td> -->
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
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
<script src="{{ asset("bower_components/selecter/select2.full.min.js") }}"></script>
<script>
    $(function() {
        $('#payment_receipt').DataTable({
            // "ordering": false,
            // "searching": false,
        });
        $('.select2').select2();
    });
</script>


@endsection