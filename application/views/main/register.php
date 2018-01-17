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
  <title>Insider Crypto Registration</title>
  <!-- Bootstrap core CSS-->
  <link href="<?=base_url()?>resources/main/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?=base_url()?>resources/main/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?=base_url()?>resources/main/css/sb-admin.css" rel="stylesheet"> 
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <div class="alert alert-danger" role="alert">
          <strong>Oh snap!</strong> Change a few things up and try submitting again.
        </div>
        <div class="alert alert-success" role="alert">
          <strong>Well done!</strong> You successfully read this important alert message.
        </div>
        <form method="post" action="<?=base_url()?>access/register">
          <div class="form-group">
            <label>Chat Alias/Username</label>
            <input class="form-control" type="text" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Email address</label>
            <input class="form-control" type="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label>Password</label>
                <input class="form-control" type="password" placeholder="Password">
              </div>
              <div class="col-md-6">
                <label>Confirm password</label>
                <input class="form-control" type="password" placeholder="Confirm password">
              </div>
            </div>
          </div>
          <p>By registering you agree to our <a href="<?=base_url()?>docs/privacy">privacy policy</a> and <a href="<?=base_url()?>docs/terms">terms of service</a>.</p>
          <input type="submit" class="btn btn-primary btn-block" value="Register">
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?=base_url()?>access/login">Login Page</a>
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
