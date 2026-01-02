<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from www.themeturka.com/fixed-plus/layouts-5/table-data.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Feb 2019 23:17:06 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Prince Bank - Lucky Draw</title>
    <!-- Favicon icon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('newicon.ico')}}" /> --}}
    <!-- Common Plugins -->
    <link href="{{URL::to('src/assets/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- DataTables -->
    <link href="{{URL::to('src/assets/lib/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('src/assets/lib/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::to('src/assets/lib/datatables/buttons.dataTables.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom Css-->
    <link href="{{URL::to('src/assets/scss/style.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="{{URL::to('src/')}}https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="{{URL::to('src/')}}https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    @yield('style')
    <style>
        .nav-link.active {
            color: #fff !important;
            background-color: #747575 !important;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <!-- ============================================================== -->
    <!--                        Topbar Start                            -->
    <!-- ============================================================== -->
    <div class="top-bar light-top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <a class="admin-logo dark-logo" href="{{route('dashboard')}}">
                        <h1>
                            <img alt="" src="{{URL::to('src/image/logo-icon.png')}}" class="logo-icon margin-r-10">
                        </h1>
                    </a>
                    <div class="left-nav-toggle">
                        <a href="#" class="nav-collapse"><i class="fa fa-bars"></i></a>
                    </div>

                </div>
                <div class="col">
                    <ul class="list-inline top-right-nav">


                        <li class="dropdown avtar-dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <img alt="" class="rounded-circle" src="{{URL::to('src/assets/img/avtar-2.png')}}" width="30">
                                {{Auth::user()->name}}
                            </a>
                            <ul class="dropdown-menu top-dropdown">
                                <li>
                                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-logout"></i> Logout</a>
                                </li>
                                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!--                        Topbar End                              -->
    <!-- ============================================================== -->




    <!-- ============================================================== -->
    <!--                        Navigation Start                        -->
    <!-- ============================================================== -->
    <div class="main-sidebar-nav dark-navigation">
        <div class="nano">
            <div class="nano-content sidebar-nav">

                <div class="card-body border-bottom text-center nav-profile">
                    <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                    <img alt="profile" class="margin-b-10  " src="{{URL::to('src/assets/img/avtar-2.png')}}" width="80">
                    <p class="lead margin-b-0 toggle-none">{{Auth::user()->name}}</p>
                    <p class="text-muted mv-0 toggle-none">Welcome</p>
                </div>

                <ul class="metisMenu nav flex-column" id="menu">
                    <li class="nav-heading"><span>MAIN MENU</span></li>
                    @yield('menu')
                </ul>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!--                        Navigation End                          -->
    <!-- ============================================================== -->


    <!-- ============================================================== -->
    <!--                        Content Start                           -->
    <!-- ============================================================== -->

    @yield('breadcrumb')

    <section class="main-content">

        @yield('content')
        <footer class="footer">
            <span>Prince bank Lucky draw V2 @ 2021</span>
        </footer>


    </section>
    <!-- ============================================================== -->
    <!--                        Content End                             -->
    <!-- ============================================================== -->



    <!-- Common Plugins -->
    <script src="{{URL::to('src/assets/lib/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/pace/pace.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/nano-scroll/jquery.nanoscroller.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/metisMenu/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('src/assets/js/custom.js')}}"></script>
    <script src="{{URL::to('src/js/xlsx.full.min.js')}}"></script>

    <!-- Datatables-->
    <script src="{{URL::to('src/assets/lib/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/datatables/dataTables.responsive.min.js')}}"></script>

    <script src="{{URL::to('src/assets/lib/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/datatables/jszip.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/datatables/pdfmake.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/datatables/vfs_fonts.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/datatables/buttons.html5.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').dataTable();

            $('#datatable2').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                  [ 10, 25, 50, -1 ],
                  [ '10 rows', '25 rows', '50 rows', 'Show all' ]
               ],
                buttons: [
                    'pageLength',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });

            $('#datatable3').DataTable({
                "scrollY": "400px",
                "scrollCollapse": true,
                "paging": false
            });
        });
    </script>
    @yield('javascript');
</body>

<!-- Mirrored from www.themeturka.com/fixed-plus/layouts-5/table-data.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Feb 2019 23:17:17 GMT -->

</html>
