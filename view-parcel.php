<?php
require_once("wp-includes/config.php");
require_once("wp-includes/session.php");
if (!isset($user_id)) {
    header("Location: /");
}
if (isset($_GET['_token'])) {
    if (!empty($_GET['_key'])) {
        if ($_GET['_token'] = $_SESSION['csrf_token']) {
            $delivery_id = "#" . mysqli_real_escape_string($conn, $_GET['_key']);
            $shipping_query = $conn->query("SELECT s.date_received, s.status, s.delivery_id, s.date_shipping, t.description FROM tbl_shipping s LEFT JOIN tbl_transactions t ON s.user_id = t.user_id AND s.token = t.transaction_id WHERE s.user_id = '{$user_id}' AND s.delivery_id = '{$delivery_id}' LIMIT 1");
            if ($shipping_query->num_rows > 0) {
                $fetch_shipping = $shipping_query->fetch_assoc();
            } else {
                $fetch_shipping = [
                    "delivery_id" => "Invalid Request, Make sure your Order ID is belong to your account.",
                    "status" => "",
                    "date_shipping" => ""
                ];
                header("Location: /");
            }
        } else {
            header("Location: /");
        }
    }
} else {
    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PC-Village - Tracker</title>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Order Details</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Order Details</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Checkout Start -->
    <div class="container-fluid pt-5" style="height: 800px;">
        <div class="row d-flex justify-content-center w-100">
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
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Shipping Status - <?= $fetch_shipping['delivery_id'] ?></h1>
                    </div>
                    <div class="card-body">
                        <div id="stepper4" class="bs-stepper vertical linear" data-linear="true">
                            <?php
                            $date_format = date_create($fetch_shipping['date_shipping']);
                            $formatted_date = date_format($date_format, 'Y • F • d • g:i A');
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

                                        $date_received = date_create($fetch_shipping['date_received']);
                                        $date_received = date_format($date_received, 'Y • F • d • g:i A');


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
                                                        <p class="my-2">Parcel has been delivered.<br>Date Order : ' . $formatted_date . '<br>Date Received : ' . $date_received . '</p>
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
                    <div class="card-footer">
                        <?php
                        if ($fetch_shipping['status'] != "parcel-delivered") {
                            echo ('<p class="float-left">Date Order : ' . $formatted_date . '</p>');
                        }

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
    <!-- Checkout End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>



    <?php
    require_once("scripts.php");
    require_once("wp-includes/response.php");
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