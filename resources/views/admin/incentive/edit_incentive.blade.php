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
                <h3 class="box-title">EDIT Incentive</h3>
            </div> 
		  <main id="main">
             <form action="{{ url('admin/complete_incentive', $edit_incentive->id) }}"   method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="box-body">
                
                <div class="row">
                     
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="country">Select User</label>
                            <select class="form-control" name="user_id" id="assign_to"> 
                                @foreach($users as $users)
                                <option value="{{$users->id}}" {{ $users->id == $edit_incentive->user_id ? 'selected' : '' }}>{{$users->first_name}} {{$users->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  
                     
                </div><br>
                <div class="row">
                     
                     <div class="col-xs-12">
                     <label for="address">Percentage</label>
                      <input type="number" class="form-control address" name="incentive_percentage" id="address" value="{{$edit_incentive->incentive_percentage}}" require>
                     </div>
                      
                      
                 </div><br>
                <div class="row">
                     
                    <div class="col-xs-12">
                      <label for="address">Amount</label>
                      <input type="number" class="form-control address" name="amount" id="address" value="{{$edit_incentive->amount}}" required>
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