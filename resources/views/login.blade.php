<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{URL::to('img/top.png')}}">
    <title>SMART Learning Program</title>

    <!-- Bootstrap -->
    <link href="{{URL::to('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{URL::to('gentelella/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{URL::to('gentelella/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{URL::to('gentelella/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{URL::to('gentelella/build/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="login">
    <div style="color:#ab0917" class="col-md-12">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper" class="col-md-12">
        <div class="animate form login_form" class="col-md-12">
          <section class="login_content">
            <form method="POST" action="">
              <h2>Login Form</h2>
              <h1 style="margin-bottom:5%;">SMART Learning Program</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="username" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password"/>
              </div>
              <div>
                <button class="btn btn-danger submit" type="submit">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="{{URL::to('img/cimb.png')}}"></h1>
                  <p>©2016 All Rights Reserved. Algorithm and Programming Laboratory ITS Surabaya</p>
                </div>
              </div>
              {{csrf_field()}}
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form col-md-12">
          <section class="login_content">
            <form method="POST" action="{{url('register')}}">
              <h2>Create Account</h2>
              <h1 style="margin-bottom:5%;">SMART Learning Program</h1>
              <div>
                <input type="text" class="form-control" placeholder="NIP" required="" name="nip" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Full Name" required="" name="name" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="username"/>
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" name="email"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="password"/>
              </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="{{URL::to('img/cimb.png')}}"></h1>
                  <p>©2016 All Rights Reserved. Algorithm and Programming Laboratory ITS Surabaya</p>
                </div>
              </div>
              {{csrf_field()}}
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>

  <!-- jQuery -->
    <script src="{{URL::to('gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{URL::to('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{URL::to('gentelella/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{URL::to('gentelella/vendors/nprogress/nprogress.js')}}"></script>
    <!-- validator -->
    <script src="{{URL::to('gentelella/vendors/validator/validator.js')}}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{URL::to('gentelella/build/js/custom.min.js')}}"></script>

    <!-- validator -->
</html>