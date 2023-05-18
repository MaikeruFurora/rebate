<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Rebate</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- Begin page -->
        <div class=""></div>
        <div class="wrapper-page ">
            @if (session()->has('msg'))
                <div class="alert alert-{{ session()->get('action') ?? 'success' }}" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session()->get('msg') }}
                </div>
            @endif
            <div class="card card-pages">

                <div class="card-body">
                    <div class="text-center m-t-20 m-b-30">
                            <a href="index.html" class="logo logo-admin"><img src="assets/images/rebate-1.png" alt="" height="70"></a>
                    </div>
                    <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                    <form class="form-horizontal m-t-20" action="{{ route('auth.login.post') }}" method="POST">@csrf

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" name="Username" type="text" required placeholder="Username" autofocus maxlength="20" value="j.salcedo">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" name="Password" type="password" required placeholder="Password" maxlength="20" value="welcome">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Get Started</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>



        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

        <script src="{{}}"></script>

    </body>
</html>