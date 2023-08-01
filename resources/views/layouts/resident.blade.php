<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
    @yield('styles')
   {{-- toastr --}}
   <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/toastr/toastr.min.css")}}">
   <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css")}}">
   <!-- Toastr -->
 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/fontawesome-free/css/all.min.css")}}">
 <!-- Ionicons -->
 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
 <!-- Tempusdominus Bootstrap 4 -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}">
 <!-- iCheck -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
 <!-- JQVMap -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/jqvmap/jqvmap.min.css")}}">
 <!-- Theme style -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/dist/css/adminlte.min.css")}}">
 <!-- overlayScrollbars -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
 <!-- Daterange picker -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/daterangepicker/daterangepicker.css")}}">
 <!-- summernote -->
 <link rel="stylesheet" href="{{url("DASHBOARD_ASSETS/plugins/summernote/summernote-bs4.min.css")}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{url("DASHBOARD_ASSETS/dist/img/AdminLTELogo.png")}}" alt="AdminLTELogo" height="60" width="60">
  </div>
  {{-- RUN IMAGES AND NAMES --}}
  @php
      $RESIDENT_OBJECT = ACCOUNT_IMAGE_RESOLVER("resident");
  @endphp

   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="javascript:void(0);" class="nav-link">@yield('page-title')</a>
      </li>
    </ul>
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ url($RESIDENT_OBJECT['DP_URL']) }}" alt="Profile Picture"  width="30" height="30" class="rounded-circle">
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{route('resident.profile')}}">Profile</a>
            <a class="dropdown-item" href="">Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
    
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{url("DASHBOARD_ASSETS/dist/img/AdminLTELogo.png")}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">VMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ url($RESIDENT_OBJECT['DP_URL']) }}" class="img-circle elevation-2" alt="Profile Image">
        </div>
          <div class="info">
            <a href="#" class="d-block">{{ $RESIDENT_OBJECT['NAME'] }}</a>
          </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
       
          
          <li class="nav-item">
            <a href="{{route('resident.dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('resident.profile')}}" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>Profile</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('resident.visitor.register')}}" class="nav-link">
              <i class="fas fa-id-badge nav-icon"></i>
              <p>Visitors Registration</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('resident.visitor.log')}}" class="nav-link">
              <i class="fas fa-book nav-icon"></i>
              <p>Visitors Log</p>
            </a>
          </li>
          </li>

          <li class="nav-item">
            <a href={{route("resident.visitor.validation")}} class="nav-link">
              <i class="fas fa-user-check nav-icon"></i>
              <p>Visitor Validation</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="pages/examples/profile.html" class="nav-link">
              <i class="fas fa-bell nav-icon"></i>
              <p>Notification</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="pages/examples/profile.html" class="nav-link">
              <i class="fas fa-question-circle nav-icon"></i>
              <p>Help/Support</p>
            </a>
          </li>

          <li class="nav-item">
            <!-- Add the logout form inside the "nav-link" anchor tag -->
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Sign Out</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      @yield('content')
 </div>
    <!-- /.content-header -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://unilorin.edu.ng">Unilorin Final Year Project</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>


</div>
<!-- ./wrapper -->
@yield('scripts')
<!--- Toastr -->
<script src="{{url("vendor/js/toastr.min.js")}}"></script>
<!-- jQuery -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url("DASHBOARD_ASSETS/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- ChartJS -->
<script src="{{url("DASHBOARD_ASSETS/plugins/chart.js/Chart.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{url("DASHBOARD_ASSETS/plugins/sparklines/sparkline.js")}}"></script>
<!-- JQVMap -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jqvmap/jquery.vmap.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/jqvmap/maps/jquery.vmap.usa.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url("DASHBOARD_ASSETS/plugins/jquery-knob/jquery.knob.min.js")}}"></script>
<!-- daterangepicker -->
<script src="{{url("DASHBOARD_ASSETS/plugins/moment/moment.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETS/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url("DASHBOARD_ASSETS/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
<!-- Summernote -->
<script src="{{url("DASHBOARD_ASSETS/plugins/summernote/summernote-bs4.min.js")}}"></script>
<!-- overlayScrollbars -->
<script src="{{url("DASHBOARD_ASSETS/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{url("DASHBOARD_ASSETS/dist/js/adminlte.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url("DASHBOARD_ASSETS/dist/js/pages/dashboard.js")}}"></script>
{{-- TOASTR --}}
<script src="{{url("DASHBOARD_ASSETS/plugins/sweetalert2/sweetalert2.min.js")}}"></script>
<script src="{{url("DASHBOARD_ASSETSplugins/toastr/toastr.min.js")}}"></script>
@if (session('success_message'))
    <script>
        Swal.fire('Success', '{{ session('success_message') }}', 'success');
    </script>
@elseif (session('error_message'))
<script>
    Swal.fire('Error', '{{ session('error_message') }}', 'error');
</script>
@endif
  
</body>
</html>
