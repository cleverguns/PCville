<?php
require_once("wp-includes/session.php");
require_once("wp-includes/autoLoader.php");

if (isset($_GET['_token']) && isset($_GET['_key']) && $_SESSION['csrf_token']) {
    $user_id = $_SESSION['user_token'];
    $transaction_id = $_GET['_key'];

    $transaction->update_transaction($user_id, $transaction_id, "Failed");
    $transaction_query = $conn->query("SELECT * FROM tbl_transactions WHERE user_id = '{$user_id}' AND transaction_id = '{$transaction_id}' LIMIT 1");

    $fetch_record = $transaction_query->fetch_assoc();
} else {
    echo ("Invalid Request");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC-Village | Payment</title>
    <?php
    include_once("headers.php");
    ?>
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
            <div class="col-md-6">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Transaction Record</h1>
                    </div>
                    <?php
                        switch ($fetch_record['type']) {
                            case 'gcash':{
                                $payment_type = "Gcash";
                                break;
                            }
                            case 'grab_pay': {
                                $payment_type = "Grab Pay";
                            }
                        }
                        ?>
                    <div class="card-body">
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Transaction Id </p>
                            <p class="m-0"><?=$fetch_record['transaction_id']?></p>
                        </div>
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Type of Payment </p>
                            <p class="m-0"><?=$payment_type?></p>
                        </div>
                        <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Status </p>
                            <p class="m-0"><?=$fetch_record['status']?></p>
                        </div>
                        <div class="py-2 d-flex justify-content-between align-items-center">
                            <p class="m-0">Total Amount : </p>
                            <p class="m-0">₱ <?= number_format($fetch_record['amount'])?></p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/" class="btn btn-danger col-md-4" >Go Back</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Shop Detail End -->

    <?php
    require_once("wp-includes/response.php");
    if (!isset($user_id)) {
        require_once("modal.php");
    }
    require_once("footer.php");
    require_once("scripts.php");
    ?>
</body>

</html>