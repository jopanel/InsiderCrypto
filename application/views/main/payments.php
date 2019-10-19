<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



  <div class="content-wrapper">
    <div class="container-fluid">
      <?php 

      if ($error == 1) { ?>
      <div class="alert alert-danger" role="alert">
      There was a problem with your request.
    </div>
     <?php }

      if ($order["expired"] == false && $paidstatus == FALSE) {
        ?>
        <div class="row">
          <div class="col">
            <div class="alert alert-success" role="alert">
              Please send <b><?=$order["amount_requested"]?> LSK</b> to Lisk Address <b><?=$order["address"]?></b>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                  Invoice</div>
                <div class="card-body">
                  <h3>Thanks for your purchase</h3>
                  
                  <p>Once we receive the <?=$order["amount_requested"]?> LSK to address <?=$order["address"]?> we will automatically update your account status to paid.</p>
                  <p>Don't forget to update your account preferences and choose the exchanges you use if you haven't already.</p>
                  <p style="color: red">You have <span id="timeleft"></span> time left to send the payment</p>
                </div>
            </div>
          </div>
        </div>
        <?php
        $verbage = "Change";
      } else {
        $verbage = "Start";
        
      }
      ?>


      <div class="row">
        <div class="col">

          <div class="card mb-3">
            <div class="card-header">
              Payments</div>
            <div class="card-body">
              <?php
              /*
                return 2 - awaiting payment confirmation
                return 3 - needs assigned a new order
              */
              if ($paidstatus == FALSE) { ?>
                <h3>What type of trader are you?</h3>
                <p>We offer different packages for different people. While we understand our prices may be extremely cheap to some they can be rather expensive to others. We hope that by using our program you will maximize your crypto income. Most traders that use these tools make the cost of premium back in their first trade. Currently we are only accepting payments in <a target="_blank" href="https://coinmarketcap.com/currencies/lisk/#markets">Lisk</a>.</p>

                <div class="row">
                  <div class="col">

                    <div class="card mb-3">
                      <div class="card-header">
                        Beginner Trader</div>
                      <div class="card-body">
                        <p><b>1 Month Premium</b></p> 
                        <p>Access to all AI generated features/functionality</p>
                        <p>Receive E-Mail Notifications based on your Preferences</p>
                        <p>Access to future updates and access for premium users</p>
                        <?php if ($order["expired"] == true) { ?>
                        <h3><?=$programcost["beginner"]?> Lisk (LSK)</h3>
                        <form method="post" action="">
                          <input type="hidden" name="type" value="beginner">
                          <input type="submit" class="btn btn-primary" value="<?=$verbage?> Payment">
                        </form>
                        <?php } ?>
                        <p><small>This is a one month package. After one month your premium will expire and you will lose access.</small></p>
                      </div>
                    </div>

                  </div>
                  <div class="col">

                    <div class="card mb-3">
                      <div class="card-header">
                         Trader</div>
                      <div class="card-body">
                        <p><b>12 Month Premium</b></p> 
                        <p>Access to all AI generated features/functionality</p>
                        <p>Receive E-Mail Notifications based on your Preferences</p>
                        <p>Access to future updates and access for premium users</p>
                        <?php if ($order["expired"] == true) { ?>
                        <h3><?=$programcost["trader"]?> Lisk (LSK)</h3>
                        <form method="post" action="">
                          <input type="hidden" name="type" value="trader">
                          <input type="submit" class="btn btn-primary" value="<?=$verbage?> Payment">
                        </form>
                        <?php } ?>
                        <p><small>This is a twelve month package. After twelve months your premium will expire and you will lose access.</small></p>
                      </div>
                    </div>

                  </div>
                  <div class="col">

                    <div class="card mb-3">
                      <div class="card-header">
                        VIP</div>
                      <div class="card-body">
                        <p><b>Lifetime Premium</b></p> 
                        <p>Access to all AI generated features/functionality</p>
                        <p>Receive E-Mail Notifications based on your Preferences</p>
                        <p>Access to future updates and access for premium users</p>
                        <p>Private Beta access to future updates/changes</p> 
                        <p>Private Beta access to future Make Smart Apps Crypto based projects</p>
                        <?php if ($order["expired"] == true) { ?>
                        <h3><?=$programcost["vip"]?> Lisk (LSK)</h3>
                        <form method="post" action="">
                          <input type="hidden" name="type" value="vip">
                          <input type="submit" class="btn btn-primary" value="<?=$verbage?> Payment">
                        </form>
                        <?php } ?>
                        <p><small>This is a twelve month package. After twelve months your premium will expire and you will lose access.</small></p>
                      </div>
                    </div>

                  </div>
                </div>
                <p><small>Prices may slightly change once you press "Start Payment". Once a package is chosen you will be locked into that package and price for 12 hours. Additional instructions for making payment will be available once a package is chosen. There are no refunds, trials, and we reserve the right to refuse service, cancel your service, features, functionality, or access at any time. We do not offer refunds for downtime or outtages. We sell information not money, crypto, or a gaurantee. We do not take responsibility for any trades/transfers you make or any loss of funds. You are not allowed to resell our information or post anything from our site anywhere else. You agree to our <a target="_blank" href="<?=base_url()?>docs/terms">terms of service</a> and <a target="_blank" href="<?=base_url()?>docs/privacy">privacy policy</a>. For any additional questions or help you can contact support@insidercrypto.com.</small></p>

               <?php 
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
<?php 
if ($order["expired"] == false) { 
$cDD = date("M j, Y H:I:s",strtotime("+12 hours", $order["created"]));
  ?>
<script>
var countDownDate = new Date("<?=$cDD?>").getTime();
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  document.getElementById("timeleft").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timeleft").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
<?php } ?>

