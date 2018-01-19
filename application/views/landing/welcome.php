<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-lg-7 my-auto">
            <div class="header-content mx-auto">
              <h1 class="mb-5">Insider Crypto provides you with AI generated arbitrage opportunities, cryptocurrency pair opportunities, and the ability to customize to your preferences.</h1>
              <a href="#signup" class="btn btn-outline btn-xl js-scroll-trigger">Get Started</a>
            </div>
          </div>
          <div class="col-lg-5 my-auto">
            <div class="device-container">
              <div class="device-mockup iphone6_plus portrait white">
                <div class="device">
                  <div class="screen">
                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                    <img src="img/demo-screen-1.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="button">
                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section class="download bg-primary text-center" id="signup">
      <div class="container">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <h2 class="section-heading">Make smarter trades, profit faster, gain everyday.</h2>
            <p>We offer this tool at a low cost of <?=$programcost?> Lisk ($300 USD).</p>
            <p> You must first <a style="text-decoration: none !important;
color: blue !important;" href="<?=base_url()?>access/register">register</a> with us.</p>
            <div class="badges">
              <a class="badge-link" href="#"><img src="img/google-play-badge.svg" alt=""></a>
              <a class="badge-link" href="#"><img src="img/app-store-badge.svg" alt=""></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="features" id="features">
      <div class="container">
        <div class="section-heading text-center">
          <h2>Cross-Exchange Analysis, Pair Calculations</h2>
          <p class="text-muted">Our AI finds not only cross-exchange differences, it also finds profits that can be made buying/selling cross-exchange with multiple currency pairs. Such as buying X coin on one exchange, selling at another exchange for ETH, and so on.</p>
          <hr>
        </div>
        <div class="row">
          <div class="col-lg-4 my-auto">
            <div class="device-container">
              <div class="device-mockup iphone6_plus portrait white">
                <div class="device">
                  <div class="screen">
                    <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                    <img src="img/demo-screen-1.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="button">
                    <!-- You can hook the "home button" to some JavaScript events or just remove it -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 my-auto">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Pair Trading</h3>
                    <p class="text-muted">Finding pairs on the same exchange and multiple exchanges that allow you to make profit. Such as buying X coin with ETH and selling for BTC, re-buying ETH with BTC, repeat.</p>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="feature-item"> 
                    <h3>Customizable Options</h3>
                    <p class="text-muted">We offer a variety of exchanges we monitor and obtain market data from. We allow you to customize what markets you wish to make gains on. You can set thresholds for gain % and set email notifications.</p>
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
                    <p class="text-muted">Each major pair, major arbitrage, and other major gains is tracked. The data is monitored and analyzed for patterns which helps it produce better results over time.</p>
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
          <h2>Stop waiting.<br>Start earning.</h2>
          <a href="#signup" class="btn btn-outline btn-xl js-scroll-trigger">Get Started!</a>
        </div>
      </div>
      <div class="overlay"></div>
    </section>

