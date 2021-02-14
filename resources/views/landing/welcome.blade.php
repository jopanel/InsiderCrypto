<header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-7 my-auto">
            <div class="header-content mx-auto">
              <h1 class="mb-5">Insider Crypto provides you with AI generated arbitrage opportunities, cryptocurrency pair opportunities, and the ability to customize to your preferences.</h1>
              <a href="<?=URL::to('/')?>/access/register" class="btn btn-outline btn-xl js-scroll-trigger">Get Started</a>
            </div>
          </div>
          <div class="col-lg-5 my-auto text-center rmv-mobile"> 
                    <img src="<?=URL::to('/')?>/resources/img/headerimgdb.png" class="img-fluid" alt="">  
          </div>
        </div>
      </div>
    </header> 

    <section class="goodforyou" id="goodforyou">
      <div class="row">
        <div class="col text-center">
          <h2>Customizable Arbitrage Opportunities By Exchange</h2>
          <h5>See how many artbitrage opportunities are available for you based on your exchanges!</h5>
        </div>
      </div>
      <div class="row">
        <div class="col text-center demobtn_col">  
          <button type="button" class="btn btn-primary btn-lg demobtn" data-toggle="modal" data-target="#checkExchanges">
            See Your Opportunities
          </button>
        </div>
      </div>
    </section>

    <div class="modal fade" id="checkExchanges" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Choose Your Exchanges</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="exchangesform">
              <table class="table table-bordered">
                <tr>
                <?php
                  $newline = 0;
                  foreach ($markets as $id => $name) {
                    $newline += 1;
                    echo "<td><label for='".$id."'>".$name."</label></td><td><input type='checkbox' name='exchanges[]' id='".$id."' value='".$id."'></td>";
                    if ($newline == 2) {
                      $newline = 0;
                      echo "</tr><tr>";
                    }
                  }
                ?>
                </tr>
              </table>
              <div class="row">
                  <div class="col text-center">
                    <button type="button" class="btn btn-primary btn-lg" onClick="checkOpp()">Check Opportunities</button>
                  </div>
                </div>
              </div>
            </form> 
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

    <section class="sitestats" id="sitestats">
      <div class="jumbotron"> 
        <div class="row">
          <div class="col col-lg-3 text-center">
            <h3>Current Opportunities</h3>
            <h2><?=$stats["total_matches"]?></h2>
          </div>
          <div class="col col-lg-3 text-center">
            <h3>Exchanges Analyzed</h3>
            <h2><?=$stats["num_exchanges"]?>
          </div>
          <div class="col col-lg-3 text-center">
            <h3>Currencies Analyzed</h3>
            <h2><?=$stats["num_markets_pairs"]?></h2>
          </div>
          <div class="col col-lg-3 text-center">
            <h3>Potential 30 Day Profit*</h3>
            <h2>$<?=$stats["avg_profit"]?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col text-center">
            <small>This information is updated once a day at midnight PST</small>
            <br />
            <small>*30 Day Profit based on making 1 trade per day starting with 1 BTC at our average profit % based on arbitrage and pair opportunities found on Insider Crypto including initial investment. Insider Crypto makes no gaurantees. There are great risks in trading and we do not gaurantee you will be profitable.</small>
          </div>
      </div> 
    </section>

    <section class="features" id="features">
      <div class="container">
        <div class="section-heading text-center">
          <h2>Cross-Exchange Analysis, Pair Calculations</h2>
          <p class="text-muted">Our system collects data from over 50 different exchanges/markets that offer cryptocurrency trading. Using artificial intelligence deep learning and mathematical calculations we provide you with opportunities to make profits almost instantly if you act upon them. This service is unique and for people who want to maximize their profits or build their overall cryptocurrency portfolio capital.</p> 
        </div>
          <div class="col-lg-12">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Pair Trading</h3>
                    <p class="text-muted">Finding pairs on the same exchange and multiple exchanges that allow you to make profit. Such as buying X coin with ETH and selling for BTC, re-buying ETH with BTC, repeat. We obtain symbols and pair opportunities from every exchange we offer and scan through all currency pairs.</p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Customizable Options</h3>
                    <p class="text-muted">We offer a variety of exchanges we monitor and obtain market data from. We allow you to customize what markets you wish to make profits on. You can set thresholds for gain % and set email notifications.</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Arbitrage Analysis</h3>
                    <p class="text-muted">Analyzing multiple exchanges customized by you we find currencies that you can buy low, transfer to another exchange, and sell for a profit based on % gains thresholds you set.</p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Smart AI Learning</h3>
                    <p class="text-muted">Each major pair, major arbitrage, and other major gains is tracked. The data is monitored and analyzed for patterns which helps it produce better results over time. The AI is constantly improving itself with its dataset and will allow us to continue building towards successful profit taking.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cta">
      <div class="cta-content">
        <div class="container">
          <div class="row">
            <div class="col">
              <h2>Stop waiting.<br>Start earning.</h2> 
            </div>
            <div class="col"> 
              <a href="<?=URL::to('/')?>/access/register" class="btn btn-outline btn-xl js-scroll-trigger padding-btn">Get Started!</a>
            </div>
          </div>
        </div>
      </div>
      <div class="overlay"></div>
    </section>