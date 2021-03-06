@extends('executive.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
<link rel="stylesheet" href="{{ asset("bower_components/selecter/select2.min.css") }}">
<style>
     
    .green{ 
        display: none; 
    } 
     
    label{ margin-right: 15px; }
    </style>
<!-- Main content -->
<section class="content">
 
	  <div class="row">
	        <div class="box-header with-border">
                <h3 class="box-title">Add Donation</h3>
            </div> 
		  <main id="main">
             <form action="" id="donation_form" method="post" style=" ">
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="firstName">Receipt Track Number</label>
                        <input type="text" class="form-control receipt" name="receipt" value="{{$invoice_date}}-{{$invoice_number}}" id="firstName" placeholder="" disabled>
                    </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="lastName">Date</label>
                    <input type="text" class="form-control datepicker enter_date" name="enter_date"  id="lastName" autocomplete="off" required="">
                    <!--<input type="text" class="form-control datepicker enter_date" name="enter_date" value="{{$new_date}}" id="lastName" autocomplete="off" disabled>-->
                  </div>  
                </div>
              </div>
            </div> 
            <div class="box-body">
                <div class="row">
                  <div class="col-xs-6 col-md-12">
                    <div class="form-group">
                    <label for="country">Refer By</label>
                    <select class="form-control refer_by" name="refer_by" id="refer_by"> 
                    @foreach($users as $users)
                      <option value="{{$users->id}}">{{$users->first_name}} {{$users->last_name}}</option>
                    @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="col-xs-6 col-md-12">
                    <div class="form-group">
                    <label for="country">Asssign To</label>
                    <select class="form-control assign_to" name="assign_to" id="assign_to"> 
                    @foreach($user2 as $user2)
                      <option value="{{$user2->id}}">{{$user2->first_name}} {{$user2->last_name}}</option>
                    @endforeach
                    </select>
                    </div>
                  </div>
                </div>
              <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                    <label for="address">Received with thanks from</label>
                    <!--<input type="text" class="form-control name" name="name" id="address" placeholder=" " required="">-->
                    <a data-toggle="modal" data-target="#contact-modal-2"><span class="glyphicon glyphicon-plus"></span></a>
                        <select name="name" id="all_customer" class="form-control name select2" required="">
                            <option value="">Select Customer Name</option>
                                @foreach($customer_detail as $customer_detail)
                                <option value="{{$customer_detail->id}}">{{$customer_detail->name}} {{$customer_detail->phone_no}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="address">Customer Name</label>
                    <input type="text" class="form-control cust_name" name="cust_name" id="cust_name" value="" placeholder="" required="" >
                    </div>
                    <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control address" name="address" id="addresss" value="" placeholder="1234 Main St" required="">
                    </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-xs-12">
                      <label><input type="radio" name="red" value="red" id="1" onclick="checkRadio(name)" checked> SMS</label>
                      <label><input type="radio" name="green" value="green" id="2" onclick="checkRadio(name)"> Email</label>
                      <label><input type="radio" name="blue" value="blue" id="3" onclick="checkRadio(name)"> Both</label>
                  </div> 
                    <div class="red box1">
                      <div class="col-xs-6">
                      <label for="country">Tel#</label>
                          <input type="number" class="form-control phone_no" name="phone_no" value="" id="phone_nos" placeholder="03*********" >
                      </div>
                      <div class="col-xs-6">
                      <label for="country">Alt Tel#</label>
                          <input type="number" class="form-control alt_phone_no" name="alt_phone_no" id="alt_phone_nos" value="" placeholder="03*********">
                      </div>
                    </div>
                    <div class="green box1">
                      <div class="col-xs-6">
                      <label for="country">Email</label>
                          <input type="email" class="form-control email" name="email" id="emails"  value=""  disabled>
                      </div>
                      <div class="col-xs-6">
                        
                      </div>
                    </div> 
                </div><br>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="country"><h3>Donar Status</h3></label>
                        <div class="custom-control custom-radio">
                            <input id="Individual" name="donar_status" type="radio" value="Individual" class="custom-control-input donar_status" checked="" required="">
                            <label class="custom-control-label" for="Individual">Individual</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="Corporate" name="donar_status" type="radio" value="Corporate" class="custom-control-input donar_status" required="">
                            <label class="custom-control-label" for="Corporate">Corporate</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="Govt" name="donar_status" type="radio" value="Govt./Semi Govt. Entity" class="custom-control-input donar_status" required="">
                            <label class="custom-control-label" for="Govt">Govt./Semi Govt. Entity</label>
                        </div>
                    </div>
                    
                </div><br>
                <div class="row">
                    <div class="col-xs-4">
                      <label for="country">A Sum of Rupees</label>
                       <input type="number" class="form-control rupees" name="rupees" id="number" placeholder=" " required="" onkeyup="word.innerHTML=convertNumberToWords(this.value)" >
                    </div>
                    <div class="col-xs-4">
                      <label for="country">Currency</label>
                       <input type="text" class="form-control currency" name="currency" >
                    </div>
                    <div class="col-xs-4">
                      <label for="address">Amount in Words</label>
                       <input type="text" class="form-control sum_of_rupees" name="sum_of_rupees" id="words" placeholder=" " required="" disabled>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-6">
                      <label for="country">Amount Type</label>
                      <select class="form-control amount_type" name="amount_type" id="donation_type" required=""> 
                       <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Pay Order">Pay Order</option>
                       </select>
                    </div>
                    <div class="col-xs-6">
                      <label for="address">Payment Type</label>
                      <select class="form-control payment_type" name="payment_type" id="donation_type" required=""> 
                       <option value="Received">Received</option>
                        <option value="To be Collected">To be Collected</option>
                        <option value="Online Deposited">Online Deposited</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">By Cash/Cheque Draft No.</label>
                      <input type="text" class="form-control draft_no" name="draft_no" id="draft_no" placeholder=""  >
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Dated</label>
                      <input type="text" class="form-control datepicker draft_date" id="draft_date" name="draft_date" autocomplete="off" >
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Drawn On</label>
                      <input type="text" class="form-control drawn_on" id="drawn_on" name="drawn_on" placeholder="" >
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-6" style="display:none">
                      <label for="country">For Sponser a Child</label>
                      <input type="text" class="form-control sponser_child" id="sponser_child" name="sponser_child" placeholder="">
                    </div>
                    <div class="col-xs-12">
                      <label for="address">Donation Type</label>
                      <select class="form-control donation_type" name="donation_type" id="donation_type" onchange="showDiv(this)" required=""> 
                      <option value="Zakat">Zakat</option>
                      <option value="Donation">Donation</option>
                      <option value="Child Sponsorship Donation">Child Sponsorship Donation</option>
                      <option value="Child Sponsorship Zakat">Child Sponsorship Zakat</option>
                      <option value="Donation For School">Donation For School</option>
                      <option value="Sadqa">Sadqa</option>
                      <option value="Grant">Grant</option>
                      <option value="Donation Boxes">Donation Boxes</option>
                      <option value="In Kind Donations">In Kind Donations</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row" id="hidden_div" style="display:none;">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">No of Children Sponsered</label>
                      <input type="text" class="form-control no_of_children" id="no_of_children" name="no_of_children" placeholder="">
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Form</label>
                      <input type="text" class="form-control datepicker from_date" id="from_date" name="from_date" autocomplete="off">
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">To</label>
                      <input type="text" class="form-control datepicker to_date" id="to_date" name="to_date" autocomplete="off">
                    </div>
                </div><br>
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="country">Remarks</label>
                    <textarea class="form-control remarks"  name="remarks" rows="10" cols="80"></textarea>
                  </div>
                </div>
                             
            </div>
             
            <div class="box-body">
                
               <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>

            </div>
          </form>
			 
			 

		  </main><!-- End #main -->
	   
	    
	 </div> 
    <!-- /.row -->
</section>
<!-- /.content -->
<!-- Customer add form -->
        <div id="contact-modal-2" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal">??</a>
                        <h3>Customer Detail</h3>
                    </div>
                    <form id="contactFormDriver" method='POST' name="contact" action="{{url('executive/customer_add')}}" role="form">
                        <input name="_token" type="hidden" id="token" value="{{ csrf_token() }}"/>
                        <div class="modal-body">				
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Address</label>
                                <input type="text" id="address" name="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Phone #</label>
                                <input type="text" id="phone_no" name="phone_no" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Alt Phone #</label>
                                <input type="text" id="alt_phone_no" name="alt_phone_no" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control">
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
<script src="{{ asset("bower_components/selecter/select2.full.min.js") }}"></script>  
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
$(function () {
    
    //Initialize Select2 Elements
    $('.select2').select2()

   
  })

</script>
<script> 
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight:'TRUE', 
        autoclose: true,
        orientation: 'bottom'
    })
</script>
 
<script>
 var a = ['','One ','Two ','Three ','Four ', 'Five ','Six ','Seven ','Eight ','Nine ','Ten ','Eleven ','Twelve ','Thirteen ','Fourteen ','Fifteen ','Sixteen ','Seventeen ','Eighteen ','Nineteen '];
var b = ['', '', 'Twenty','Thirty','Forty','Fifty', 'Sixty','Seventy','Eighty','Ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 12) return 'overflow';
    n = ('00000000000' + num).substr(-12).match(/^(\d{3})(\d{3})(\d{3})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (Number(n[1]) > 99 ? this.a[Number(n[1][0])] + 'Hundred ' : '') + (a[Number(n[1])] || b[n[1][1]] + ' ' + a[n[1][2]]) + 'Billion ' : '';
    str += (n[2] != 0) ? (Number(n[2]) > 99 ? this.a[Number(n[2][0])] + 'Hundred ' : '') + (a[Number(n[2])] || b[n[2][1]] + ' ' + a[n[2][2]]) + 'Million ' : '';
    str += (n[3] != 0) ? (Number(n[3]) > 99 ? this.a[Number(n[3][0])] + 'Hundred ' : '') + (a[Number(n[3])] || b[n[3][1]] + ' ' + a[n[3][2]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
     str += (Number(n[5]) !== 0) ? ((str !== '') ? 'And ' : '') +
                (this.a[Number(n[5])] || this.b[n[5][0]] + ' ' +
                    this.a[n[5][1]]) + '' : '';
    return $("#words").val(str);
}


document.getElementById('number').onkeyup = function () {
    document.getElementById('words').innerHTML = inWords(document.getElementById('number').value);
};
</script>
<script>
$(".amount_type").change(function() {
  if ($(this).val() == 'Cash') {
    $(".draft_no").attr("disabled", "disabled");
    $(".draft_no").val('');
    $(".draft_date").attr("disabled", "disabled");
    $(".draft_date").val('');
    $(".drawn_on").attr("disabled", "disabled");
    $(".drawn_on").val('');
  } else if ($(this).val() == 'Pay Order'){
    $(".draft_no").removeAttr("disabled");
    $(".draft_date").removeAttr("disabled");
    $(".drawn_on").removeAttr("disabled");
  } 
  else {
    $(".draft_no").removeAttr("disabled");
    $(".draft_date").removeAttr("disabled");
    $(".drawn_on").removeAttr("disabled");
  }
}).trigger("change");
</script>
<script>
$(".payment_type").change(function() {
    var conceptName = $('.amount_type').find(":selected").text();
  if($(this).val() == 'Online Deposited' && conceptName == 'Cash'){
    console.log(conceptName);
    $(".draft_no").removeAttr("disabled");
    $(".draft_date").removeAttr("disabled");
    $(".drawn_on").removeAttr("disabled");
  } else if ($(this).val() == 'Pay Order' && conceptName == 'Cheque'){
    console.log(conceptName);
    $(".draft_no").attr("disabled", "disabled");
    $(".draft_no").val('');
    $(".draft_date").attr("disabled", "disabled");
    $(".draft_date").val('');
    $(".drawn_on").attr("disabled", "disabled");
    $(".drawn_on").val('');
  } 
  else {
    $(".draft_no").attr("disabled", "disabled");
    $(".draft_no").val('');
    $(".draft_date").attr("disabled", "disabled");
    $(".draft_date").val('');
    $(".drawn_on").attr("disabled", "disabled");
    $(".drawn_on").val('');
  }
}).trigger("change");
</script>
<script>
function checkRadio(name) {
  var inputValue = name;
  console.log(name);
    if(inputValue == "blue"){
      $(".red").show();
      $(".green").show();
        document.getElementById("3").checked = true;
        document.getElementById("2").checked = false;
        document.getElementById("1").checked = false;

    } else if(inputValue == "red"){
        $(".red").show(); 
        $(".green").hide(); 
        document.getElementById("1").checked = true;
        document.getElementById("2").checked = false;
        document.getElementById("3").checked = false;
    }else{
        $(".green").show();
        $(".red").hide();  
        document.getElementById("2").checked = true;
        document.getElementById("1").checked = false;
        document.getElementById("3").checked = false;
    }
}
// $(document).ready(function(){
//     $('input[type="radio"]').click(function(){
//         var inputValue = $(this).attr("value");
//         if(inputValue == 'blue'){
//           $(".red").show();
//           $(".green").show();
//         }else{
//           var targetBox = $("." + inputValue);
//           $(".box1").not(targetBox).hide();
//           $(targetBox).show();  
//         }
        
//     });
// });
</script>
<script>
	$('#donation_form').on('submit',function(event){
        event.preventDefault(); 
		var _token = $("input[name='_token']").val();  
		var receipt =$(".receipt").val();
		var enter_date =$(".enter_date").val();
		var refer_by =$(".refer_by").val();
		var assign_to =$(".assign_to").val();
		var name =$(".name").val();
		var cust_name = $(".cust_name").val();
		var address = $(".address").val();
		var phone_no =$(".phone_no").val();
		var alt_phone_no =$(".alt_phone_no").val();
		var donar_status = $(".donar_status:checked").val();
		var donation_type = $(".donation_type").val();
		var rupees =$(".rupees").val();
		var sum_of_rupees =$(".sum_of_rupees").val();
		var currency =$(".currency").val();
		var amount_type =$(".amount_type").val();
        var payment_type =$(".payment_type").val(); 
		var draft_no = $(".draft_no").val();
		var draft_date =$(".draft_date").val();
		var drawn_on =$(".drawn_on").val();
		var sponser_child = $(".sponser_child").val();
		var no_of_children = $(".no_of_children").val();
		var from_date =$(".from_date").val();
		var to_date = $(".to_date").val();
		var remarks = $(".remarks").val();
		var email = $(".email").val();
 
		$.ajax({
			url: 'donation_submit',
			type:'POST', 
			data: { _token:_token,receipt:receipt, enter_date:enter_date, refer_by:refer_by,assign_to:assign_to, name:name, cust_name:cust_name, address:address,
				phone_no:phone_no, alt_phone_no:alt_phone_no, donar_status:donar_status, donation_type:donation_type,
         rupees:rupees,sum_of_rupees:sum_of_rupees,currency:currency, amount_type:amount_type,payment_type:payment_type, draft_no:draft_no, draft_date:draft_date,
        drawn_on:drawn_on, sponser_child:sponser_child,  no_of_children:no_of_children,
        from_date:from_date, to_date:to_date, remarks:remarks, email:email },
        
			success: function(data) {
				if($.isEmptyObject(data.error)){ 
					window.location.reload(true);
					toastr.success(data.success); 
				}else{
					alert("Please Enter Correct Number (03*********)"); 
				}
			}
		});

 
	});
</script>
<script type="text/javascript">
function showDiv(select){
   if(select.value=="Child Sponsorship Donation" || select.value=="Child Sponsorship Zakat"){
    document.getElementById('hidden_div').style.display = "block";
   } else{
    document.getElementById('hidden_div').style.display = "none";
   }
} 
</script>
<script>
$('body').on('submit','#contactFormDriver',function(e){

e.preventDefault();
$.ajax({
    url : "{{ url('executive/customer_add') }}",
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
     if (result[6] == 'success'){
          $('#all_customer').append("<option value='"+result[0]+"' selected>"+result[1]+"</option>");
          $('#phone_nos').val(result[3]);
          $('#addresss').val(result[2]);
          $('#alt_phone_nos').val(result[5]);
          $('#emails').val(result[4]);
          $('#cust_name').val(result[1]);
      }else{
          toastr.error(result.error); 
      }
      
      $('#contact-modal-2').modal('hide'); 


    },
     
});
});
</script>
<script>
$('#all_customer').on('change', function() {
     var customer_id = $(this).val();
      //console.log(item_name);
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "{{ url('executive/search_customer') }}",
          method: 'POST',
          data: {customer_id:customer_id, _token:token},
          success: function(data) {
            //console.log(data);
            $(".all_customer").each(function(){
                $(this).find('option').not(':first').remove();
            });
            $.each(data, function(i, item) { 
              $('#phone_nos').val(item.phone_no);
              $('#addresss').val(item.address);
              $('#alt_phone_nos').val(item.alt_phone_no);
              $('#emails').val(item.email);
              $('#cust_name').val(item.name);
            });
          }
      });
});
</script>
<script>
    $('form').submit(function() {
      $(this).find("button[type='submit']").prop('disabled',true);
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