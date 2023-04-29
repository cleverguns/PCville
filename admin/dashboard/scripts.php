  <!-- REQUIRED SCRIPTS -->
  <?php
  require_once("../../wp-includes/response.php");
  ?>
  <!-- jQuery -->
  <script src="../../wp-plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../wp-plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../wp-plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../wp-plugins/dist/js/adminlte.js"></script>
  <!-- Data Tables Plugins -->
  <script src="../../wp-plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../wp-plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../wp-plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../wp-plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../wp-plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- Validation Plugins -->
  <script src="../../wp-plugins/jquery-validation/jquery.validate.js"></script>
  <script>
      $(function() {
          bsCustomFileInput.init();
      });

      $("#table").DataTable();
      $("#table2").DataTable();
      $("#table-search").DataTable({
          paging: true,
          lengthChange: false,
          searching: false,
          ordering: true,
          info: true,
          autoWidth: false,
      });
  </script>