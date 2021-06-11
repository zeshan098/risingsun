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
                <h3 class="box-title">Donation</h3>
            </div> 
		  <main id="main">
             <form action="{{ url('executive/update_donation',$edit_donation->id) }}" id="donation_form" method="post" style=" ">
		 	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="firstName">Receipt Track Number</label>
                        <input type="text" class="form-control receipt" name="receipt" value="{{$edit_donation->receipt}}" id="firstName" placeholder="" disabled>
                    </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="lastName">Date</label>
                    <input type="text" class="form-control datepicker enter_date" name="enter_date" value="{{$edit_donation->enter_date}}" id="lastName" autocomplete="off" disabled>
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
                      <option value="{{$users->id}}"{{$edit_donation->refer_by == $users->id  ? 'selected' : ''}}>{{$users->first_name}} {{$users->last_name}}</option>
                    @endforeach
                    </select>
                    </div>
                  </div>
                  <div class="col-xs-6 col-md-12">
                    <div class="form-group">
                    <label for="country">Asssign To</label>
                    <select class="form-control assign_to" name="assign_to" id="assign_to"> 
                    @foreach($user2 as $user2)
                      <option value="{{$user2->id}}" {{$edit_donation->assign_to == $user2->id  ? 'selected' : ''}}>{{$user2->first_name}} {{$user2->last_name}}</option>
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
                    <!-- <a data-toggle="modal" data-target="#contact-modal-2"><span class="glyphicon glyphicon-plus"></span></a> -->
                        <select name="name" id="all_customer" class="form-control name select2" required="">
                            <option value="">Select Customer Name</option>
                                @foreach($customer_detail as $customer_detail)
                                <option value="{{$customer_detail->id}}" {{$edit_donation->name == $customer_detail->id  ? 'selected' : ''}}>{{$customer_detail->name}} {{$customer_detail->phone_no}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="address">Customer Name</label>
                    <input type="text" class="form-control cust_name" name="cust_name" id="cust_name" value="{{$edit_donation->cust_name}}" placeholder="" required="" >
                    </div>
                    <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control address" name="address" id="addresss" value="{{$edit_donation->address}}" placeholder="1234 Main St" required="">
                    </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-xs-12">
                      <label><input type="radio" name="red" value="red" id="1" onclick="checkRadio(name)"  checked> SMS</label>
                      <label><input type="radio" name="green" value="green" id="2" onclick="checkRadio(name)"> Email</label>
                      <label><input type="radio" name="blue" value="blue" id="3" onclick="checkRadio(name)"> Both</label>
                  </div> 
                    <div class="red box1">
                      <div class="col-xs-6">
                      <label for="country">Tel#</label>
                          <input type="number" class="form-control phone_no" name="phone_no" value="{{$edit_donation->phone_no}}" id="phone_nos" placeholder="03*********"  >
                      </div>
                      <div class="col-xs-6">
                      <label for="country">Alt Tel#</label>
                          <input type="number" class="form-control alt_phone_no" name="alt_phone_no" id="alt_phone_nos" value="{{$edit_donation->alt_phone_no}}" placeholder="03*********" >
                      </div>
                    </div>
                    <div class="green box1">
                      <div class="col-xs-6">
                      <label for="country">Email</label>
                          <input type="email" class="form-control email" name="email" id="emails"  value="{{$edit_donation->email}}"  >
                      </div>
                      <div class="col-xs-6">
                        
                      </div>
                    </div> 
                </div><br>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="country"><h3>Donar Status</h3></label>
                        <div class="custom-control custom-radio">
                            <input id="Individual" name="donar_status" type="radio" value="Individual" class="custom-control-input donar_status" {{ ($edit_donation->donar_status=="Individual")? "checked" : "" }} >
                            <label class="custom-control-label" for="Individual">Individual</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="Corporate" name="donar_status" type="radio" value="Corporate" class="custom-control-input donar_status" {{ ($edit_donation->donar_status=="Corporate")? "checked" : "" }} >
                            <label class="custom-control-label" for="Corporate">Corporate</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="Govt" name="donar_status" type="radio" value="Govt./Semi Govt. Entity" class="custom-control-input donar_status" {{ ($edit_donation->donar_status=="Govt./Semi Govt. Entity")? "checked" : "" }}>
                            <label class="custom-control-label" for="Govt">Govt./Semi Govt. Entity</label>
                        </div>
                    </div>
                    
                </div><br>
                <div class="row">
                    <div class="col-xs-4">
                      <label for="country">A Sum of Rupees</label>
                       <input type="number" class="form-control rupees" name="rupees" id="number" value="{{$edit_donation->rupees}}" required="" onkeyup="word.innerHTML=convertNumberToWords(this.value)" >
                    </div>
                    <div class="col-xs-4">
                      <label for="country">Currency</label>
                       <input type="text" class="form-control rupees" value="{{$edit_donation->currency}}" name="currency" >
                    </div>
                    <div class="col-xs-4">
                      <label for="address">Amount in Words</label>
                       <input type="text" class="form-control sum_of_rupees" name="sum_of_rupees" id="words" value="{{$edit_donation->sum_of_rupees}}"  required="">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-6">
                      <label for="country">Amount Type</label>
                      <select class="form-control amount_type" name="amount_type" id="donation_type" required=""> 
                       <option value="Cash" {{$edit_donation->amount_type == "Cash"  ? 'selected' : ''}}>Cash</option>
                        <option value="Cheque" {{$edit_donation->amount_type == "Cheque"  ? 'selected' : ''}}>Cheque</option>
                        <option value="Pay Order" {{$edit_donation->amount_type == "Pay Order"  ? 'selected' : ''}}>Pay Order</option>
                       </select>
                    </div>
                    <div class="col-xs-6">
                      <label for="address">Payment Type</label>
                      <select class="form-control payment_type" name="payment_type" id="donation_type" required=""> 
                       <option value="Received" {{$edit_donation->payment_type == "Received"  ? 'selected' : ''}}>Received</option>
                        <option value="To be Collected" {{$edit_donation->payment_type == "To be Collected"  ? 'selected' : ''}}>To be Collected</option>
                        <option value="Online Deposited" {{$edit_donation->payment_type == "Online Deposited"  ? 'selected' : ''}}>Online Deposited</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">By Cash/Cheque Draft No.</label>
                      <input type="text" class="form-control draft_no" name="draft_no" value="{{$edit_donation->draft_no}}" id="draft_no" placeholder=""  >
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Dated</label>
                      @if($edit_donation->draft_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker draft_date" name="draft_date" value="" disabled >
                      @else 
                        <input type="text" class="form-control datepicker draft_date" name="draft_date" value="{{$edit_donation->draft_date}}"   >
                      
                      @endif
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Drawn On</label>
                      <input type="text" class="form-control drawn_on" id="drawn_on" name="drawn_on" value="{{$edit_donation->drawn_on}}" placeholder="" >
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-6" style="display:none">
                      <label for="country">For Sponser a Child</label>
                      <input type="text" class="form-control sponser_child" id="sponser_child" value="{{$edit_donation->sponser_child}}" name="sponser_child" placeholder="" >
                    </div>
                    <div class="col-xs-12">
                      <label for="address">Donation Type</label>
                      <select class="form-control donation_type" name="donation_type" id="donation_type" onchange="showDiv(this)" required=""> 
                      <option value="Zakat" {{$edit_donation->donation_type == "Zakat"  ? 'selected' : ''}}>Zakat</option>
                      <option value="Donation" {{$edit_donation->donation_type == "Donation"  ? 'selected' : ''}}>Donation</option>
                      <option value="Child Sponsorship Donation" {{$edit_donation->donation_type == "Child Sponsorship Donation"  ? 'selected' : ''}}>Child Sponsorship Donation</option>
                      <option value="Child Sponsorship Zakat" {{$edit_donation->donation_type == "Child Sponsorship Zakat"  ? 'selected' : ''}}>Child Sponsorship Zakat</option>
                      <option value="Donation For School" {{$edit_donation->donation_type == "Donation For School"  ? 'selected' : ''}}>Donation For School</option>
                      <option value="Sadqa" {{$edit_donation->donation_type == "Sadqa"  ? 'selected' : ''}}>Sadqa</option>
                      <option value="Grant" {{$edit_donation->donation_type == "Grant"  ? 'selected' : ''}}>Grant</option>
                      <option value="Donation Boxes" {{$edit_donation->donation_type == "Donation Boxes"  ? 'selected' : ''}}>Donation Boxes</option>
                      <option value="In Kind Donations" {{$edit_donation->donation_type == "In Kind Donations"  ? 'selected' : ''}}>In Kind Donations</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row" id="hidden_div" style="">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">No of Children Sponsered</label>
                      <input type="text" class="form-control no_of_children" id="no_of_children" value="{{$edit_donation->no_of_children}}" name="no_of_children" placeholder="" >
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Form</label>
                      @if($edit_donation->from_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker from_date" name="from_date" value=""  >
                      @else 
                        <input type="text" class="form-control datepicker from_date" name="from_date" value="{{$edit_donation->from_date}}" disabled >
                      
                      @endif
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">To</label>
                      @if($edit_donation->to_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker to_date" name="to_date" value="" >
                      @else 
                        <input type="text" class="form-control datepicker to_date" name="to_date" value="{{$edit_donation->to_date}}" disabled >
                      
                      @endif
                    </div>
                </div><br>
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="country">Remarks</label>
                    <textarea class="form-control remarks"  name="remarks" rows="10" cols="80">{{$edit_donation->remarks}}</textarea>
                  </div>
                </div>
                             
            </div>
             
            <div class="box-body">
                
               <hr class="mb-4">
               <input  type="submit" name="save" value="Save" class="btn btn-primary btn-lg btn-block"> 
               <input type="submit" id="submit" name="submits"   value="Submit" class="btn btn-primary btn-lg btn-block"> 
              <!--<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>-->

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
                        <a class="close" data-dismiss="modal">×</a>
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
        format: 'yyyy-mm-dd',
        todayHighlight:'TRUE',
        startDate: '-0d',
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
<!--<script>-->
<!--$(".amount_type").change(function() {-->
<!--  if ($(this).val() == 'Cash') {-->
<!--    $(".draft_no").attr("disabled", "disabled");-->
<!--    $(".draft_no").val('');-->
<!--    $(".draft_date").attr("disabled", "disabled");-->
<!--    $(".draft_date").val('');-->
<!--    $(".drawn_on").attr("disabled", "disabled");-->
<!--    $(".drawn_on").val('');-->
<!--  } else if ($(this).val() == 'Pay Order'){-->
<!--    $(".draft_no").removeAttr("disabled");-->
<!--    $(".draft_date").removeAttr("disabled");-->
<!--    $(".drawn_on").removeAttr("disabled");-->
<!--  } -->
<!--  else {-->
<!--    $(".draft_no").removeAttr("disabled");-->
<!--    $(".draft_date").removeAttr("disabled");-->
<!--    $(".drawn_on").removeAttr("disabled");-->
<!--  }-->
<!--}).trigger("change");-->
<!--</script>-->
<!--<script>-->
<!--$(".payment_type").change(function() {-->
<!--    var conceptName = $('.amount_type').find(":selected").text();-->
<!--  if($(this).val() == 'Online Deposited' && conceptName == 'Cash'){-->
<!--    console.log(conceptName);-->
<!--    $(".draft_no").removeAttr("disabled");-->
<!--    $(".draft_date").removeAttr("disabled");-->
<!--    $(".drawn_on").removeAttr("disabled");-->
<!--  } else if ($(this).val() == 'Pay Order' && conceptName == 'Cheque'){-->
<!--    console.log(conceptName);-->
<!--    $(".draft_no").attr("disabled", "disabled");-->
<!--    $(".draft_no").val('');-->
<!--    $(".draft_date").attr("disabled", "disabled");-->
<!--    $(".draft_date").val('');-->
<!--    $(".drawn_on").attr("disabled", "disabled");-->
<!--    $(".drawn_on").val('');-->
<!--  } -->
<!--  else {-->
<!--    $(".draft_no").attr("disabled", "disabled");-->
<!--    $(".draft_no").val('');-->
<!--    $(".draft_date").attr("disabled", "disabled");-->
<!--    $(".draft_date").val('');-->
<!--    $(".drawn_on").attr("disabled", "disabled");-->
<!--    $(".drawn_on").val('');-->
<!--  }-->
<!--}).trigger("change");-->
<!--</script> -->
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
$('#all_customer').on('change', function() {
     var customer_id = $(this).val();
      //console.log(item_name);
      var token = $("input[name='_token']").val();
      $.ajax({
          url: "{{ url('admin/search_customer') }}",
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