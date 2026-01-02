<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from www.themeturka.com/fixed-plus/layouts-5/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Feb 2019 23:18:17 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prince Bank - Lucky Draw</title>
    <!-- Favicon icon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('newicon.ico')}}" /> --}}
    <!-- Common Plugins -->
    <link href="{{URL::to('src/assets/lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Css-->
    <link href="{{URL::to('src/assets/scss/style.css')}}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <style type="text/css">
        html,
        body {
            height: 100%;
        }
    </style>
</head>

<body class="bg-light" style="background-image: url({{URL::to('src/image/04.jpg')}});background-size: cover;height: 100%;overflow: hidden;">
    <form method="POST" action="{{ route('sginin') }}">
        @csrf
        <div class="misc-wrapper">
            <div class="misc-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-4">
                            <div class="misc-header text-center">

                                <img alt="" src="{{URL::to('src/image/logo-icon.png')}}" class="toggle-none hidden-xs">
                            </div>
                            <div class="misc-box">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="exampleuser1">Username</label>
                                        <div class="group-icon">
                                            <input id="exampleuser1" type="text" placeholder="Username" class="form-control" required="" name="email" required>
                                            <span class="icon-user text-muted icon-input"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <div class="group-icon">
                                            <input id="exampleInputPassword1" type="password" placeholder="Password" class="form-control" name="password" required>
                                            <span class="icon-lock text-muted icon-input"></span>
                                        </div>
                                    </div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>Please Confirm Your Inputs!!</li>
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="clearfix">

                                        <div class="float-right">
                                            <button type="submit" class="btn btn-block btn-primary btn-rounded box-shadow">Login</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="text-center misc-footer">
                                <p>Copyright &copy; 2021 Prince Bank</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Common Plugins -->
    <script src="{{URL::to('src/assets/lib/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/pace/pace.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/jasny-bootstrap/js/jasny-bootstrap.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/nano-scroll/jquery.nanoscroller.min.js')}}"></script>
    <script src="{{URL::to('src/assets/lib/metisMenu/metisMenu.min.js')}}"></script>
    <script src="{{URL::to('src/assets/js/custom.js')}}"></script>

</body>

<!-- Mirrored from www.themeturka.com/fixed-plus/layouts-5/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Feb 2019 23:18:17 GMT -->

</html>
