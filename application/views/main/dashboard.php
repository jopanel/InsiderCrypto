<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-8">  

          <?php if ($paidstatus == TRUE) { ?>
          <div class="card-columns">


           
            <div class="card mb-3">
              <div class="card-body">
                <div class="row">
                  
                  <div class="col-md-1">
                    <img src="https://files.coinmarketcap.com/static/img/coins/32x32/ripple.png">
                  </div>
                  <div class="col">
                    <h6 class="card-title mb-1"><a href="#">Ripple (XRP)</a></h6>
                    <p class="card-text small">
                      Binance => Poloniex <br>
                      <strong>Arbitrage</strong>
                    </p>
                  </div>
                  <div class="col">
                    <p><strong style="color:green">Buy:</strong> 0.001323232
                      <br>
                    <strong style="color:red">Sell:</strong> 0.001423232</p>
                  </div>
                  <div class="col">
                    <h2>4.32%</h2>
                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted">Added 46 mins ago</div>
            </div>







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
              <p><a class="btn btn-primary btn-lg" href="<?=base_url()?>payments/" role="button">Become Premium</a></p></center>
            </div>
          <?php } ?>
          
          <!-- /Card Columns-->
        </div>
        <div class="col-lg-4">
          <!-- Example Notifications Card-->
          <div class="card mb-3">
            <div class="chat-panel panel panel-default">
                        <div class="card-header">
              <i class="fa fa-comment"></i> Chat</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <ul class="chat" id="trollbox">
                                <?php


                                ?>
 

                            </ul>
                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." />
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat">
                                        Send
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- /.panel-footer -->
                    </div>
          </div>




      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Personal Gain Opportunities</div>
        <div class="card-body">
          <canvas id="personalGains" width="100%" height="30"></canvas>
        </div> 
      </div>


      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> All Gain Opportunities</div>
        <div class="card-body">
          <canvas id="allGains" width="100%" height="30"></canvas>
        </div> 
      </div>

      



         
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        allGains();
        personalGains();
        getChat();
        function getChat(){
          $.ajax({

              url : '<?=base_url()?>api/getChat',
              type : 'GET',
              dataType:'json',
              success : function(data) {     
                  if (data.error == 1) {
                    // do nothing
                  } else {
                    var updateChat = "";
                    var chatarrlength = data.chat.length;
                    for (i=0; i >= chatarrlength; i++) {
                      var pos = data.chat[i];
                      updateChat += '<li class="left clearfix"><div class="chat-body clearfix"><p class="small"><strong>'+pos.handle+'</strong> '+pos.message+'</p></div></li>';
                    }
                    document.getElementById("trollbox").innerHTML = updateChat;
                  }
                  setTimeout(getChat,500);
              },
              error : function(request,error)
              {
                  alert("Request: "+JSON.stringify(request));
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

<script src="<?=base_url()?>resources/main/vendor/chart.js/Chart.min.js"></script> 