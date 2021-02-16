<footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>© <?=date('Y')?> Make Smart Apps LLC. DBA Insider Crypto</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Are you sure you want to logout? You are only allowed the maximum of two IP addresses to be logged in within a 24 hour period.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?=URL::to('/')?>/logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?=URL::to('/')?>/resources/main/vendor/jquery/jquery.min.js"></script>
    <script src="<?=URL::to('/')?>/resources/main/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?=URL::to('/')?>/resources/main/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    
    
    <script src="<?=URL::to('/')?>/resources/main/js/sb-admin.min.js"></script>
  </div>
</body>

</html>
