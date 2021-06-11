@extends('admin.template.admin_template')



@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
 
<!-- Main content -->
<section class="content">
 
	  <div class="row">
	        <div class="box-header with-border">
                <h3 class="box-title">Donation Detail</h3>
            </div> 
		  <main id="main">
              
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="firstName">Receipt Track Number</label>
                        <input type="text" class="form-control receipt" name="receipt" value="{{$view_donation->receipt}}" id="firstName" placeholder="" disabled>
                    </div>
                </div>
                <div class="col-xs-6">
                  <div class="form-group">
                    <label for="lastName">Date</label>
                    <input type="text" class="form-control datepicker enter_date" name="enter_date" value="{{$view_donation->enter_date}}" id="lastName" autocomplete="off" disabled>
                  </div>  
                </div>
              </div>
            </div> 
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                    <label for="address">Received with thanks from</label>
                    <input type="text" class="form-control name" name="name" id="address" value="{{$view_donation->custname}}" disabled>
                    </div>
                    <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control address" name="address" id="address" value="{{$view_donation->address}}" disabled>
                    </div>
                </div>
              </div>
                <div class="row">
                   
                    <div class="red box1">
                      <div class="col-xs-6">
                      <label for="country">Tel#</label>
                          <input type="number" class="form-control phone_no" name="phone_no" id="phone_no" value="{{$view_donation->phone_no}}" disabled>
                      </div>
                      <div class="col-xs-6">
                      <label for="country">Alt Tel#</label>
                          <input type="number" class="form-control alt_phone_no" name="alt_phone_no" id="alt_phone_no" value="{{$view_donation->alt_phone_no}}" disabled >
                      </div>
                    </div>
                    <div class="green box2">
                      <div class="col-xs-6">
                      <label for="country">Email</label>
                          <input type="email" class="form-control email" name="email" id="email"  value="{{$view_donation->email}}" disabled>
                      </div>
                      <div class="col-xs-6">
                        
                      </div>
                    </div>  
                    
                
                             
            </div><br>

             
              <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                    <label for="address">Donar Status</label>
                    <input type="text" class="form-control name" name="name" id="address" value="{{$view_donation->donar_status}}" disabled>
                    </div>
                     
                </div>
                <div class="col-xs-6">
                      <label for="address">Rupees</label>
                       <input type="text" class="form-control words" name="words" id="words" value="{{$view_donation->rupees}} {{$view_donation->currency}}" disabled>
                    </div>
              </div>
                <div class="row"> 
                    <div class="col-xs-6">
                      <label for="address">Amount Type</label>
                       <input type="text" class="form-control words" name="words" id="words" value="{{$view_donation->amount_type}}" disabled>
                    </div>
                    <div class="col-xs-6">
                      <label for="address">Amount Type</label>
                       <input type="text" class="form-control words" name="words" id="words" value="{{$view_donation->payment_type}}" disabled>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">By Cash/Cheque Draft No.</label>
                      <input type="text" class="form-control draft_no" name="draft_no" value="{{$view_donation->draft_no}}" disabled >
                    </div>
                   <div class="col-xs-12 col-md-4">
                      <label for="address">Dated</label>
                      @if($view_donation->draft_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker draft_date" value="" disabled >
                      @else 
                        <input type="text" class="form-control datepicker draft_date" value="{{$view_donation->draft_date}}" disabled >
                      
                      @endif
                      
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Drawn On</label>
                      <input type="text" class="form-control drawn_on" id="drawn_on" value="{{$view_donation->drawn_on}}" disabled >
                    </div>
                </div><br>
                <div class="row">
                     
                    <div class="col-xs-12">
                      <label for="address">Donation Type</label> 
                      <input type="text" class="form-control sponser_child" id="sponser_child" value="{{$view_donation->donation_type}}" disabled >
                    </div>
                     
                </div><br>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                      <label for="country">No of Children Sponsered</label>
                      <input type="text" class="form-control no_of_children" id="no_of_children" name="no_of_children" value="{{$view_donation->no_of_children}}" disabled >
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">Form</label>
                      @if($view_donation->from_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker draft_date" value="" disabled >
                      @else 
                        <input type="text" class="form-control datepicker draft_date" value="{{$view_donation->from_date}}" disabled >
                      
                      @endif
                        
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <label for="address">To</label>
                      @if($view_donation->to_date == '1970-01-01') 
                        <input type="text" class="form-control datepicker draft_date" value="" disabled >
                      @else 
                        <input type="text" class="form-control datepicker draft_date" value="{{$view_donation->to_date}}" disabled >
                      
                      @endif
                       
                    </div>
                </div><br>
                <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <label for="country">Remarks</label>
                    <textarea class="form-control remarks"  name="remarks" rows="10" cols="80" disabled>{{$view_donation->remarks}}</textarea>
                  </div>
                </div>    
                
                             
             
             
			 

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
 
@endsection