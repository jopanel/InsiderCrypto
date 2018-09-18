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
  </body>

</html>
