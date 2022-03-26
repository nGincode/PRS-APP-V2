<?php
use App\Models\Users;
use App\Models\Groups;
use App\Models\GroupsUsers;

if (request()->session()->has('logged_in')) {
    $Id = request()->session()->get('id');
    $Username = request()->session()->get('username');
    $Email = request()->session()->get('email');
    $Store = request()->session()->get('store');
    $StoreId = request()->session()->get('store_id');
    $GroupId = request()->session()->get('group_id');
    $Divisi = request()->session()->get('divisi');
    $Tipe = request()->session()->get('tipe');
    $Logo = request()->session()->get('logo');
}else{
	echo '<script>window.location.href = "' . url('/logout') . '";</script>';
}

if(file_exists('/uploads/logo/' . $Logo)){ 
        $urlLogo = url('/uploads/logo/' . $Logo);
    }else{  
        $urlLogo = url('/uploads/ivn_image/unnamed.png');
}

$DataGroup = GroupsUsers::join('groups', 'groups.id', '=', 'groups_users.group_id')->where('groups_users.user_id', $Id)->first();
$user_permission = unserialize($DataGroup['permission']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="_token" content="{!! csrf_token() !!}" />
  <title>PRS System Application</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 

  {{-- PLUGIN --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css">

  {{-- Admin LTE BASE TAMPLATE --}}
  <link rel="stylesheet" href="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/dist/css/adminlte.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{url('/'); }}/assets/images/logo/prslogin.png" alt="PRS Logo" height="60" width="120">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item"  style="margin-left:-10px;" >
        <a class="nav-link"><b>{{ $Store }}</b></a>
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
      <li class="nav-item" style="background-color: #ffcece;">
        <a class="nav-link"  href="{{ url('logout') }}" title="logout">
           <b> <i class="fas fa-times"></i> Logout</b>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{url('/'); }}/assets/images/logo/prslogin.png" alt="PRS Logo" class="brand-image" width="60" style="opacity: .8;margin-left: -5px;">
      <span class="brand-text font-weight-light"> Application</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ $urlLogo }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $Username }}</a>
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
            
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link @if($title === "Dashboard") active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          @if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) 
          <li class="nav-item ">
            <a href="{{ url('/users') }}" class="nav-link @if($title === "Users") active @endif ">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          @endif
          
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->




    </div>
    <!-- /.sidebar -->
  </aside>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
              <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



  @yield('isi')
  </div>
  <!-- /.content-wrapper -->



  
  <footer class="main-footer">
    <strong>PRS Copyright &copy; {{ date('Y') }} Theme By : <a href="https://adminlte.io">AdminLTE.io</a>  </strong>
    <div class="float-right d-none d-sm-inline-block">
        Created By : <a href="https://instagram.com/fembinurilham">Fembi Nur Ilham</a> 
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Select2 -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js"></script>

<!-- Bootstrap4 Duallistbox -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<!-- ChartJS -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>

<!-- Sparkline -->
{{-- <script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/sparklines/sparkline.js"></script> --}}

<!-- JQVMap -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<!-- jQuery Knob Chart -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- daterangepicker Input Mask -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/moment/moment.min.js"></script>
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js"></script>

<!-- bootstrap color picker -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Bootstrap Switch -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- BS-Stepper -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<!-- dropzonejs -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.js"></script>

<!-- Summernote -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js"></script>

<!-- overlayScrollbars -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE App -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/dist/js/adminlte.js"></script>

<!-- File input -->
<script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- Validate -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

<!-- Sweetalert -->
<script src="{{ url('/vendor/sweetalert/sweetalert.all.js') }}"></script>

<script>
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });

  function popup($icon, $toast, $pesan){
    if($toast == true){
      if($icon === 'success'){
        Swal.fire({
          "toast":true,
          "icon": $icon,
          "position":"top-end",
          "title": $pesan,
          "text":"",
          "timer":5000,
          "width":"32rem",
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":true,
          "timerProgressBar":false,
          "customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},
        });
      }else if($icon === 'info'){
        Swal.fire({
          "toast":true,
          "icon": $icon,
          "position":"top-end",
          "title": $pesan,
          "text":"",
          "timer":5000,
          "width":"32rem",
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":true,
          "timerProgressBar":false,
          "customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},
        });
      }else if($icon === 'warning'){
        Swal.fire({
          "toast":true,
          "icon": $icon,
          "position":"top-end",
          "title": $pesan,
          "text":"",
          "timer":5000,
          "width":"32rem",
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":true,
          "timerProgressBar":false,
          "customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},
        });
      }else if($icon === 'question'){
        Swal.fire({
          "toast":true,
          "icon": $icon,
          "position":"top-end",
          "title": $pesan,
          "text":"",
          "timer":5000,
          "width":"32rem",
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":true,
          "timerProgressBar":false,
          "customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},
        });
      }else{
        Swal.fire({
          "toast":true,
          "icon":"error",
          "position":"top-end",
          "title": $pesan,
          "text":"",
          "timer":5000,
          "width":"32rem",
          "padding":"1.25rem",
          "showConfirmButton":false,
          "showCloseButton":true,
          "timerProgressBar":false,
          "customClass":{"container":null,"popup":null,"header":null,"title":null,"closeButton":null,"icon":null,"image":null,"content":null,"input":null,"actions":null,"confirmButton":null,"cancelButton":null,"footer":null},
        });
      }
    }else{

    }
    
  }

$(document).ready(function() {
  //users
  if ($('#FormUsers').length) {
    $('#FormUsers').validate({
      errorClass: 'error',
      rules: {
        'OutletUsers': {
          required: true
        },
        'GroupsUsers': {
          required: true
        },
        'Email': {
          required: true,
          email: true
        },
        'Username': {
          required: true,
          minlength: 6
        },
        'PasswordUsers': {
          required: true,
          minlength: 6
        },
        'PasswordRipet': {
          required: true,
          equalTo: "#PasswordUsers"
        },
        'NamaDepanUsers': {
          required: true
        },
        'NamaBelakangUsers': {
          required: true
        },
        'NoUsers': {
          required: true
        }
      }, 
      messages : {
        // OutletUsers : "Masih Kosong"
      }
    });

    $('#FormUsers').on('submit', function(event){ 
      var isValid = $(this).valid();
      event.preventDefault();

      if (isValid) {
        $.ajax({
              url: "{{ url('/users') }}",
              type: "POST",
              data: $(this).serialize(),
              dataType: 'json',
              success: function (data) {
                if(data.status === 'success'){
                  popup(data.status, data.toast, data.pesan);
                  $('#FormUsers')[0].reset();
                }else{
                  popup(data.status, data.toast, data.pesan);
                }
              }
        });
        
      }    
    });  
  }
});
 </script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
    
    bsCustomFileInput.init();

  })
</script>
<style>
  label.error{ display: block; float: right; color: red; font-size: small;}
</style>
@include('sweetalert::alert')
</body>
</html>
