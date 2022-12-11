<footer class="main-footer">
  <div class="footer-center">
    <center>
      Copyright &copy; 2022 SMK NEGERI PARITTIGA 2022
    </center>
  </div>
</footer>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/af-2.4.0/b-2.2.3/r-2.3.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/r-2.3.0/rr-1.2.8/sc-2.0.7/sb-1.3.4/datatables.min.js"></script>


<script src="<?= base_url() ?>/assets/js/jquery.mask.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="<?= base_url(); ?>/assets/js/stisla.js"></script>

<!-- Template JS File -->
<script src="<?= base_url(); ?>assets/js/scripts.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<script src="<?= base_url(); ?>assets/js/sweetalert2.all.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url(); ?>assets/js/page/index.js"></script>
<script src="<?= base_url(); ?>assets/js/myjs.js"></script>

<script>
  $('#logoutbtn').on('click', function() {
    $('#logout_modal').modal('show');
  })
  $('#ganti_password_btn').on('click', function() {
    $('#ganti_password_modal').modal('show');
  })
</script>
</body>

</html>