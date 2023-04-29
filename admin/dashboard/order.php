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
                                <a href="order.php" class="nav-link bg-gradient-primary active">
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
                                                    <th style="white-space: nowrap;">Shipping</th>
                                                    <th style="white-space: nowrap;">Date Ship</th>
                                                    <th style="white-space: nowrap;">Date Received</th>
                                                    <th style="white-space: nowrap;">Tools</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $transaction_query = $conn->query("SELECT p.img as image, s.date_received, s.delivery_id, t.transaction_id as transaction, CONCAT(b.fname, ' ', b.lname) as name, t.amount, t.type, s.status as shipping, t.description, s.date_shipping, t.user_id, b.billing_id FROM tbl_transactions t LEFT JOIN tbl_shipping s ON t.user_id = s.user_id AND t.transaction_id = s.token LEFT JOIN tbl_billings b ON s.billing_id = b.billing_id LEFT JOIN tbl_proof p ON s.delivery_id = p.delivery_id AND s.user_id = b.user_id WHERE t.status = 'Success' ORDER BY t._id DESC");
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

                                                    switch ($row['shipping']) {
                                                        case 'order-placed': {
                                                                $shipping = '<button data-status="'. $row['shipping'] .'" data-delivery="' . $row['delivery_id'] . '" class="btn-order border-0 py-2 badge badge-secondary">To Pay</button>';
                                                                break;
                                                            }

                                                        case 'parcel-ship': {
                                                                $shipping = '<button data-status="'. $row['shipping'] .'" data-delivery="' . $row['delivery_id'] . '" class="btn-order border-0 py-2 badge badge-info">To Ship</button';
                                                                break;
                                                            }

                                                        case 'parcel-transit': {
                                                                $shipping = '<button data-status="'. $row['shipping'] .'" data-delivery="' . $row['delivery_id'] . '" class="btn-order border-0 py-2 badge badge-warning">To Receive</button';
                                                                break;
                                                            }


                                                        case 'parcel-delivered': {
                                                                $shipping = '<button data-status="'. $row['shipping'] .'" data-delivery="' . $row['delivery_id'] . '" class="btn-order border-0 py-2 badge badge-success">Completed</button'; 
                                                                break;
                                                            }

                                                            case 'cancel-order': {
                                                                $shipping = '<button data-status="'. $row['shipping'] .'" data-delivery="' . $row['delivery_id'] . '" class="btn-order border-0 py-2 badge badge-danger">Canceled</button';
                                                                break;
                                                            }
                                                    }

                                                    $date_shipping = date_create($row['date_shipping']);
                                                    $date_shipping = date_format($date_shipping, 'Y • F • d • g:i A');

                                                    if(!empty($row['date_received'])){
                                                        $date_received = date_create($row['date_received']);
                                                        $date_received = date_format($date_received, 'Y • F • d • g:i A');
                                                    }else{
                                                        $date_received = "";
                                                    }
                                                    
                                                    if(!empty($date_received)){
                                                        $btn_recieved = $date_received . ' <button class="ml-2 btn btn-secondary btn-proof" data-img="../../wp-images/proof/'.$row['image'].'"> <i class="fas fa-eye"></i></button> ' ;
                                                    }else{
                                                        $btn_recieved = '';
                                                    }


                                                    echo ('
                                                    <tr>
                                                        <td style="white-space: nowrap;">' . ++$counter . '</td>
                                                        <td style="white-space: nowrap;">' . $row['transaction'] . '</td>
                                                        <td style="white-space: nowrap;">' . ucfirst($row['name']) . '</td>
                                                        <td style="white-space: nowrap;">' . $row['amount'] . '</td>
                                                        <td style="white-space: nowrap;">' . $type . '</td>
                                                        <td style="white-space: nowrap;">' . $shipping . '</td>
                                                        <td style="white-space: nowrap;">' . $date_shipping . '</td>
                                                        <td style="white-space: nowrap;">' . $btn_recieved.'</td>
                                                        <td style="white-space: nowrap;">
                                                            <button data-description="' . $row['description'] . '" class="btn btn-secondary mr-2 btn-view"><i class="fa fa-eye"></i> - View</button>
                                                            <button data-transaction="' . $row['delivery_id'] . '" data-id="' . $row['billing_id'] . '" class="btn btn-success mr-2 btn-billing"><i class="fa fa-eye"></i> - Billing</button>
                                                        </td>
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
            <div class="modal fade" id="order-status" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Change Delivery Status</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form class="frm-add" action="../wp-actions/order.php" method="post">
                            <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                            <input type="text" name="delivery" class="form-control delivery" required hidden />

                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="amount">Status</label>
                                    <select name="status" class="form-control status">
                                    <option value="cancel-order">Canceled</option>
                                        <option value="order-placed">To Pay</option>
                                        <option value="parcel-ship">To Ship</option>
                                        <option value="parcel-transit">To Received</option>
                                        <option value="parcel-delivered">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button name="change-status" class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="description" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Description</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="description">

                            </p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="view-billing" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Billing Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body-wrapper">
                            <div id="modal-receipt-body" class="modal-body">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td class="py-2 text-black">Parcel ID</td>
                                            <td class="parcel_id text-right"></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td class="py-2 text-black">Name</td>
                                            <td class="py-2 text-black name text-right"></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td class="py-2 text-black">Contact No.</td>
                                            <td class="py-2 text-black contact text-right"></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td class="py-2 text-black">Email Address</td>
                                            <td class="py-2 text-black email text-right"></td>
                                        </tr>
                                        <tr class="border-top">
                                            <td class="py-2 text-black">Address</td>
                                            <td class="py-2 text-black address text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary btn-print">Print</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="proof-delivery" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Proof of Delivery</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           <img class="proof_image img-fluid img-responsive" height="150px" alt="Proof of Delivery">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

    <!-- Main Footer -->
    <?php require_once("footer.php") ?>
        </div>
        <!-- ./wrapper -->
    </section>

    <?php require_once("scripts.php") ?>
    <script>
        $(".frm-add").validate({
            rules: {
                amount: {
                    required: true,
                    number: true,
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
        });

        $(".frm-edit").validate({
            rules: {
                amount: {
                    required: true,
                    number: true,
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
        });

        $(".btn-view").on("click", function() {
            let dxt = $(this).data("description");
            $(".description").html(dxt);
            $("#description").modal("show")
        })

        $(".btn-order").on("click", function() {
            let delivery = $(this).data("delivery");
            let status = $(this).data("status");

            $(".delivery").val(delivery);
            $(".status").val(status);
            $("#order-status").modal("show")
        })

        $(document).on('click', '.btn-billing', function() {
            let billing_id = $(this).data("id");
            let transaction = $(this).data("transaction");
            let token = "<?= $_SESSION['csrf_token'] ?>";
            $.ajax({
                url: "../wp-actions/getBillingInfo.php",
                method: "POST",
                data: {
                    BillingId: billing_id,
                    csrf_token: token
                },
                dataType: "json",
                success: function(data) {
                    if (data == "error") {
                        console.error("Something went wrong");
                    } else {
                        console.log(data);
                        $(".parcel_id").text(transaction);
                        $(".name").text(data.fname + " " + data.lname);
                        $(".contact").text(data.contact);
                        $(".email").text(data.email)
                        $(".address").text(data.address_1 + ", " + data.address_2 + ", " + data.province + ", " + data.postal_code);
                        $("#view-billing").modal('show');
                    }
                }


            })
        });

        $(document).on("click", ".btn-print", function() {
            const section = $("#content");
            const modalBody = $("#modal-receipt-body").detach();
            const content = $("#wrapper").detach();
            const table = $("#modal-receipt").detach();
            section.append(modalBody);
            window.print();
            section.empty();
            section.append(content);
            $(".modal-body-wrapper").append(modalBody);
        });

        $(document).on("click", '.btn-proof', function(){
            let image = $(this).data("img");
            $(".proof_image").attr('src', image);
            $("#proof-delivery").modal('show');
        });
    </script>
</body>

</html>