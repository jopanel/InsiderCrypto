<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Insider Crypto Login</title>
  <!-- Bootstrap core CSS-->
  <link href="<?=base_url()?>resources/main/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?=base_url()?>resources/main/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?=base_url()?>resources/main/css/sb-admin.css" rel="stylesheet">
</head>

<body style="background-image: url(<?=base_url()?>resources/img/homebg.png); background-position:center; background-color: white;">
  <div class="container">
    <div class="row">
      <div class="col text-center" style="padding-top:50px;">
        <a href="<?=base_url()?>">
          <img src="<?=base_url()?>resources/img/homelogo.png" class="img-fluid header-logo">
        </a>
      </div>
    </div>
    <div class="card card-login mx-auto mt-5" style="-webkit-box-shadow: 30px 30px 138px -32px rgba(0,0,0,0.75);
-moz-box-shadow: 30px 30px 138px -32px rgba(0,0,0,0.75);
box-shadow: 30px 30px 138px -32px rgba(0,0,0,0.75); border-radius:10px;">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="post" action="<?=base_url()?>access/login">
          <div class="alert alert-danger" role="alert" style="<?=$style?>">
            <?php
            if ($error == 1) { echo "Too Many Login Attempts"; }
            if ($error == 2) { echo "Invalid Login Credentials."; }
        ?>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" type="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" type="password" name="password" placeholder="Password">
          </div>
          <input type="submit" class="btn btn-primary btn-block" value="Login">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?=base_url()?>access/register">Register an Account</a>
          <a class="d-block small" href="<?=base_url()?>access/forgot">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url()?>resources/main/vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>resources/main/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?=base_url()?>resources/main/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
