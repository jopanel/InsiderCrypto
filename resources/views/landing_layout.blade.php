<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Insider Crypto is a tool to find the best gains through arbitrage and coin pairs using AI.">
    <meta name="author" content="">

    <title>Insider Crypto - Arbitrage, Pairs, and AI</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=URL::to('/')?>/resources/landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="<?=URL::to('/')?>/resources/landing/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=URL::to('/')?>/resources/landing/vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link rel="stylesheet" href="<?=URL::to('/')?>/resources/landing/device-mockups/device-mockups.min.css">
    <link href="<?=URL::to('/')?>/resources/landing/css/insidercrypto.css" rel="stylesheet">
    <link href="<?=URL::to('/')?>/resources/landing/css/bootstrap-multiselect.css" rel="stylesheet">
  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="<?=URL::to('/')?>/resources/img/homelogo.png" class="img-fluid header-logo"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?=URL::to('/')?>/access/register">Get Started</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#features">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?=URL::to('/')?>/access/login">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>




  <?php return view($page, $data); ?>




  <footer>
      <div class="container">
        <p>&copy; <?=date("Y")?> Make Smart Apps LLC. DBA Insider Crypto</p>
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="<?=URL::to('/')?>/docs/privacy">Privacy</a>
          </li>
          <li class="list-inline-item">
            <a href="<?=URL::to('/')?>/docs/terms">Terms</a>
          </li>
          <li class="list-inline-item">
            <a href="<?=URL::to('/')?>/docs/FAQ">FAQ</a>
          </li>
        </ul>
      </div>
    </footer> 


    <script src="<?=URL::to('/')?>/resources/landing/vendor/jquery/jquery.min.js"></script>
    <script src="<?=URL::to('/')?>/resources/landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <script src="<?=URL::to('/')?>/resources/landing/vendor/jquery-easing/jquery.easing.min.js"></script> 
    <script src="<?=URL::to('/')?>/resources/landing/js/insidercrypto.js"></script>
    <script src="<?=URL::to('/')?>/resources/landing/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
          $(document).ready(function() {
              $('#exchangeselector').multiselect({
              buttonText: function(options, select) {
                if (options.length === 0) {
                    return 'Choose Your Exchanges';
                }
                else if (options.length > 3) {
                    return options.length+' exchanges selected';
                }
                 else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                 }
                }
              }); 
          });
    </script>
    <script>

      function checkOpp() {
        var formData = $("#exchangesform").serialize();
        $.ajax({
            url : '<?=URL::to('/')?>/api/getExchangesByRequest',
            data : formData,
            type : 'POST',
            dataType:'json',
            success : function(data) {  
              document.getElementById("exchangesform").innerHTML = "<div class='row'><div class='col text-center'><h2>Total Opportunities</h2><h3>"+data+"</h3></div></div><div class='row'><div class='col text-center'><p>These opportunities are current. They can change at any time. We highly recommend you try our program out. If you're a daily trader, weekly, or less our program has high value.</p></div></div>";
            },
            error : function(request,error)
            {
                //alert("Request: "+JSON.stringify(request));
            }
        });
      }

    </script>
  </body>

</html>
