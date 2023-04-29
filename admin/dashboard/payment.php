<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PC Village | Order</title>
    <!-- Header Includes -->
    <?php require_once("headers.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <section id="content">
        <div id="wrapper" class="wrapper">

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
                                <a href="payment.php" class="nav-link bg-gradient-primary active">
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
                                <h1 class="m-0">Orders</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Orders</li>
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
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Orders
                                        </h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="table" class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th style="white-space: nowrap;">#</th>
                                                    <th style="white-space: nowrap;">Transaction ID</th>
                                                    <th style="white-space: nowrap;">Name</th>
                                                    <th style="white-space: nowrap;">Amount</th>
                                                    <th style="white-space: nowrap;">Type</th>
                                                    <th style="white-space: nowrap;">Status</th>
                                                    <th style="white-space: nowrap;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $transaction_query = $conn->query("SELECT s.delivery_id, t.transaction_id as transaction, CONCAT(b.fname, ' ', b.lname) as name, t.amount, t.type, t.status as status, t.description, s.date_shipping, t.user_id, b.billing_id FROM tbl_transactions t LEFT JOIN tbl_shipping s ON t.user_id = s.user_id AND t.transaction_id = s.token LEFT JOIN tbl_billings b ON s.billing_id = b.billing_id AND s.user_id = b.user_id ORDER BY t._id DESC");
                                                $counter = 0;
                                                foreach ($transaction_query as $row) {
                                                    switch ($row['type']) {
                                                        case 'cash-on-delivery': {
                                                                $type = '<span class="badge badge-warning">Cash On Deliver</span';
                                                                break;
                                                            }

                                                        case 'gcash': {
                                                                $type = '<span class="badge badge-success">Gcash</span';
                                                                break;
                                                            }

                                                        case 'grab_pay': {
                                                                $type = '<span class="badge badge-success">Grab Pay</span';
                                                                break;
                                                            }
                                                    }

                                                    switch ($row['status']) {
                                                        case 'Pending': {
                                                                $status = '<span class="badge badge-info">Pending</span>';
                                                                break;
                                                            }

                                                        case 'Success': {
                                                                $status = '<span class="badge badge-success">Success</span>';
                                                                break;
                                                            }

                                                        case 'Failed': {
                                                                $status = '<span class="badge badge-danger">Failed</span>';
                                                                break;
                                                            }
                                                    }

                                                    $date_shipping = date_create($row['date_shipping']);
                                                    $date_shipping = date_format($date_shipping, 'Y • F • d • g:i A');

                                                    echo ('
                                                    <tr>
                                                        <td style="white-space: nowrap;">' . ++$counter . '</td>
                                                        <td style="white-space: nowrap;">' . $row['transaction'] . '</td>
                                                        <td style="white-space: nowrap;">' . ucfirst($row['name']) . '</td>
                                                        <td style="white-space: nowrap;">' . number_format($row['amount']) . '</td>
                                                        <td style="white-space: nowrap;">' . $type . '</td>
                                                        <td style="white-space: nowrap;">' . $status . '</td>
                                                        <td style="white-space: nowrap;">' . $date_shipping . '</td>
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
    </section>

    <?php require_once("scripts.php") ?>
    <script>

    </script>
</body>

</html>