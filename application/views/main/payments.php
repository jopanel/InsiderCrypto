<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col">

          <div class="card mb-3">
            <div class="card-header">
              Payments</div>
            <div class="card-body">
              <?php
              // steps:
              // step 1 - no lisk address, make them add theirs
              // step 2 - ask to initalize the order process
              // step 3 - wait for user to insert transaction ID or start a new order
              if ($paidstatus == FALSE) {
                if ($paymentstep == 1) {

                } elseif ($paymentstep == 2) {

                } elseif ($paymentstep == 3) {

                }
              } else {
                echo "<center><h1>Thanks for joining!</h1><p>We recommend you update your preferences if you haven't already. Please make sure to follow the rules.</p></center>";
              }

              ?>
            </div> 
          </div>

        </div> 
      </div>
    </div>
  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
