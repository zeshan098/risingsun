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
                <h3 class="box-title">Add SMS</h3>
            </div> 
		  <main id="main">
             <form action="{{ url('admin/sms_submit') }}"   method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
               
                <div class="row">
                     
                    <div class="col-xs-12">
                      <label for="address">Payment Type</label>
                      <select class="form-control payment_type" name="payment_type" required=""> 
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Pay Order">Pay Order</option>
                       </select>
                    </div>
                     
                </div><br>
                <div class="row">
                     
                <div class="col-xs-12">
                      <label for="address">Donation Type</label>
                      <select class="form-control donation_type" name="donation_type" id="donation_type"  required=""> 
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
                 
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="country">SMS Text</label>
                    <textarea class="form-control sms_text"  name="sms_text" rows="10" cols="80"></textarea>
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