<?php
require_once("wp-includes/autoLoader.php");
require_once("wp-includes/session.php");
require_once("wp-includes/utils.php");

if (isset($_GET['_token']) && isset($_GET['_key']) && $_SESSION['csrf_token'] && isset($_GET['_bid'])) {

    $transaction_id = $_GET['_key'];
    $billing_id = $_GET['_bid'];
    $_userid = $_SESSION['user_token'];

    // Deduct products that were bought and delete them from the cart
    if (isset($_SESSION['product'])) {
        $products_processed = false; // Set a flag variable to false

        foreach ($_SESSION['product'] as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];

            $product_query = $conn->query("UPDATE tbl_products SET stock = stock - '{$quantity}' WHERE product_id = '{$product_id}' LIMIT 1");
            $deleteCart = $conn->query("DELETE FROM tbl_carts WHERE user_id = '{$_userid}' AND product_id = '{$product_id}'"); // Delete Carts
        }

        $products_processed = true; // Set the flag variable to true after the loop completes

        if ($products_processed) {
            unset($_SESSION['product']); // Unset the session if the products have been processed
        }
    }





    if ($_GET['_token'] === $_SESSION['csrf_token']) {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d H:i:s');
        $delivery = "#" . generate_text("14");

        $validate_deliver = $conn->query("SELECT s.status, s.date_shipping, s.delivery_id, t.transaction_id as transaction, t.amount as amount, t.type as type, t.description FROM tbl_shipping s LEFT JOIN tbl_transactions t ON s.token = t.transaction_id WHERE s.user_id = '{$_userid}' AND s.token = '{$transaction_id}' LIMIT 1");

        if ($validate_deliver->num_rows > 0) {
            $validate = $conn->query("SELECT * FROM tbl_transactions WHERE user_id = '{$_userid}' AND transaction_id = '{$transaction_id}'LIMIT 1");
            if ($validate->num_rows > 0) {
                $fetch_transaction = $validate->fetch_assoc();
                if ($fetch_transaction['status'] == "Pending") {
                    if ($transaction->update_transaction($_userid, $transaction_id, "Success") == "success") {
                        if ($deleteCart) {
                            $shipping_query = $conn->query("SELECT s.status, s.date_shipping, s.delivery_id, t.transaction_id as transaction, t.amount as amount, t.type as type, t.description FROM tbl_shipping s LEFT JOIN tbl_transactions t ON s.token = t.transaction_id WHERE s.user_id = '{$_userid}' AND s.token = '{$transaction_id}' LIMIT 1");
                            $fetch_shipping = $shipping_query->fetch_assoc();
                        }
                    }
                } else {
                    // $deleteCart = $conn->query("DELETE FROM tbl_carts WHERE user_id = '{$_userid}'"); //Delete Carts
                    $shipping_query = $conn->query("SELECT s.status, s.date_shipping, s.delivery_id, t.transaction_id as transaction, t.amount as amount, t.type as type, t.description FROM tbl_shipping s LEFT JOIN tbl_transactions t ON s.token = t.transaction_id WHERE s.user_id = '{$_userid}' AND s.token = '{$transaction_id}' LIMIT 1");
                    $fetch_shipping = $shipping_query->fetch_assoc();
                }
            } else {
                header("Location: /");
            }
        } else {
            $insert_shipping = $conn->query("INSERT INTO tbl_shipping(token, delivery_id, user_id, billing_id, status, date_shipping) VALUES('{$transaction_id}', '{$delivery}', '{$_userid}', '{$billing_id}', 'order-placed', '{$date}')");
            if ($insert_shipping) {
                $validate = $conn->query("SELECT * FROM tbl_transactions WHERE user_id = '{$_userid}' AND transaction_id = '{$transaction_id}' LIMIT 1");
                if ($validate->num_rows > 0) {
                    $transaction->update_transaction($_userid, $transaction_id, "Success");

                    // $deleteCart = $conn->query("DELETE FROM tbl_carts WHERE user_id = '{$_userid}'"); //Delete Carts
                    $shipping_query = $conn->query("SELECT s.status, s.date_shipping, s.delivery_id, t.transaction_id as transaction, t.amount as amount, t.type as type, t.description FROM tbl_shipping s LEFT JOIN tbl_transactions t ON s.token = t.transaction_id WHERE s.user_id = '{$_userid}' AND s.token = '{$transaction_id}' LIMIT 1");
                    $fetch_shipping = $shipping_query->fetch_assoc();
                } else {
                    header("Location: /");
                }
            }
        }
    } else {
        header("Location: /");
    }
} else {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PC-Village | Payment</title>
    <?php
    include_once("headers.php");
    ?>
    <link rel="stylesheet" href="wp-plugins//bs-stepper/css/bs-stepper.min.css">
</head>

<body>

    <!-- Navbar Start -->
    <?php require_once("navbar.php") ?>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Payment</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Payment</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-3 col-md-4">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Order Details</h1>
                    </div>
                    <div class="card-body">

                        <?php
                        $items = explode("</br>", $fetch_shipping['description']);

                        foreach ($items as $item) {
                            $split_item = explode("|", $item);

                            if (isset($split_item[1]) && $split_item[0]) {
                                $formatted_item = "<p class='m-0'>" . trim($split_item[0]) . "</p>";
                                $formatted_item .= "<p class='m-0'>" . trim($split_item[1]) . "</p>";
                                echo ('<div class="border-bottom py-2 d-flex justify-content-between align-items-center">' . $formatted_item . '</div>');
                            }
                        }

                        ?>

                    </div>
                </div>

                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Transaction Record</h1>
                    </div>
                    <div class="card-body">
                        <?php
                        switch ($fetch_shipping['type']) {
                            case 'cash-on-delivery': {
                                    $payment_sts = "";
                                    $payment_type = "Cash On Delivery";
                                    break;
                                }
                            case 'gcash': {
                                    $payment_sts = '
                                <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                                <p class="m-0">Status </p>
                                <p class="m-0">Paid</p>
                                </div>
                                ';
                                    $payment_type = "Gcash";
                                    break;
                                }
                            case 'grab_pay': {
                                    $payment_sts = '
                                <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                                <p class="m-0">Status </p>
                                <p class="m-0">Paid</p>
                                </div>
                                ';
                                    $payment_type = "Grab Pay";
                                }
                        }
                        ?>
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Transaction ID </p>
                            <p class="m-0"><?= $fetch_shipping['transaction'] ?></p>
                        </div>
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Type of Payment </p>
                            <p class="m-0"><?= $payment_type ?></p>
                        </div>
                        <?= $payment_sts ?>
                        <div class="py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Total Amount </p>
                            <p class="m-0">₱ <?= number_format($fetch_shipping['amount']); ?></p>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Shipping Status</h1>
                    </div>
                    <div class="card-body">
                        <div id="stepper4" class="bs-stepper vertical linear" data-linear="true">
                            <?php

                            switch ($fetch_shipping['status']) {
                                case 'order-placed': {
                                        echo ('
                                    <div class="bs-stepper-header" role="tablist">
                                    <div class="step active" data-target="#preparing">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="preparing" aria-selected="true">
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-file-invoice"></i></span>
                                            <span class="bs-stepper-label text-primary">Order Placed</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-2">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="true">
                                            <span class="bs-stepper-circle"><i class="fa fa-box-open"></i></span>
                                            <span class="bs-stepper-label">Preparing</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-3">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-3" aria-selected="true">
                                            <span class="bs-stepper-circle"><i class="fa fa-truck"></i></span>
                                            <span class="bs-stepper-label">In Transit</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-4">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-4" aria-selected="true">
                                            <span class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                                            <span class="bs-stepper-label">Delivered</span>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                            <div id="preparing" role="tabpanel" class="content dstepper-block fade active mt-4" style="height: 120px;" aria-labelledby="stepper4trigger1">
                                                <p>Order is placed waiting to ship.</p>
                                            </div>
                                    </div>
                                    ');
                                        break;
                                    }

                                case 'parcel-ship': {
                                        echo ('
                                    <div class="bs-stepper-header" role="tablist">
                                    <div class="step active" data-target="#preparing">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="preparing" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-file-invoice"></i></span>
                                            <span class="bs-stepper-label text-primary">Order Placed</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-2">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="true">
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-box-open"></i></span>
                                            <span class="bs-stepper-label text-primary">Preparing</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-3">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-3" aria-selected="true">
                                            <span class="bs-stepper-circle"><i class="fa fa-truck"></i></span>
                                            <span class="bs-stepper-label">In Transit</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-4">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-4" aria-selected="true" >
                                            <span class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                                            <span class="bs-stepper-label">Delivered</span>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                            <div id="preparing" role="tabpanel" class="content dstepper-block fade active mt-4" style="height: 120px;" aria-labelledby="stepper4trigger1">
                                                <p>Order is placed waiting to ship.</p>
                                            </div>
                                            <div id="test-vl-2" role="tabpanel" class="content dstepper-block fade active" style="height: 100px;" aria-labelledby="stepper4trigger2">
                                            <p>Sender is preparing to ship your parcel.</p>
                                            </div>
                                    </div>
                                    ');
                                        break;
                                    }
                                case 'parcel-transit': {
                                        echo ('
                                    <div class="bs-stepper-header" role="tablist">
                                    <div class="step active" data-target="#preparing">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="preparing" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-file-invoice"></i></span>
                                            <span class="bs-stepper-label text-primary">Order Placed</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-2">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-box-open"></i></span>
                                            <span class="bs-stepper-label text-primary">Preparing</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-3">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-3" aria-selected="true">
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-truck"></i></span>
                                            <span class="bs-stepper-label text-primary">In Transit</span>
                                        </a>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-vl-4">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-4" aria-selected="true">
                                            <span class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                                            <span class="bs-stepper-label">Delivered</span>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <div id="preparing" role="tabpanel" class="content dstepper-block fade active mt-4" style="height: 120px;" aria-labelledby="stepper4trigger1">
                                            <p>Order is placed waiting to ship.</p>
                                        </div>
                                        <div id="test-vl-2" role="tabpanel" class="content dstepper-block fade active" style="height: 100px;" aria-labelledby="stepper4trigger2">
                                            <p>Sender is preparing to ship your parcel.</p>
                                        </div>
                                        <div id="test-vl-3" role="tabpanel" class="content dstepper-block fade active" style="height: 100px;"  aria-labelledby="stepper4trigger3">
                                            <p class="my-2">Your parcel has been picked up by our logistics partner.</p>
                                        </div>
                                    </div>
                                    ');
                                        break;
                                    }
                                case 'parcel-delivered': {
                                        echo ('
                                    <div class="bs-stepper-header" role="tablist">
                                    <div class="step active" data-target="#preparing">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="preparing" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-file-invoice"></i></span>
                                            <span class="bs-stepper-label text-primary">Order Placed</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-2">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-box-open"></i></span>
                                            <span class="bs-stepper-label text-primary">Preparing</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-3">
                                        <button type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-3" aria-selected="false" disabled>
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-truck"></i></span>
                                            <span class="bs-stepper-label text-primary">In Transit</span>
                                        </button>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step active" data-target="#test-vl-4">
                                        <a type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-4" aria-selected="true">
                                            <span class="bs-stepper-circle bg-primary"><i class="fa fa-check"></i></span>
                                            <span class="bs-stepper-label text-primary">Delivered</span>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <div id="preparing" role="tabpanel" class="content dstepper-block fade active mt-4" style="height: 120px;" aria-labelledby="stepper4trigger1">
                                            <p>Order is placed waiting to ship.</p>
                                        </div>
                                        <div id="test-vl-2" role="tabpanel" class="content dstepper-block fade active" style="height: 100px;" aria-labelledby="stepper4trigger2">
                                            <p>Sender is preparing to ship your parcel.</p>
                                        </div>
                                        <div id="test-vl-3" role="tabpanel" class="content dstepper-block fade active" style="height: 100px;"  aria-labelledby="stepper4trigger3">
                                            <p class="my-2">Your parcel has been picked up by our logistics partner.</p>
                                        </div>
                                        <div id="test-vl-4" role="tabpanel" class="content dstepper-block fade active" style="height: 18px;" aria-labelledby="stepper4trigger4">
                                            <p class="my-2">Parcel has been delivered.</p>
                                        </div>
                                    </div>
                                    ');
                                        break;
                                    }
                                case 'cancel-order': {

                                        echo ('
                                        <div class="bs-stepper-header" role="tablist">
                                        <div class="step" data-target="#preparing">
                                            <a type="button" class="step-trigger" role="tab" id="stepper4trigger1" aria-controls="preparing" aria-selected="true">
                                                <span class="bs-stepper-circle"><i class="fa fa-file-invoice"></i></span>
                                                <span class="bs-stepper-label">Order Placed</span>
                                            </a>
                                        </div>
                                        <div class="bs-stepper-line"></div>
                                        <div class="step" data-target="#test-vl-2">
                                            <a type="button" class="step-trigger" role="tab" id="stepper4trigger2" aria-controls="test-vl-2" aria-selected="true">
                                                <span class="bs-stepper-circle"><i class="fa fa-box-open"></i></span>
                                                <span class="bs-stepper-label">Preparing</span>
                                            </a>
                                        </div>
                                        <div class="bs-stepper-line"></div>
                                        <div class="step" data-target="#test-vl-3">
                                            <a type="button" class="step-trigger" role="tab" id="stepper4trigger3" aria-controls="test-vl-3" aria-selected="true">
                                                <span class="bs-stepper-circle"><i class="fa fa-truck"></i></span>
                                                <span class="bs-stepper-label">In Transit</span>
                                            </a>
                                        </div>
                                        <div class="bs-stepper-line"></div>
                                        <div class="step" data-target="#test-vl-4">
                                            <a type="button" class="step-trigger" role="tab" id="stepper4trigger4" aria-controls="test-vl-4" aria-selected="true">
                                                <span class="bs-stepper-circle"><i class="fa fa-check"></i></span>
                                                <span class="bs-stepper-label">Delivered</span>
                                            </a>
                                        </div>
                                        </div>
                                        ');
                                        break;
                                    }
                                default: {
                                        echo ("<center>Invalid ORDER ID</center>");
                                        break;
                                    }
                            }

                            ?>
                        </div>
                    </div>
                    <?php
                    $date_format = date_create($fetch_shipping['date_shipping']);
                    $formatted_date = date_format($date_format, 'Y • F • d • g:i A');
                    ?>
                    <div class="card-footer">
                        <p class="float-left">Date Order : <?= $formatted_date ?></p>
                        <?php
                        if ($fetch_shipping['status'] === "parcel-transit" || $fetch_shipping['status'] === "parcel-delivered") {
                            echo ('<button class="btn btn-danger float-right col-md-4" disabled>Cancel Order</button>');
                        } elseif ($fetch_shipping['status'] === "cancel-order") {
                            echo ('<button class="btn btn-danger float-right col-md-4" disabled>Successfully Cancelled</button>');
                        } else {
                            echo ('<button data-id="' . $fetch_shipping['delivery_id'] . '" class="btn btn-danger btn-cancel float-right col-md-4">Cancel Order</button>');
                        }
                        ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Shop Detail End -->

    <?php
    require_once("wp-includes/response.php");
    require_once("scripts.php");
    if (!isset($user_id)) {
        require_once("modal.php");
    }
    require_once("footer.php");

    ?>
    <!-- Stepper -->
    <script src="wp-plugins/bs-stepper/js/bs-stepper.min.js"></script>

    <script>
        window.stepper4 = new Stepper(document.querySelector('#stepper4'))
        $(document).on("click", ".btn-cancel", function() {
            let delivery_id = $(this).data('id');

            $(this).text("Successfully Cancelled");
            $(this).attr("disabled", true);

            $.ajax({
                url: 'wp-actions/cancelOrder.php',
                method: 'POST',
                data: {
                    cancel_order: '<?= $_SESSION['csrf_token'] ?>',
                    delivery_id: delivery_id
                },
                success: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
</body>

</html>