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
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="<?=base_url()?>resources/main/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?=base_url()?>resources/main/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?=base_url()?>resources/main/css/sb-admin.css" rel="stylesheet">
</head>

<body style="background-image: url(<?=base_url()?>resources/img/log-bg.jpg); background-position:center; background-color: #000;">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Reset Password</div>
      <div class="card-body">
        <div class="text-center mt-4 mb-5">
          <h4>Forgot your password?</h4>
          <p>Enter your email address and we will send you instructions on how to reset your password.</p>
        </div>
        <form>
          <div class="form-group">
            <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email address">
          </div>
          <input type="submit" class="btn btn-primary btn-block" value="Reset Password">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?=base_url()?>access/register">Register an Account</a>
          <a class="d-block small" href="<?=base_url()?>access/login">Login Page</a>
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
