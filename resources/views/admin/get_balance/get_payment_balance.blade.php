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
                        <h3 class="box-title">Add Payment</h3>
                    </div>
                    <form method="post" action="{{ route('post-payment-balance') }}" enctype="multipart/form-data">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <select name="company_name" id="customer_name" class="form-control select2">
                                            <option value="" selected>Select Customer</option>
                                            @foreach($customer_list as $customer_list)
                                            <option value="{{$customer_list->company_name}}">{{$customer_list->company_name}}</option>
                                            @endforeach
                                        </select>
                                        <a data-toggle="modal" data-target="#contact-modal" style="top: 4px;position: relative;">
                                            <span class="glyphicon glyphicon-plus-sign"></span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="company_name">Amount</label>
                                        <input type="text" name="amount" id="amount" value="" class="form-control" />
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
                            </tr>
                        </thead>
                        <tbody>
                            @if($getbalance != null)
                            @foreach($getbalance as $getbalance)
                            <tr>
                                <td>{{ $getbalance->id }}</td>
                                <td>{{ $getbalance->company_name }}</td>
                                <td>{{ $getbalance->amount }}</td>
                                <td>{{ $getbalance->created_at }}</td>
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
<!--customer form-->
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
                        <input type="text" id="name" name="name" class="form-control">
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
                        <select name="city_id" class="form-control">
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
                    $('#customer_name').append($('<option />').attr("value", result[2]).text(result[0]).prop('selected', "selected"));
                    value = $('#customer_name').val();
                    $('#customer_name').val(value);
                }
                console.log(result);
                $('#contact-modal').modal('hide');


            },

        });
    });
</script>
@endsection