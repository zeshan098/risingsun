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
                <h3 class="box-title">EDIT {{$edit_customer->name}}</h3>
            </div> 
		  <main id="main">
             <form action="{{ url('admin/update_detail', $edit_customer->id) }}"   method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
                
                <div class="row">
                     
                    <div class="col-xs-6">
                      <label for="address">Donor Name</label>
                      <input type="text" class="form-control address" name="name" id="address" value="{{$edit_customer->name}}">
                    </div>
                    <div class="col-xs-6">
                      <label for="address">Email</label>
                      <input type="text" class="form-control address" name="email" id="address" value="{{$edit_customer->email}}">
                    </div>
                     
                </div><br>

                <div class="row">
                     
                    <div class="col-xs-6">
                      <label for="address">Phone #</label>
                      <input type="text" class="form-control address" name="phone_no" id="address" value="{{$edit_customer->phone_no}}">
                    </div>
                    <div class="col-xs-6">
                      <label for="address">Alt Phone #</label>
                      <input type="text" class="form-control address" name="alt_phone_no" id="address" value="{{$edit_customer->alt_phone_no}}">
                    </div>
                     
                </div><br>
                <div class="row">
                     
                    <div class="col-xs-12">
                      <label for="address">Address</label>
                      <input type="text" class="form-control address" name="address" id="address" value="{{$edit_customer->address}}">
                    </div>
                     
                     
                </div><br>
                 
                 
                 
                             
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