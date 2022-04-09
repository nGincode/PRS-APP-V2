<?php

use App\Models\Users;
use App\Models\Groups;
use App\Models\GroupsUsers;

if (
    request()
        ->session()
        ->has('logged_in')
) {
    $Id = request()
        ->session()
        ->get('id');
    $Username = request()
        ->session()
        ->get('username');
    $Email = request()
        ->session()
        ->get('email');
    $Store = request()
        ->session()
        ->get('store');
    $StoreId = request()
        ->session()
        ->get('store_id');
    $GroupId = request()
        ->session()
        ->get('group_id');
    $Divisi = request()
        ->session()
        ->get('divisi');
    $Tipe = request()
        ->session()
        ->get('tipe');
    $Logo = request()
        ->session()
        ->get('logo');
} else {
    echo '<script>window.location.href = "' . url('/logout') . '";</script>';
}

if (file_exists('/uploads/logo/' . $Logo)) {
    $urlLogo = url('/uploads/logo/' . $Logo);
} else {
    $urlLogo = url('/assets/images/unnamed.png');
}

$DataGroup = GroupsUsers::join('groups', 'groups.id', '=', 'groups_users.group_id')
    ->where('groups_users.user_id', $Id)
    ->first();
$user_permission = unserialize($DataGroup['permission']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ url('/') }}/assets/images/logo/prslogin.png" sizes="10x16">
    <title>{{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">


    {{-- PLUGIN --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- summernote -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css">


    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    {{-- Admin LTE BASE TAMPLATE --}}
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('/') }}/assets/images/logo/prslogin.png" alt="PRS Logo"
                height="60" width="120">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item" style="margin-left:-10px;">
                    <a class="nav-link"><b>{{ $Store }}</b></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
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
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item" style="background-color: #ffcece;">
                    <a class="nav-link" href="{{ url('logout') }}" title="logout">
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
                <img src="{{ url('/') }}/assets/images/logo/prslogin.png" alt="PRS Logo" class="brand-image"
                    width="60" style="opacity: .8;margin-left: -5px;">
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
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>




                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link @if ($title == 'Dashboard') active @endif">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        @if (in_array('createStore', $user_permission) || in_array('updateStore', $user_permission) || in_array('viewStore', $user_permission) || in_array('deleteStore', $user_permission))
                            <li class="nav-item ">
                                <a href="{{ url('/Store') }}"
                                    class="nav-link @if ($title == 'Store') active @endif ">
                                    <i class=" nav-icon fas fa-home"></i>
                                    <p>
                                        Stores
                                    </p>
                                </a>
                            </li>
                        @endif


                        @if (in_array('createGrou', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission))
                            <li class="nav-item ">
                                <a href="{{ url('/Group') }}"
                                    class="nav-link @if ($title == 'Group') active @endif ">
                                    <i class=" nav-icon fas fa-users"></i>
                                    <p>
                                        Groups
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission))
                            <li class="nav-item ">
                                <a href="{{ url('/Users') }}"
                                    class="nav-link @if ($title == 'Users') active @endif ">
                                    <i class=" nav-icon fas fa-user"></i>
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
            <strong>PRS Copyright &copy; {{ date('Y') }} Theme By : <a href="https://adminlte.io">AdminLTE.io</a>
            </strong>
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



    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white bg-dark mb-3">
                    <h5 class="modal-title" id="ModalLabel" style="font-weight: bolder"></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="ModelView"></div>
            </div>
        </div>
    </div>






    <!-- jQuery -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <!-- Bootstrap 4 -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js">
    </script>

    <!-- ChartJS -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js"></script>

    <!-- Sparkline -->
    {{-- <script src="{{url('/'); }}/Admin-LTE/AdminLTE-3.2.0/plugins/sparklines/sparkline.js"></script> --}}

    <!-- JQVMap -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

    <!-- jQuery Knob Chart -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js"></script>

    <!-- daterangepicker Input Mask -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/moment/moment.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap color picker -->
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js">
    </script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <!-- Bootstrap Switch -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bootstrap-switch/js/bootstrap-switch.min.js">
    </script>

    <!-- BS-Stepper -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <!-- dropzonejs -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/dropzone/min/dropzone.min.js"></script>

    <!-- Summernote -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js"></script>

    <!-- overlayScrollbars -->
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js">
    </script>

    <!-- AdminLTE App -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/dist/js/adminlte.js"></script>

    <!-- File input -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js">
    </script>

    <!-- Validate -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <!-- Sweetalert -->
    <script src="{{ url('/vendor/sweetalert/sweetalert.all.js') }}"></script>


    <!-- DataTables  & Plugins -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
    </script>
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script
        src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js">
    </script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js">
    </script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jszip/jszip.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js">
    </script>

    <script src="assets/js/js.js"></script>
    <style>
        label.error {
            display: block;
            float: right;
            color: red;
            font-size: small;
        }

    </style>
    <script>
        //DataTable
        $(function() {
            if ($("#manage").length) {
                $("#manage").DataTable({
                    "responsive": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "buttons": [{
                            extend: 'copyHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [0, 1, 2, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [0, 1, 2, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [0, 1, 2, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [0, 1, 2, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            messageTop: '',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [0, 1, 2, 4, 5, 6]
                            }
                        }
                    ]
                }).buttons().container().appendTo('#manage_wrapper .col-md-6:eq(0)');
            }
        })
    </script>
    @include('sweetalert::alert')
</body>

</html>
