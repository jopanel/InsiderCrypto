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
                    <p><strong style="color:green">Buy @</strong> <br><?=$v["pair1_price"]?>
                      <br>
                    <strong style="color:red">Sell @ </strong> <br><?=$v["pair2_price"]?>
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

    <script>
      
      function sendChat() {
          var message = document.getElementById("trollbox-message").value;
          var uid = <?=$userData["uid"]?>;
          if (message.length > 1 && message.replace(/\s/g, '').length) {
            $.ajax({
                url : '<?=URL::to('/')?>/api/sendChat',
                data : {
                    'uid' : uid,
                    'message' : message
                },
                type : 'POST',
                dataType:'json',
                success : function(data) {  
                  document.getElementById("trollbox-message").value = "";
                },
                error : function(request,error)
                {
                    //alert("Request: "+JSON.stringify(request));
                }
            });
          }
          
        }
      document.addEventListener('DOMContentLoaded', function() {
        allGains();
        personalGains();
        getChat();
        var lastpost = 0; 
        $("#trollbox-message").keyup(function(event) {
            if (event.keyCode === 13) {
                sendChat();
            }
        });
        function getChat(){
          $.ajax({
              url : '<?=URL::to('/')?>/api/getChat',
              type : 'GET',
              dataType:'json',
              success : function(data) {     
                  if (data.error == 0) { 
                    var updateChat = "";
                    var chatarrlength = data.chat.length;
                    var latestpost = lastpost;
                    var lastposter = 0;
                    var mypost = <?=$userData["uid"]?>;
                    var counter = 0;
                    for (i=0; i < chatarrlength; i++) {
                      var pos = data.chat[i]; 
                      counter += 1;
                      if (counter == 1) {
                        var addindex = 'tabindex="1"';
                        lastpost = pos.id;
                        lastposter = pos.uid;
                      } else {
                        var addindex = '';
                      }
                      updateChat = '<li '+addindex+' class="left clearfix"><div class="chat-body clearfix"><p class="small"><strong>'+pos.handle+'</strong> '+pos.message+'</p></div></li>'+updateChat; 
                      
                    }
                    document.getElementById("trollbox").innerHTML = updateChat;
                    if (lastpost > latestpost) {
                       $('li').last().addClass('active-li').focus();
                       if (lastposter == mypost) {
                        $("#trollbox-message").focus();
                       }
                    }
                  }
                  setTimeout(getChat,1000);
              },
              error : function(request,error)
              {
                  //alert("Request: "+JSON.stringify(request));
              }
          });
          
        }
        function allGains() {
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = '#292b2c';
          // -- Area Chart Example
          var ctx = document.getElementById("allGains");
          var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
              datasets: [{
                label: "Sessions",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 20,
                pointBorderWidth: 2,
                data: [3, 12, 61, 3, 23, 7, 6, 13, 16, 23, 21, 5, 22],
              }],
            },
            options: {
              scales: {
                xAxes: [{
                  time: {
                    unit: 'date'
                  },
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    maxTicksLimit: 7
                  }
                }],
                yAxes: [{
                  ticks: {
                    min: 0,
                    max: 70,
                    maxTicksLimit: 5
                  },
                  gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                  }
                }],
              },
              legend: {
                display: false
              }
            }
          });
        } 
        function personalGains() {
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = '#292b2c';
          // -- Area Chart Example
          var ctx = document.getElementById("personalGains");
          var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["Mar 1", "Mar 2", "Mar 3", "Mar 4", "Mar 5", "Mar 6", "Mar 7", "Mar 8", "Mar 9", "Mar 10", "Mar 11", "Mar 12", "Mar 13"],
              datasets: [{
                label: "Sessions",
                lineTension: 0.3,
                backgroundColor: "rgba(2,117,216,0.2)",
                borderColor: "rgba(2,117,216,1)",
                pointRadius: 5,
                pointBackgroundColor: "rgba(2,117,216,1)",
                pointBorderColor: "rgba(255,255,255,0.8)",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(2,117,216,1)",
                pointHitRadius: 20,
                pointBorderWidth: 2,
                data: [3, 12, 61, 3, 23, 7, 6, 13, 16, 23, 21, 5, 22],
              }],
            },
            options: {
              scales: {
                xAxes: [{
                  time: {
                    unit: 'date'
                  },
                  gridLines: {
                    display: false
                  },
                  ticks: {
                    maxTicksLimit: 7
                  }
                }],
                yAxes: [{
                  ticks: {
                    min: 0,
                    max: 70,
                    maxTicksLimit: 5
                  },
                  gridLines: {
                    color: "rgba(0, 0, 0, .125)",
                  }
                }],
              },
              legend: {
                display: false
              }
            }
          });
        }
      }, false);
    </script>

<script src="<?=URL::to('/')?>/resources/main/vendor/chart.js/Chart.min.js"></script> 