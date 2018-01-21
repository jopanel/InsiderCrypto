<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <div class="content-wrapper">
    <div class="container-fluid"> 
      <div class="row">
	    <div class="col">


	    	<div class="card mb-3">
	      		<div class="card-header">
              </i> Change Email</div>
              <div class="card-body"> 

              	<form method="post" action="">
              	  <input type="hidden" name="action" value="changeemail">
				  <div class="form-group">
				    <label for="New Email">New Email</label>  
				    <input type="text" name="email" class="form-control">
				    <small>Changing your email requires verification on the new email address</small>
				  </div> 
				  <div class="form-group">
				  	<input type="submit" class="btn btn-primary" value="Change Email">
				  </div>
				</form>

              </div>
            </div>
	      

	    	<div class="card mb-3">
	      		<div class="card-header">
              </i> Change Password</div>
              <div class="card-body"> 

              	<form method="post" action="">
              	  <input type="hidden" name="action" value="changepw">
				  <div class="form-group">
				    <label for="Password">New Password</label>
				    <input type="password" name="password" class="form-control">
				  </div>
				  <div class="form-group">
				    <label for="Password Confirmation">Retype Password</label>
				    <input type="password" name="password2" class="form-control">
				  </div>
				  <div class="form-group">
				  	<input type="submit" class="btn btn-primary" value="Change Password">
				  </div>
				</form>

              </div>
            </div>


	    </div>

	    <!-- START SECOND COLUMN --> 
	    <?php if (empty($userdata["lsk_address"])) { ?>
	    	<div class="col">
		    	<div class="card mb-3">
		      		<div class="card-header">
	              </i> Update Lisk Address</div>
	              <div class="card-body"> 

	              	<form method="post" action="">
	              	  <input type="hidden" name="action" value="changelskaddress">
					  <div class="form-group">
					    <label for="Address">Address</label>  
					    <input type="text" name="address" placeholder="example: 4287319913737945577L" class="form-control">
					    <small>Required <b><u>BEFORE</u></b> payment is made.</small>
					  </div> 
					  <div class="form-group">
					  	<input type="submit" class="btn btn-primary" value="Update">
					  </div>
					</form>

	              </div>
	            </div>
	    <?php } ?>
	    




	      	<div class="card mb-3">
	      		<div class="card-header">
              <i class="fa fa-certificate"></i> Get Notifications</div>
              <div class="card-body"> 

              	<p>To receive notifications via email when new opporunities are found for your threshold and markets set you must validate your email address.</p>
              	<center><p><button class="btn btn-primary" onClick="sendVerification()">Send Verification</button></p></center>

              </div>
            </div>

            <?php 
            if ($userdata["vip"] == 1) { ?>
	            <div class="card mb-3"> 
	              <div class="card-body btn btn-success"> 

	              	VIP STATUS

	              </div>
	            </div> 
           <?php } else {
	            if ($paidstatus == FALSE) { ?>
	            	<div class="card mb-3"> 
		              <div class="card-body btn btn-danger"> 

		              	UNPAID SUBSCRIPTION

		              </div>
		            </div> 
	           <?php } else { ?>
	            	<div class="card mb-3"> 
		              <div class="card-body btn btn-success"> 

		              	PAID SUBSCRIPTION

		              </div>
		            </div> 
	           <?php }
	        } ?>

            





	    </div>

	    <!-- START THIRD COLUMN -->
	    <div class="col">


	    	<div class="card mb-3">
	      		<div class="card-header">
              Account Information</div>
              <div class="card-body"> 

              	<strong>Changing Email</strong>
              	<p>To change to a new email address you will receive an email verification on the new email. Your email will not be changed until the email is verified by clicking the link in the email. You will not be able to use "forgot password" function if you do not have access to your email address.</p> 

              	<strong>Join Date</strong>
              	<p><?=date("m/d/Y", $userdata["created"])?></p>

              	<strong>Username</strong>
              	<p><?=$userdata["username"]?></p>

              	<strong>Email</strong>
              	<p><?=$userdata["email"]?></p>

              	<strong>Member Status</strong>
              	<p>
              	<?php if ($userdata["vip"] == 1) { echo "VIP STATUS"; } else {
              		if ($paidstatus == TRUE) { echo "PAID"; } else { echo "UNPAID"; }
              	} ?>
              	</p>

              	<strong>Logged In IP Addresses</strong>
              	<p><?php foreach ($userdata["ips"] as $v) { echo $v."<br>"; } ?></p>

              </div>
            </div>


	    </div>
	  </div>
    </div>
