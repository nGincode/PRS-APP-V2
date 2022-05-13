<?php
use App\Models\User;
use App\Models\Groups;
use App\Models\GroupsUsers;

if (Auth::check()) {
    $DataUsers = User::where('id', Auth::id())->first();

    if (
        request()
            ->session()
            ->has('id')
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
        $Tipe = request()
            ->session()
            ->get('tipe');
        $Logo = request()
            ->session()
            ->get('logo');
        $active = request()
            ->session()
            ->get('active');
    } else {
        $Id = Auth::id();
        $Username = $DataUsers['username'];
        $Email = $DataUsers['email'];
        $Store = $DataUsers['store'];
        $StoreId = $DataUsers['store_id'];
        $Tipe = $DataUsers['tipe'];
        $Logo = $DataUsers['logo'];
        $active = $DataUsers['active'];

        request()
            ->session()
            ->put('id', $Id);
        request()
            ->session()
            ->put('username', $Username);
        request()
            ->session()
            ->put('email', $Email);
        request()
            ->session()
            ->put('store', $Store);
        request()
            ->session()
            ->put('store_id', $StoreId);
        request()
            ->session()
            ->put('tipe', $Tipe);
        request()
            ->session()
            ->put('logo', $Logo);
    }

    if (file_exists('/uploads/logo/' . $Logo)) {
        $urlLogo = url('/uploads/logo/' . $Logo);
    } else {
        $urlLogo = url('/assets/images/unnamed.png');
    }

    $DataGroup = GroupsUsers::join('groups', 'groups.id', '=', 'groups_users.groups_id')
        ->where('groups_users.users_id', $Id)
        ->first();
    if ($DataGroup) {
        $user_permission = unserialize($DataGroup['permission']);
    } else {
        $user_permission = [];
        session()->put('err', 'Akun Ini Belum Memiliki Groups');
        echo '<script>window.location.href = "' . url('/logout') . '";</script>';
    }

    if (!$active) {
        session()->put('err', 'Store Tidak Aktif Silahkan Hub Admin');
        echo '<script>window.location.href = "' . url('/logout') . '";</script>';
    }
    if ($title && $subtitle) {
        $urlmanage = url('/' . $title . '/Manage' . '/' . $subtitle);
    } else {
        $urlmanage = url('/' . $title . '/Manage');
    }
} else {
    echo '<script>window.location.href = "' . url('/logout') . '";</script>';
    $urlLogo = url('/assets/images/unnamed.png');
    $user_permission = '';
}

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

    <!-- animated -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    {{-- Admin LTE BASE TAMPLATE --}}
    <link rel="stylesheet" href="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/dist/css/adminlte.min.css">


    <!-- jQuery -->
    <script src="{{ url('/') }}/Admin-LTE/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
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
    <script src="{{ url('/') }}/assets/js/numeral.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>



    <script>
        //DataTable
        $(function() {
            if ($("#manage").length) {
                var cells = document.getElementById('manage').getElementsByTagName('th').length - 1;

                var jmlcolm = '';
                for (let index = 0; index < cells; index++) {
                    if (cells - 1 == index) {
                        jmlcolm += index;
                    } else {
                        jmlcolm += index + ',';
                    }
                }

                $("#manage").DataTable({
                    "ajax": {
                        url: "{{ $urlmanage }}",
                        type: "POST",
                    },
                    "responsive": true,
                    "autoWidth": true,
                    "processing": true,
                    "searching": true,
                    "sort": true,
                    "paging": true,
                    "destroy": true,
                    "dom": '<"dt-buttons"Bf><"clear">lirtp',
                    "buttons": [{
                            extend: 'copyHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [jmlcolm]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [jmlcolm]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [jmlcolm]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [jmlcolm]
                            }
                        },
                        {
                            extend: 'print',
                            messageTop: '',
                            title: '{{ $manage ?? '' }}',
                            exportOptions: {
                                columns: [jmlcolm]
                            }
                        }
                    ]
                }).buttons().container().appendTo('#manage_wrapper .col-md-6:eq(0)');
            }

        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
        }


        const animateCSS = (element, animation, prefix = 'animate__') =>
            // We create a Promise and return it
            new Promise((resolve, reject) => {
                const animationName = `${prefix}${animation}`;
                const node = document.querySelector(element);

                node.classList.add(`${prefix}animated`, animationName);

                // When the animation ends, we clean the classes and resolve the Promise
                function handleAnimationEnd(event) {
                    event.stopPropagation();
                    node.classList.remove(`${prefix}animated`, animationName);
                    resolve('Animation ended');
                }

                node.addEventListener('animationend', handleAnimationEnd, {
                    once: true
                });
            });
    </script>

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


                        @if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission))
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


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item @if ($title == 'Master') menu-is-opening menu-open @endif ">
                                <a href="{{ url('/Master') }}"
                                    class="nav-link @if ($title == 'Master') active @endif ">
                                    <i class=" nav-icon fas fa-database"></i>
                                    <p>
                                        Master Data
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/Master/Supplier') }}"
                                            class="nav-link @if ($subtitle == 'Supplier') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Supplier</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Master/Bahan') }}"
                                            class="nav-link @if ($subtitle == 'Bahan') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bahan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Master/Peralatan') }}"
                                            class="nav-link @if ($subtitle == 'Peralatan') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Peralatan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Master/Pegawai') }}"
                                            class="nav-link @if ($subtitle == 'Pegawai') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pegawai</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item  @if ($title == 'Inventory') menu-is-opening menu-open @endif ">
                                <a href="{{ url('/Inventory') }}"
                                    class="nav-link @if ($title == 'Inventory') active @endif ">
                                    <i class=" nav-icon fas fa-cube"></i>
                                    <p>
                                        Inventory
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item ">
                                        <a href="{{ url('/Inventory/Opname') }}"
                                            class="nav-link  @if ($subtitle == 'Opname') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Opname</p>
                                        </a>
                                    </li>
                                    <li class="nav-item  ">
                                        <a href="{{ url('/Inventory/Stock') }}"
                                            class="nav-link @if ($subtitle == 'Stock') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stock</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- @if (in_array('createPemesanan', $user_permission) || in_array('updatePemesanan', $user_permission) || in_array('viewPemesanan', $user_permission) || in_array('deletePemesanan', $user_permission)) --}}
                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item @if ($title == 'Pemesanan') menu-open @endif ">
                                <a href="
                                {{ url('/Pemesanan') }}"
                                    class="nav-link @if ($title == 'Pemesanan') active @endif ">
                                    <i class=" nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Pemesanan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/Pemesanan/PR') }}"
                                            class="nav-link @if ($subtitle == '(PR)') active @endif">
                                            <i class="far fa-circle nav-icon "></i>
                                            <p>Purchase Request (PR)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Pemesanan/PRAgree') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Persetujuan (PR)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Pemesanan/PO') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Purchase Order (PO)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Pemesanan/Supplier') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stock Logistik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item @if ($title == 'Foodcost') menu-open @endif ">
                                <a href=" #" class="nav-link @if ($title == 'Foodcost') active @endif ">
                                    <i class=" nav-icon fas fa-pepper-hot"></i>
                                    <p>
                                        Foodcost
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/Foodcost/Olahan') }}"
                                            class="nav-link @if ($subtitle == 'Olahan') active @endif">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bahan Olahan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Foodcost/Varian') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Varian</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/Foodcost/Resep') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Resep Menu</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Point Of Sales
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif





                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-camera"></i>
                                    <p>
                                        Absensi
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-ticket-alt"></i>
                                    <p>
                                        Voucher
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p>
                                        Belanja
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif



                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-sign-in-alt"></i>
                                    <p>
                                        Pengadaan
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif

                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item ">
                                <a href="{{ url('/Master') }}"
                                    class="nav-link @if ($title == 'Peralatan') active @endif ">
                                    <i class=" nav-icon fas fa-gavel"></i>
                                    <p>
                                        Peralatan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../forms/general.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Opname</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../forms/general.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stock</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        @if (in_array('createMaster', $user_permission) || in_array('updateMaster', $user_permission) || in_array('viewMaster', $user_permission) || in_array('deleteMaster', $user_permission))
                            <li class="nav-item ">
                                <a href="{{ url('/Produksi') }}"
                                    class="nav-link @if ($title == 'Produksi') active @endif ">
                                    <i class=" nav-icon fas fa-sign-language"></i>
                                    <p>
                                        Produksi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../forms/general.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Opname</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../forms/general.html" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stock</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


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
                            <h1 class="m-0"><b>{{ $title }} {{ $subtitle ?? '' }}</b>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active">{{ $title }}</li>
                                @if ($subtitle)
                                    <li class="breadcrumb-item active">{{ $subtitle }}</li>
                                @endif
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
        <div class="modal-dialog modal-lg">
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
    <script src="{{ url('/') }}/assets/js/jquery.validate.min.js"></script>

    <!-- Sweetalert -->
    <script src="{{ url('/vendor/sweetalert/sweetalert.all.js') }}"></script>



    <script src="{{ url('/') }}/assets/js/js.js"></script>

    @include('sweetalert::alert')
</body>

</html>
