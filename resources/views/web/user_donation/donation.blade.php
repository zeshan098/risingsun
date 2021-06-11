<!doctype html>
<html lang="en">

<head> 
    @include('web.include.head')
</head>

<body>
    @include('web.include.header')

    <div class="container">
	  <div class="row">
	  <div class="col-md-2">
	  </div>
	    <div class="col-md-8">
		  <main id="main">
             <form action="" id="donation_form" method="post" style="margin-top: 92px;">
								<!--<input name="_token" type="hidden" value="{{ csrf_token() }}"/>-->
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Receipt No</label>
                <input type="text" class="form-control receipt" name="receipt" value="{{$invoice_date}}-{{$invoice_number}}" id="firstName" placeholder="" disabled>
                 
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Date</label>
                <input type="text" class="form-control datepicker enter_date" name="enter_date" value="{{$new_date}}" id="lastName" autocomplete="off" disabled>
                 
              </div>
            </div>
            
            <div class="mb-3">
              <label for="address">Received with thanks from</label>
              <input type="text" class="form-control name" name="name" id="address" placeholder=" " required="">
               
            </div>
            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control address" name="address" id="address" placeholder="1234 Main St" required="">
               
            </div>

             

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Tel#</label>
                <input type="number" class="form-control phone_no" name="phone_no" id="phone_no" placeholder="03*********" required="">
                 
              </div>
			        <div class="col-md-7 mb-3">
                <label for="country">Alt Tel#</label>
                <input type="number" class="form-control alt_phone_no" name="alt_phone_no" id="alt_phone_no" placeholder="03*********" >
                 
              </div>
               
            </div>
             
            <hr class="mb-4">

            <h4 class="mb-3">Donar Status</h4>

            <div class="d-block my-3">
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
		    <div class="mb-3">
              <label for="address">A Sum of Rupees</label>
              <input type="number" class="form-control rupees" name="rupees" id="number" placeholder=" " required="" onkeyup="word.innerHTML=convertNumberToWords(this.value)" >
               
            </div>
            <div class="mb-3">
              <label for="address">Rupees</label>
              <input type="text" class="form-control words" name="words" id="words" placeholder=" " required="" disabled>
               
            </div>
            <div class="mb-3">
                <label for="country">Amount Type</label>
                <select class="custom-select d-block w-100 amount_type" name="amount_type" id="donation_type" required=""> 
                  <option value="Cash">Cash</option>
                  <option value="Cheque">Cheque</option>
                </select>
              </div>
		    	  <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">By Cash/Cheque Draft No.</label>
                <input type="text" class="form-control draft_no" name="draft_no" id="draft_no" placeholder=""  >
                 
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">Dated</label>
                <input type="text" class="form-control datepicker draft_date" id="draft_date" name="draft_date" autocomplete="off" >
                 
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Drawn On</label>
                <input type="text" class="form-control drawn_on" id="drawn_on" name="drawn_on" placeholder="" >
                
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-name">For Sponser a Child</label>
                <input type="text" class="form-control sponser_child" id="sponser_child" name="sponser_child" placeholder="" required="">
                <!--<small class="text-muted">Full name as displayed on card</small>-->
                 
              </div>
              <div class="col-md-6 mb-3">
                <label for="country">Donation Type</label>
                <select class="custom-select d-block w-100 donation_type" name="donation_type" id="donation_type" required=""> 
                  <option value="Zakat">Zakat</option>
                  <option value="Donation">Donation</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="cc-expiration">No of Children Sponsered</label>
                <input type="text" class="form-control no_of_children" id="no_of_children" name="no_of_children" placeholder="" required="">
                 
              </div>
              <div class="col-md-3 mb-3">
                <label for="cc-expiration">Form</label>
                <input type="text" class="form-control datepicker from_date" id="from_date" name="from_date" autocomplete="off" required="">
                
              </div>
			        <div class="col-md-3 mb-3">
                <label for="cc-expiration">To</label>
                <input type="text" class="form-control datepicker to_date" id="to_date" name="to_date" autocomplete="off" required="">
                 
              </div>
            </div>
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
          </form>
			 
			 

		  </main><!-- End #main -->
	  </div>
	  <div class="col-md-2">
	  </div> 
	 </div><hr class="mb-4">
	</div>
    @include('web.include.footer')

    <script> 
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight:'TRUE',
        startDate: '-0d',
        autoclose: true,
        orientation: 'bottom'
    })
</script>
<script>
 var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'billion ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'million ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
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
    $(".draft_date").attr("disabled", "disabled");
    $(".drawn_on").attr("disabled", "disabled");
  } else {
    $(".draft_no").removeAttr("disabled");
    $(".draft_date").removeAttr("disabled");
    $(".drawn_on").removeAttr("disabled");
  }
}).trigger("change");
</script>
<script>
	$('#donation_form').on('submit',function(event){
        event.preventDefault(); 
		var _token = $("input[name='_token']").val();  
		var receipt =$(".receipt").val();
		var enter_date =$(".enter_date").val();
		var name =$(".name").val();
		var address = $(".address").val();
		var phone_no =$(".phone_no").val();
		var alt_phone_no =$(".alt_phone_no").val();
		var donar_status = $(".donar_status:checked").val();
		var donation_type = $(".donation_type").val();
		var rupees =$(".rupees").val();
		var amount_type =$(".amount_type").val();
		var draft_no = $(".draft_no").val();
		var draft_date =$(".draft_date").val();
		var drawn_on =$(".drawn_on").val();
		var sponser_child = $(".sponser_child").val();
		var no_of_children = $(".no_of_children").val();
		var from_date =$(".from_date").val();
		var to_date = $(".to_date").val();
 
		$.ajax({
			url: '{{ route('donation_submit') }}',
			type:'POST', 
			data: {  receipt:receipt, enter_date:enter_date, name:name, address:address,
				phone_no:phone_no, alt_phone_no:alt_phone_no, donar_status:donar_status, donation_type:donation_type,
         rupees:rupees, amount_type:amount_type, draft_no:draft_no, draft_date:draft_date,
        drawn_on:drawn_on, sponser_child:sponser_child,  no_of_children:no_of_children,
        from_date:from_date, to_date:to_date },
        
			success: function(data) {
				if($.isEmptyObject(data.error)){
          alert("Request Receive"); 
					window.location.reload(true);
				}else{
					alert("Please Enter Correct Number (03*********)"); 
				}
			}
		});

 
	});
</script>
</body>

</html>