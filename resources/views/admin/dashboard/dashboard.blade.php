@extends('admin.template.admin_template')



@section('content')
<section class="content main_calculations">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Dashboard</h3>
            </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Oil</span>
                @foreach($total_oil as $total_oil)
                <span class="info-box-number">{{ $total_oil->total }} <large> Rs</large></span>
                @endforeach
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Mughalpura Bookings</span>
                @foreach($no_of_booking as $no_of_booking)
                <span class="info-box-number">{{ $no_of_booking->booking }}</span>
                @endforeach
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Booking amount</span>
                 @foreach($total_bookings as $total_bookings)
                <span class="info-box-number">{{ $total_bookings->total_booking }} Rs</span>
                @endforeach
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
      </div>
      
      <!--second book-->
       <div class="row">
            
            

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Canal Bank Bookings</span>
                @foreach($cannal_no_of_booking as $cannal_no_of_booking)
                <span class="info-box-number">{{ $cannal_no_of_booking->booking }}</span>
                @endforeach
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Booking amount</span>
                 @foreach($canal_total_bookings as $canal_total_bookings)
                <span class="info-box-number">{{ $canal_total_bookings->total_booking }} Rs</span>
                @endforeach
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
      </div>
      <!--Tabs-->
      <div class="row">
          <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Afzal Pump</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Malik CNG & Filling Station</a></li>
              <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">New Ravi Pump</a></li>
               
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                {!! $chart->html() !!}
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                {!! $chart_1->html() !!}
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                {!! $chart_2->html() !!}
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>
      <!--graph -->
      <!--2nd tab-->
      <div class="row">
          <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_11" data-toggle="tab" aria-expanded="true">Mughalpura</a></li>
              <li class=""><a href="#tab_21" data-toggle="tab" aria-expanded="false">Canal Bank</a></li>
               
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_11">
                {!! $book_chart->html() !!}
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_21">
                {!! $book_chart_2->html() !!}
              </div>
              <!-- /.tab-pane --> 
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
      </div>
      <!--end -->
      
       
</section>
{!! Charts::scripts() !!}
{!! $chart->script() !!}
{!! $chart_1->script() !!}
{!! $chart_2->script() !!}
{!! $book_chart->script() !!}
{!! $book_chart_2->script() !!}
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
 
 
 
<script>
$(function () {
    $('#users_list').DataTable();
});
</script>

@endsection