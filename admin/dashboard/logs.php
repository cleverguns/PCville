<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PC Village | Logs</title>

  <!-- Header Includes -->
  <?php require_once("headers.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php require_once("navbar.php"); ?>
    <!-- /.navbar -->


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-1">
      <!-- Brand Logo -->
      <?php require_once("logo.php"); ?>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-header">Administrator</li>
            <li class="nav-item">
              <a href="/" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="users.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="billings.php" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Billings
                </p>
              </a>
            </li>
            <li class="nav-header">Products</li>
            <li class="nav-item">
              <a href="products.php" class="nav-link">
                <i class="nav-icon fa fa-box"></i>
                <p>
                  Products
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="category.php" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Category
                </p>
              </a>
            </li>
            <li class="nav-header">Analytics</li>
            <li class="nav-item">
              <a href="order.php" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                  Orders
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="payment.php" class="nav-link">
                <i class="nav-icon fa fa-money-bill-alt"></i>
                <p>
                  Payments Record
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="logs.php" class="nav-link bg-gradient-primary active">
                <i class="nav-icon fas fa-history"></i>
                <p>
                  Logs
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Logs</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Logs</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body table-responsive">
                  <table id="table" class="table table-bordered table-striped text-center">
                    <thead>
                      <tr>
                        <th style="white-space: nowrap;">#</th>
                        <th style="white-space: nowrap;">Full Name</th>
                        <th style="white-space: nowrap;">Role</th>
                        <th style="white-space: nowrap;">Actions</th>
                        <th style="white-space: nowrap;">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $tbl_logs = $conn->query("SELECT u.fname, u.lname, u.user_role, l.action, DATE_FORMAT(l.date, '%b - %d - %Y : %h:%i %p') AS date FROM tbl_logs l LEFT JOIN tbl_users u ON l.user_id = u.user_id ORDER BY l._id DESC");
                      $counter = 0;
                      foreach ($tbl_logs as $row) {
                        echo ('
                          <tr>
                            <td style="white-space: nowrap;">' . ++$counter . '</td>
                            <td style="white-space: nowrap;">' . ucfirst($row['fname']) . ' ' . ucfirst($row['lname']) . '</td>
                            <td style="white-space: nowrap;">' . $row['user_role'] . '</td>
                            <td style="white-space: nowrap;">' . $row['action'] . '</td>
                            <td style="white-space: nowrap;">' . $row['date'] . '</td>
                          </tr>
                        ');
                      }
                      ?>


                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php require_once("footer.php") ?>
  </div>
  <!-- ./wrapper -->

  <?php require_once("scripts.php") ?>

  <script>
    $(function() {
      bsCustomFileInput.init();
    });

    $("#table").DataTable();
    $("#table-search").DataTable({
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
    });
  </script>
</body>

</html>