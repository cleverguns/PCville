  <?php
  include_once("../../wp-includes/session.php");
  require_once("../../wp-includes/autoLoader.php");

  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

  if($_SESSION['role'] != "administrator"  && $_SESSION['role'] != "co-admin" ){
    header("Location: ../../");
  }
  ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../wp-plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../wp-plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../wp-plugins/dist/css/adminlte.min.css">
  <!-- Data Tables -->
  <link rel="stylesheet" href="../../wp-plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="../../wp-plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <!-- Sweet Alert 2-->
  <script src="../../wp-plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="../../wp-plugins/sweetalert2/sweetalert2.min.css" />