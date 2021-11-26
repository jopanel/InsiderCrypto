<?php

function get_friendly_time_ago($distant_timestamp, $max_units = 3) {
    $i = 0;
    $time = time() - $distant_timestamp; // to get the time since that moment
    $tokens = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];

    $responses = [];
    while ($i < $max_units && $time > 0) {
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $i++;
            $numberOfUnits = floor($time / $unit);

            $responses[] = $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
            $time -= ($unit * $numberOfUnits);
            break;
        }
    }

    if (!empty($responses)) {
        return implode(', ', $responses) . ' ago';
    }

    return 'Just now';
}
?>



  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">  
          <?php if ($paidstatus == TRUE) { ?>
          <div class="card-columns">
          <?php  
          foreach ($matchData as $v) {
            if ($v["pair1_price"] < 1) {
              $price1 = ($v["pair1_price"] + 1);
              $price1 = str_replace("1.", "0.", $price1);
            } else {
              $price1 = $v["pair1_price"];
            }
            if ($v["pair2_price"] < 1) {
              $price2 = ($v["pair2_price"] + 1);
              $price2 = str_replace("1.", "0.", $price2);
            } else {
              $price2 = $v["pair2_price"];
            }
            //$price1 = $v["pair1_price"];
            //$price2 = $v["pair2_price"];
          ?> 
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-1"> 
                    #<?=$v["identifier"]?>
                  </div>
                  <div class="col">
                    <h6 class="card-title mb-1"><a href="#"><?=$v["currency1"]?></a></h6>
                    <p class="card-text small">
                      <?=$v["market2"]?> <br><small><?=$v["currency2"]?>-<?=$v["symbol2"]?></small><br>=><br> <?=$v["market1"]?> <br><small><?=$v["currency1"]?>-<?=$v["symbol1"]?></small> 
                    </p>
                  </div>
                  <div class="col">
                    <p>
                      <strong style="color:green">Buy @</strong> <br><?=$price1?>
                      <br>
                      <strong style="color:red">Sell @ </strong> <br><?=$price2?>
                    </p>
                  </div>
                  <div class="col">
                    <h2><?=$v["percent"]?>%</h2>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Updated <?=get_friendly_time_ago($v["updated"])?></div>
            </div>
           <?php }

           ?>
            
          </div>
          <?php } else { ?>
            <div class="jumbotron">
              <h1>Welcome, <?=$userData["username"]?> let's get started!</h1>
              <p>Currently we are offering program access as low as <?=$programcost["beginner"]?> Lisk (LSK). This is a one time payment which allows you access to get our unique algorithim for abitrage deals, currency pair deals, chatbox, and future updates.</p>
              <p>While we recognize there are other trading tools available that may seem to offer relatively the same solution we have a unique method to generate the data to you. We monitor and follow every possible opportunity we can find. With that data we use AI deep learning to provide you with the best information possible. </p>
              <p>Arbitrage, trade pairing, trading in general; takes time, money and its possible for trades to close a gap before you receive your money. Based on trends, currency networks, and our community we make sure that all of our users turn a profit.</p>
              <p>Trading, buying, and selling is all done on your own risk. We provide you with the data and it is up to you to act on it.</p>
              <p>Make some money and become a member today.</p> 
              <center>
              <p><a class="btn btn-primary btn-lg" href="<?=URL::to('/')?>/payments/" role="button">Become Premium</a></p></center>
            </div>
          <?php } ?>
           
      </div>
    </div> 


<script src="<?=URL::to('/')?>/resources/main/vendor/chart.js/Chart.min.js"></script> 