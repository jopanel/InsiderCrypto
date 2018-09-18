<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <footer>
      <div class="container">
        <p>&copy; 2018 Lenapo Solutions LLC. DBA Insider Crypto</p>
        <ul class="list-inline">
          <li class="list-inline-item">
            <a href="<?=base_url()?>docs/privacy">Privacy</a>
          </li>
          <li class="list-inline-item">
            <a href="<?=base_url()?>docs/terms">Terms</a>
          </li>
          <li class="list-inline-item">
            <a href="<?=base_url()?>docs/FAQ">FAQ</a>
          </li>
        </ul>
      </div>
    </footer> 


    <script src="<?=base_url()?>resources/landing/vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>resources/landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
    <script src="<?=base_url()?>resources/landing/vendor/jquery-easing/jquery.easing.min.js"></script> 
    <script src="<?=base_url()?>resources/landing/js/insidercrypto.js"></script>
    <script src="<?=base_url()?>resources/landing/js/bootstrap-multiselect.js"></script>
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
            url : '<?=base_url()?>api/getExchangesByRequest',
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
