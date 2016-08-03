<!DOCTYPE html>
<html lang="en">
<title>CIMB Niaga</title>
<link rel="icon" type="image/png" href="{{URL::to('img/top.png')}}">
<head>
    @include('master.header')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- page content -->
            @include('master.navbar')
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
</body>
        @include('master.footer')
       <footer style="background-color:#cccccc">
        <div class="col-md-12" style="background-color:#cccccc;padding-bottom:20px;">
          <div class="pull-right" style="background-color:#cccccc;color:black">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            <!-- <img src="{{URL::to('img/navbar.png')}}" style="width:100%;float:right;margin-bottom:-100px;"> -->
          </div>
          <div class="clearfix"></div>
        </div>
        </footer>
<!-- footer content -->

<!-- /footer content -->
</html>
