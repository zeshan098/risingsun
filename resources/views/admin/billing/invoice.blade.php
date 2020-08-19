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
<link rel="stylesheet" href="{{ asset("bower_components/invoice/invoice.css") }}">
<!-- Main content -->
<section class="content">

    <header>
        <h1>Invoice</h1>


    </header>
    <form method="post" action="{{ url('admin/create_invoice') }}" id="invoice_form" enctype="multipart/form-data">
        <article>
            <h1>Recipient</h1>
            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
            <table class="meta1">
                <tr>
                    <th><span contenteditable>Customer</span>
                        <a data-toggle="modal" data-target="#contact-modal" style="top: 4px;position: relative;">
                            <span class="glyphicon glyphicon-plus-sign"></span>
                        </a>
                    </th>
                    <td><select name="customer_id" id="customer_name" class="form-control select2">
                            <option value="" selected>Select Customer</option>
                            @foreach($customer_list as $customer_list)
                            <option value="{{$customer_list->id}}">{{$customer_list->company_name}} ({{$customer_list->name}})</option>
                            @endforeach
                        </select></td>
                </tr>
                <!-- <tr>
                    <th><span contenteditable>Payment Type</span></th>
					<td><select name="payment_type" id="payment_type" class="form-control">
                            <option value="" selected>Select Payment Type</option> 
                            <option value="Cash">Cash</option> 
                            <option value="Credit">Credit</option>  
                        </select>
                    </td>
				</tr> -->

            </table>

            <table class="meta">
                <tr>
                    <th><span contenteditable>Invoice #</span></th>
                    <td><span contenteditable></span><span name="bill_number">{{$date->format('Ymd')}}-{{$invoice_number}}</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Date</span></th>
                    <td><span contenteditable></span><span name="date">{{$date->format('d-m-Y')}}</span></td>
                </tr>

            </table>
            <table class="table table-hover small-text" id="tb">
                <tr class="tr-header">
                    <th>Product</th>
                    <th>Code</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th style="display:none">Cost</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th style="display:none">Total Value</th>
                    <th><a href="javascript:void(0);" style="font-size:18px;" id="addMore" title="Add More Person"><span class="glyphicon glyphicon-plus"></span></a></th>
                <tr>
                    <td><select name="product_id[]" class="form-control products">
                            <option value="" selected>Select Product</option>
                            @foreach($product_list as $product_list)
                            <option value="{{$product_list->id}}">{{$product_list->product_name}}</option>
                            @endforeach
                        </select></td>
                    <td><input type="text" name="" id="code" class="form-control code" readonly></td>
                    <td><input type="number" min="0" name="qty[]" class="form-control qty auto-calc"></td>
                    <td><input type="text" name="selling_price[]" class="form-control selling_price auto-calc"></td>
                    <td style="display:none"><input type="text" name="cost[]" class="form-control cost"></td>
                    <td><input type="number" min="0" name="discount[]" class="form-control discount auto-calc"></td>
                    <td><input type="text" min="0" name="discounted_amount[]" class="form-control discounted_amount" readonly></td>
                    <td style="display:none"><input type="text" name="total_value[]" class="form-control total_value"></td>
                    <td><a href='javascript:void(0);' class='remove'><span class='glyphicon glyphicon-remove'></span></a></td>
                </tr>
            </table>
            <table class="balance">
                <tr>
                    <th><span contenteditable>Total</span></th>
                    <td><span data-prefix>PKR </span><span class="total-invoice" name="total_amount" id="total-invoice">0.00</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Total Discount</span></th>
                    <td><span data-prefix>PKR </span><span id="total-discount" name="total_discount">0.00</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Grand Total</span></th>
                    <td><span data-prefix>PKR </span><span id="total_discounted_amount" name="discounted_amount">0.00</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Paid</span></th>
                    <td><span data-prefix>PKR </span><input type="number" id="amount_paid" name="paid" value="" step="any" require /></td>
                </tr>
            </table>
        </article>
        <div class="" style="text-align: right;">
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            <button id="btn1" type="button" data-toggle="modal" data-target="#myModal" value="{{$bill_num}}" class="btn btn-primary">Print Preview</button>
        </div>
    </form>

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
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" required>
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


</div>

<!-- Modal for Edit button -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Invoice<span class="qr_winner_name_show" style="color: #32c5d2;"></span></h4>
            </div>
            <div id="invoice">

                <div class="toolbar hidden-print">
                    <div class="text-right">
                        <button id="btnPrint" class="btn btn-info">Print</button>
                        <!-- <input type="button" class="btn btn-info" onclick="PrintElem('invoice')" value="print" /> -->
                        <!-- <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>  -->
                    </div>
                    <hr>
                </div>
                <div class="invoice overflow-auto" id="printThis">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">

                                <div class="col company-details">
                                    <h2 class="name">
                                        <a target="_blank" href="#">
                                            Test Center
                                        </a>
                                    </h2>
                                    <div>455 Foggy Heights, AZ 85004, US</div>
                                    <div>(123) 456-789</div>
                                    <div>company@example.com</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col-md-5 invoice-to">
                                    <div class="text-gray-light">Customer Name: <span class="to"> </span></div>
                                    <div class="text-gray-light">Phone Number: <span class="phone_no"></span></div>
                                    <div class="text-gray-light">Address:<span class="address"></span></div>
                                </div>

                                <div class="col-md-6  invoice-details">
                                    <div class="text-gray-light" style="margin-left: 325px;">Invoice#: <span class="invoice-id"> </span></div>
                                    <div class="text-gray-light" style="margin-left: 325px;">Date:<span class="date"></span> </div>
                                </div>
                            </div>

                            <table border="0" cellspacing="0" cellpadding="0" id="sampleTbl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">Item Code</th>
                                        <th class="text-left">Product Name</th>
                                        <th class="text-right">QTY</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="2">SUBTOTAL</td>
                                        <td class="sub_total"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="2">DISCOUNT</td>
                                        <td class="discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="2">GRAND TOTAL</td>
                                        <td class="grand_amount"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="thanks">Thank you!</div>
                            <!-- <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div> -->
                        </main>
                        <footer>
                            Invoice was created on a computer and is valid without the signature and seal.
                        </footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>

        </div>
    </div>
</div>

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
    $(function() {
        $('#users_list').DataTable();
    });
</script>
<script>
    $(function() {

        //Initialize Select2 Elements
        $('.select2').select2()


    })
</script>
<script>
    //Date picker

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: 'TRUE',
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
                    $('#customer_name').append($('<option />').attr("value", result[1]).text(result[0]).prop('selected', "selected"));
                    value = $('#customer_name').val();
                    $('#customer_name').val(value);
                }
                console.log(result);
                $('#contact-modal').modal('hide');


            },

        });
    });
</script>

<script>
    $(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: 'TRUE',
            autoclose: true,
        });
        $('#addMore').on('click', function() {
            var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
            data.find("input").val('');

        });
        $(document).on('click', '.remove', function() {
            var trIndex = $(this).closest("tr").index();
            if (trIndex > 1) {
                $(this).closest("tr").remove();
            } else {
                alert("Sorry!! Can't remove first row!");
            }
            sumOfColumns();
        });
    });
</script>


<script type="text/javascript">
    $(function() {
        $(document).on('change', 'select.products', function() {
            var selected = $(this).val();
            var $row = $(this).closest("tr");
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ url('admin/show_product') }}",
                method: 'POST',
                data: {
                    item_name: selected,
                    _token: token
                },
                success: function(data) {
                    $(this).closest('tr').find('.code').val('zz');
                    $(".product").each(function() {
                        $(this).find('option').not(':first').remove();
                    });
                    $.each(data, function(i, item) {
                        $row.find('.code').val(item.code);
                        $row.find('.qty').val('1');
                        $row.find('.selling_price').val(item.selling_price);
                        $row.find('.cost').val(item.rate);
                        $row.find('.discount').val('0');
                        $row.find('.discounted_amount').val(item.selling_price);
                        $row.find('.total_value').val(item.selling_price);
                        sendvalue();
                    });
                }
            });

        });
    });

    function sendvalue() {
        var sum = 0;
        $('.total_value').each(function() {
            var prodprice = Number($(this).val());
            sum = sum + prodprice;
        });
        $("#total-invoice").text(sum.toFixed(2));
        $("#total_discounted_amount").text(sum.toFixed(2));
        $("#amount_paid").val(0);
    }


    // Add event trigger to inputs with class auto-calc
    $(document).on("keyup change paste", "td > input.auto-calc", function() {

        // Determine parent row
        row = $(this).closest("tr");

        // Get first and second input values
        first = row.find("td input.qty").val();
        second = row.find("td input.selling_price").val();
        third = row.find("td input.discount").val();
        // Print input values to output cell
        row.find(".total_value").val((first * second));
        row.find(".discounted_amount").val((first * second) - third);

        // Update total invoice value
        var sum = 0;
        var sum_1 = 0;
        var sum_2 = 0;
        // Cycle through each input with class total-cost

        $("input.total_value").each(function() {
            // Add value to sum
            sum_1 += +$(this).val();
        });

        $("input.discount").each(function() {
            // Add value to sum
            sum_2 += +$(this).val();
        });

        $("input.discounted_amount").each(function() {
            // Add value to sum
            sum += +$(this).val();
        });
        // Assign sum to text of #total-invoice
        // Using the id here as there is only one of these
        $("#total-invoice").text(sum_1);
        $("#total-discount").text(sum_2);
        $("#total_discounted_amount").text(sum);

    });



    function sumOfColumns() {

        // Determine parent row
        row = $(this).closest("tr");

        // Get first and second input values
        first = row.find("td input.qty").val();
        second = row.find("td input.selling_price").val();
        third = row.find("td input.discount").val();
        // Print input values to output cell
        row.find(".total_value").val((first * second));
        row.find(".discounted_amount").val((first * second) - third);

        // Update total invoice value
        var sum = 0;
        var sum_1 = 0;
        var sum_2 = 0;
        // Cycle through each input with class total-cost

        $("input.total_value").each(function() {
            // Add value to sum
            sum_1 += +$(this).val();
        });

        $("input.discount").each(function() {
            // Add value to sum
            sum_2 += +$(this).val();
        });

        $("input.discounted_amount").each(function() {
            // Add value to sum
            sum += +$(this).val();
        });
        // Assign sum to text of #total-invoice
        // Using the id here as there is only one of these
        $("#total-invoice").text(sum_1);
        $("#total-discount").text(sum_2);
        $("#total_discounted_amount").text(sum);
    }
</script>
<script>
    $("#btn1").on("click", function(e) {
        var id = $(this).val();

        console.log(id);

        $.ajax({
            url: "{{ url('admin/get_invoice') }}",
            data: {
                id: id
            },
            type: 'get',
            dataType: 'JSON',
            success: function(response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    var second_date = moment(response[i].date).format('DD-MM-YYYY');
                    $(".to").text(response[i].name);
                    $(".phone_no").text(response[i].phone_no);
                    $(".address").text(response[i].address);
                    $(".invoice-id").text(response[i].bill_number);
                    $(".date").text(second_date);
                    $(".sub_total").text(response[i].total_amount + '/PKR');
                    $(".discount").text(response[i].total_discount + '/PKR');
                    $(".grand_amount").text(response[i].discounted_amount + '/PKR');
                }
            }
        });

    });
</script>
<!-- Product Detail -->
<script>
    $("#btn1").on("click", function(e) {
        var id = $(this).val();

        console.log(id);

        $.ajax({
            url: "{{ url('admin/get_product_invoice') }}",
            data: {
                id: id
            },
            type: 'get',
            dataType: 'JSON',
            success: function(response) {
                var trHTML = '';
                $.each(response, function(i, item) {
                    var sum = i + 1;
                    trHTML += '<tr><td class="no">' + sum + '</td><td class="item-code">' + item.code + '</td><td class="product-name">' + item.product_name + '</td><td class="qty">' + item.qty + '</td><td class="total">' + item.selling_price + '</td><td class="total_rate">' + item.total_value + '</td></tr>';
                });
                $('#sampleTbl').append(trHTML);
            }
        });

    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on("keyup change paste", "td > input.qty", function() {
            var selected_qty = $(this).val();
            row = $(this).closest("tr"); 
            product_id = row.find("td select.products").val(); 
            // console.log(product_id);
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ url('admin/get_product_qty') }}",
                method: 'POST',
                data: {
                    item_name: product_id,
                    _token: token
                },
                success: function(data) {
                    $(this).closest('tr').find('.code').val('zz');
                    $(".product").each(function() {
                        $(this).find('option').not(':first').remove();
                    });
                    $.each(data, function(i, item) { 
                        var db_qty = item.quantity;
                        console.log(db_qty);
                        if(parseInt(selected_qty) > parseInt(db_qty)){
                            alert("Quantity Increase");
                        }else{
                            console.log("Ok");
                        }
                    });
                }
            });
        });
    });
</script>
<script>
    document.getElementById("btnPrint").onclick = function() {
        printElement(document.getElementById("printThis"));
        window.print();
    }

    function printElement(elem, append, delimiter) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printThis");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printThis";
            document.body.appendChild($printSection);
        }

        if (append !== true) {
            $printSection.innerHTML = "";
        } else if (append === true) {
            if (typeof(delimiter) === "string") {
                $printSection.innerHTML += delimiter;
            } else if (typeof(delimiter) === "object") {
                $printSection.appendChlid(delimiter);
            }
        }

        $printSection.appendChild(domClone);
    }
</script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
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