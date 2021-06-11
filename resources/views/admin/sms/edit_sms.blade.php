@extends('admin.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
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
                <h3 class="box-title">EDIT SMS</h3>
            </div> 
		  <main id="main">
             <form action="{{ url('admin/sms', $edit_sms->id) }}"   method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
               
                <div class="row">
                     
                    <div class="col-xs-12">
                      <label for="address">Payment Type</label>
                      <select class="form-control payment_type" name="payment_type">   
                        <option {{ ($edit_sms->payment_type) == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>  
                        <option {{ ($edit_sms->payment_type)  == 'Cheque'  ? 'selected' : ''}} value="Cheque">Cheque</option>
                        <option {{ ($edit_sms->payment_type)  == 'Pay Order'  ? 'selected' : ''}} value="Pay Order" >Pay Order</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row">
                     
                <div class="col-xs-12">
                      <label for="address">Donation Type</label>
                      <select class="form-control donation_type" name="donation_type" id="donation_type"> 
                        <option {{ ($edit_sms->donation_type) == 'Zakat' ? 'selected' : '' }} value="Zakat">Zakat</option>  
                        <option {{ ($edit_sms->donation_type) == 'Donation' ? 'selected' : '' }} value="Donation">Donation</option>  
                        <option {{ ($edit_sms->donation_type) == 'Child Sponsorship Donation' ? 'selected' : '' }} value="Child Sponsorship Donation">Child Sponsorship Donation</option>
                        <option {{ ($edit_sms->donation_type) == 'Child Sponsorship Zakat' ? 'selected' : '' }} value="Child Sponsorship Zakat">Child Sponsorship Zakat</option> 
                        <option {{ ($edit_sms->donation_type) == 'Donation For School' ? 'selected' : '' }} value="Donation For School">Donation For School</option>     
                        <option {{ ($edit_sms->donation_type) == 'Sadqa' ? 'selected' : '' }} value="Sadqa">Sadqa</option>    
                        <option {{ ($edit_sms->donation_type) == 'Grant' ? 'selected' : '' }} value="Grant">Grant</option>    
                        <option {{ ($edit_sms->donation_type) == 'Donation Boxes' ? 'selected' : '' }} value="Donation Boxes">Donation Boxes</option>    
                        <option {{ ($edit_sms->donation_type) == 'In Kind Donations' ? 'selected' : '' }} value="In Kind Donations">In Kind Donations</option>   
                       </select>
                    </div>
                     
                </div><br>
                 
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="country">SMS Text</label>
                    <textarea class="form-control sms_text"  name="sms_text" rows="10" cols="80">{!!$edit_sms->sms_text!!}</textarea>
                  </div>
                </div>
                             
            </div>
             
            <div class="box-body">
                
               <hr class="mb-4">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>

            </div>
          </form>
			 
			 

		  </main><!-- End #main -->
	   
	    
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
<!-- page script -->
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