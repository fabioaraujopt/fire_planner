<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../public_html/css/sb-admin-2.css" rel="stylesheet">

</head>

<style>
  .center_login {
    height: 100%;
    display: flex;
    align-items: center;
  }

  .login_logo {
    color: white;
    font-size: 2.5em;
  }
</style>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row container justify-content-center center_login">

      <div class="col-xl-5 col-lg-6 col-md-12">
          <div><span class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-text mx-3 login_logo"> <i class="fas fa-shield-alt"></i> Planner</div>
          </span></div>
          
        <div class="card o-hidden border-0 shadow-lg">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Bem Vindo</h1>
                  </div>
                  <form class="user" action="?" method="post">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user <?php if(isset($wrongCredentials)){echo 'is-invalid';}?>" id="exampleInputEmail" aria-describedby="emailHelp" value="<?php if(isset($email)){echo $email;}?>" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user <?php if(isset($wrongCredentials)){echo 'is-invalid';}?>" id="exampleInputPassword" placeholder="Password" value="<?php if(isset($password)){echo $password;}?>">
                    </div>
                      <input type="submit" name="login" style="display: none" />
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
