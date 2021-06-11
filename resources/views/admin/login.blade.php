
@extends('admin.template.login_form')

@section('content')
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Login</b>Here</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    @if (\Session::has('error'))
        <div class="alert alert-error">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    <form role="form" action="{{ url('login') }}" method="post">
    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
      <div class="form-group has-feedback">
        <input type="text" name="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-2">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-8">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button> 
        </div>
        <!-- /.col -->
        <div class="col-xs-2">
          
        </div>
      </div>
    </form>
    <div class="row">
        <div class="col-xs-4">
          
        </div>
    </div>
    

    <!-- <a href="register.html" class="text-center">Register a new member</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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
    $(function () {
        $('#users_list').DataTable();
    });
</script>
@endsection