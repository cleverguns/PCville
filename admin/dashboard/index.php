<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PC Village | Dashboard</title>
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
              <a href="/admin/dashboard/" class="nav-link bg-gradient-primary active">
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
              <a href="logs.php" class="nav-link">
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
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-lg-3 col-6">
              <div class="small-box bg-gradient-info">
                <div class="inner">
                  <h3><?= $products->totalProducts(); ?></h3>

                  <p>Total Products</p>
                </div>
                <div class="icon">
                  <i class="fas fa-box"></i>
                </div>
                <a href="products.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-gradient-warning">
                <div class="inner">
                  <h3 class="text-white"><?= $user->totalUsers(); ?></h3>

                  <p class="text-white">Total Users</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
                <a href="users.php" class="small-box-footer" style="color: #fff !important;">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-gradient-success">
                <div class="inner">
                  <h3><?= $category->totalCategory(); ?></h3>

                  <p>Total Category</p>
                </div>
                <div class="icon">
                  <i class="fas fa-list-alt"></i>
                </div>
                <a href="category.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
          <!-- /.row -->

          <!-- Main row -->
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Yearly Sales</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="yearlyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Monthly Sales</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="monthlyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Weekly Sales</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="weeklyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
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
  <!-- ChartJS -->
  <script src="../../wp-plugins/chart.js/Chart.min.js"></script>
  <script>
    <?php
    $yearlyData = $conn->query("SELECT YEAR(date_received) AS year, COUNT(*) AS total FROM tbl_shipping WHERE status = 'parcel-delivered' GROUP BY YEAR(date_received)");
    $weaklyData = $conn->query("SELECT WEEK(date_received) AS week, COUNT(*) AS total FROM tbl_shipping WHERE status = 'parcel-delivered' GROUP BY WEEK(date_received)");
    $monthlyData = $conn->query("SELECT DATE_FORMAT(date_received, '%M') as month, COUNT(*) as total FROM tbl_shipping WHERE status = 'parcel-delivered' GROUP BY DATE_FORMAT(date_received, '%M')");
    ?>
    //yearly data
    let yearlyData = {

      labels: [
        <?php
        foreach ($yearlyData as $row) {
          echo ($row['year'] . ",");
        }
        ?>
      ],
      datasets: [{
          label: 'Yearly Sales',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [
            <?php
            foreach ($yearlyData as $row) {
              echo ($row['total'] . ",");
            }
            ?>
          ]
        },

      ]
    }

    //weekly data
    let weeklyData = {
      labels: [
        <?php
        foreach ($weaklyData as $row) {
          echo ($row['week'] . ",");
        }
        ?>
      ],
      datasets: [{
        label: 'Weekly Sales',
        backgroundColor: 'rgba(60, 188, 91,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [
          <?php
          foreach ($weaklyData as $row) {
            echo ($row['total'] . ",");
          }
          ?>
        ]
      }, ]
    }

    //Monthly Data
    let monthlyData = {
      labels: [
        <?php
        foreach ($monthlyData as $row) {
          echo('"' . $row['month'] . '",');
        }
        ?>
      ],
      datasets: [{
        label: 'Monthly Sales',
        backgroundColor: 'rgba(60, 188, 91,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        pointRadius: false,
        pointColor: '#3b8bba',
        pointStrokeColor: 'rgba(60,141,188,1)',
        pointHighlightFill: '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data: [
          <?php
          foreach ($monthlyData as $row) {
            echo ($row['total'] . ",");
          }
          ?>
        ]
      }, ]
    }


    //-------------
    //- BAR CHART -
    //-------------

    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }

    //Yearly Chart
    let yearlyChartCanvas = $('#yearlyChart').get(0).getContext('2d')
    let yearlyChartData = $.extend(true, {}, yearlyData)
    let firstData = yearlyData.datasets[0]
    yearlyChartData.datasets[0] = firstData

    new Chart(yearlyChartCanvas, {
      type: 'bar',
      data: yearlyChartData,
      options: barChartOptions
    })

    //Weekly Chart
    var weeklyChartCanvas = $('#weeklyChart').get(0).getContext('2d')
    var weeklyChartData = $.extend(true, {}, weeklyData)
    var secondData = weeklyData.datasets[0]
    weeklyChartData.datasets[0] = secondData

    new Chart(weeklyChartCanvas, {
      type: 'bar',
      data: weeklyChartData,
      options: barChartOptions
    })

    //Monthly Chart
    var monthlyChartCanvas = $('#monthlyChart').get(0).getContext('2d')
    var monthlyChartData = $.extend(true, {}, monthlyData)
    var thirdData = monthlyData.datasets[0]
    monthlyChartData.datasets[0] = thirdData

    new Chart(monthlyChartCanvas, {
      type: 'bar',
      data: monthlyChartData,
      options: barChartOptions
    })
  </script>
</body>

</html>