<?php
session_start();
require_once("wp-includes/config.php");
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if(isset($_SESSION['user_token'])){
    $uid = $_SESSION['user_token'];
    $check_validation = $conn->query("SELECT status FROM tbl_users WHERE user_id = '{$uid}' LIMIT 1");

    if($check_validation->num_rows > 0){
        $fetch_user = $check_validation->fetch_assoc();
    
        if($fetch_user['status'] == "verified"){
            header("Location: ../");
        }
    }
}else{
    header("Location: ../");
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
</head>

<body>

    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-2 mr-1">PC</span>Village</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left d-lg-none">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-2 mr-1">PC</span>Village</h1>
                </a>
            </div>
            <div class="col-lg-9 col-6 text-right">
                <?php
                if (!isset($user_id)) {
                    $cart_tag = 'data-toggle="modal" data-target="#user-login"';
                } else {
                    $cart_tag = 'href="cart.php"';
                }
                ?>
                <a <?= $cart_tag ?> class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge text-cart">
                        <?php
                        if (isset($user_id)) {
                            $total_cart = $conn->query("SELECT * FROM tbl_carts WHERE user_id = '{$user_id}'");
                            if ($total_cart->num_rows > 0) {
                                echo ($total_cart->num_rows);
                                $cart_tag = "href='checkout.php'";
                            } else {
                                echo ("0");
                                $cart_tag = "href='/'";
                            }
                        } else {
                            echo ("0");
                            $cart_tag = "href='/'";
                        }
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="py-2 row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0 text-white">Categories</h6>
                    <i class="fa fa-angle-down text-white"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden px-3 bg-white border-bottom" style="height: auto">
                        <?php
                        $categories = $conn->query("SELECT c.category_name as name, c.category_id, COALESCE(COUNT(p.category_id), 0) as total FROM tbl_category c LEFT JOIN tbl_products p ON c.category_id = p.category_id GROUP BY c.category_id, c.category_name, c._id ORDER BY c._id ASC");
                        foreach ($categories as $row) {
                            echo ('
                            <a href="" class="nav-item nav-link d-flex justify-content-between"><span>' . $row['name'] . '</span> <span>' . $row['total'] . '</span></a>
                            ');
                        }
                        ?>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="tracker.php">Tracker</a>
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center">
                            <a href="#login" data-target="#user-login" data-toggle="modal" class="mr-3">Login</a>
                            <a href="#register" data-target="#user-signup" data-toggle="modal" class="btn btn-primary">Register</a>
                        </div>
                    </div>
                </nav>

            </div>
        </div>
    </div>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Verification</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Verify</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Checkout Start -->
    <div class="container-fluid pt-5" style="height: 800px;">
        <div class="row d-flex flex-column justify-content-center w-100 align-items-center">
            <div class="col-md-6">
                <div class="form-group w-100">
                    <label for="tracker">Email Address</label>
                    <div class="input-group">
                        <input type="text" name="tracker" class="form-control p-4 email" value="<?= $_SESSION['email'] ?>" readonly>
                        <div class="input-group-append">
                            <button data-toggle="modal" data-target="#change-email" class="btn btn-primary"><i class="fas fa-envelope"></i> Change Email</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h1 class="card-title">Verification Code</h1>
                    </div>
                    <div class="card-body ">
                        <form action="wp-actions/verification.php" method="post">
                            <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                            <div class="form-group">
                                <div class="input-group col-md-6 mx-auto">
                                    <input type="text" class="form-control text-center" name="verification_code">
                                    <div class="input-group-append">
                                        <button type="submit" name="send-code" class="btn btn-primary">Send Code</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button name="verification" type="submit" class="btn btn-primary col-md-4">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

    <div class="modal fade" id="change-email" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Change Email Address
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="frm-verification" action="wp-actions/verification.php" method="post">
                    <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="change-email" class="btn btn-primary">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php
    require_once("wp-includes/response.php");
    require_once("scripts.php");
    require_once("footer.php");
    ?>

    <script>
        $.validator.addMethod("allowedEmailDomain", function(value, element) {
            // List of allowed domains
            var allowedDomains = ["gmail.com", "yahoo.com", "outlook.com"];
            // Get the email domain
            var domain = value.split('@')[1];
            // Check if the domain is in the allowed list
            return allowedDomains.indexOf(domain) !== -1;
        }, "Please enter a valid email address with Gmail, Yahoo or Outlook.");

        $(".frm-verification").validate({
            rules: {
                email: {
                    required: true,
                    allowedEmailDomain: true
                },
            },
            messages: {
                email: {
                    required: "*Required.",
                    customRegex: "Your password must contain at least 1 uppercase, 1 lowercase letter, 1 number, and 1 special character."
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
        });
    </script>
</body>

</html>