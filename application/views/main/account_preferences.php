<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col">

          <div class="card mb-3">
            <div class="card-header">
              Update Your Preferences</div>
            <div class="card-body"> 
              <div class="row">
                <div class="col">
                  
                  <div class="card mb-3">
                    <div class="card-header">
                      Your Exchanges</div>
                    <div class="card-body"> 
                      <form method="post" action="">
                        <input type="hidden" name="action" value="set_exchanges">
                      <table class="table">
                        <tr>
                        <?php
                          $counter = 0;
                          foreach ($exchanges as $v) {
                            $counter += 1;
                            if ($counter == 3) {
                              $counter = 1;
                              echo "</tr><tr>";
                            }
                            echo "<td><label>".$v["name"]." <input type='checkbox' name='exchanges[]' value='".$v["market_id"]."'";
                            if ($v["selected"] == TRUE) {
                              echo " checked";
                            }
                            echo "></label></td>";
                          }

                        ?></tr>
                      </table>
                      <input type="submit" class="btn btn-primary" value="Update Exchanges">
                      </form>
                    </div> 
                  </div>


                </div>
                <div class="col">
                  
                  <div class="card mb-3">
                    <div class="card-header">
                      Set Threshold</div>
                    <div class="card-body"> 
                      <p>Setting the threshold % will show you opportunities to make money if the gains % is greater or equal to your threshold value. We recommend you keep your threshold under 10. The lowest you may set is 3% as we only list gains of 3% or above.</p>
                      <center>
                        <p><b>Set Threshold %</b></p>
                        <form method="post" action="">
                          <input type="hidden" name="action" value="set_threshold">
                          <p>
                          <input type="number" name="threshold" value="<?=$userdata["threshold"]?>"></p>
                          <p><input type="submit" class="btn btn-primary" value="Set Threshold"></p>
                        </form>
                      </center>
                    </div> 
                  </div>

                  <div class="card mb-3">
                    <div class="card-header">
                      Receive E-Mail Notifications</div>
                    <div class="card-body"> 
                      <p>Get email notifications for gain opportunities past your threshold as soon as we find them.</p>
                      <center>
                        <form method="post" action="">
                          <input type="hidden" name="action" value="set_notifications">
                          <p>
                          <input type="checkbox" name="notifications" value="1" <?php 
                          if ($userdata["notifications"] == 1) { echo "checked";}
                          ?>></p>
                          <p><input type="submit" class="btn btn-primary" value="Set Notifications"></p>
                        </form>
                      </center>
                    </div> 
                  </div>


                </div>
              </div>
            </div> 
          </div>

          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-area-chart"></i> Personal Gain Opportunities (based on your preferences)</div>
            <div class="card-body">
              <canvas id="personalGains" width="100%" height="30"></canvas>
            </div> 
          </div>


        </div> 
      </div>
    </div>
  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        personalGains();
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