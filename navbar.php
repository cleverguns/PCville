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
                $notif_tag = 'data-toggle="modal" data-target="#user-login"';
            } else {
                $cart_tag = 'href="cart.php"';
                $notif_tag = 'data-toggle="modal" data-target="#user-notification"';
            }
            ?>

            <a <?= $notif_tag ?> class="btn border">
                <i class="fas fa-bell text-primary"></i>
                <span class="badge">
                    <?php
                     if (isset($user_id)) {
                        $tbl_shipping = $conn->query("SELECT * FROM tbl_shipping WHERE user_id = '{$user_id}'");
                        if ($tbl_shipping->num_rows > 0) {
                            echo ($tbl_shipping->num_rows);
                            $notif_tag = "href='checkout.php'";
                        } else {
                            echo ("0");
                            $notif_tag = "href='/'";
                        }
                    } else {
                        echo ("0");
                        $cart_tag = "href='/'";
                    }
                    ?>
                </span>
            </a>

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
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: 266px !important; z-index: 1;">
                <div class="remove-scroll navbar-nav w-100 px-3 bg-white border-bottom" style="height: 163px; overflow-y: scroll;">
                    <?php
                    $categories = $conn->query("SELECT c.category_name as name, c.category_id, COALESCE(COUNT(p.category_id), 0) as total FROM tbl_category c LEFT JOIN tbl_products p ON c.category_id = p.category_id GROUP BY c.category_id, c.category_name, c._id ORDER BY c._id ASC");
                    foreach ($categories as $row) {
                        echo ('
                            <a href="category.php?_id=' . $row['category_id'] . '" class="nav-item nav-link d-flex justify-content-between"><span>' . $row['name'] . '</span> <span><i class="fa fa-angle-right"></i> </span></a>
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
                                <a class="nav-link" data-toggle="modal" data-target="#search-modal" href="tracker.php">Search</a>
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex align-items-center">
                        <?php
                        if (isset($_SESSION['user_token'])) {
                            echo ('
                                    <a href="#" data-toggle="modal" data-target="#change-profile">
                                            <img src="wp-images/users/' . $avatar . '" class="img-fluid" style="width: 30px; height: 30px; border-radius: 50px;" alt="user-profile">
                                    </a>
                                    <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">
                                        ' . $user_name . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#user-settings"><i class="fas fa-cog"></i> Setting</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="wp-includes/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                    </div>
                                    </div>
                                    
                                ');
                        } else {
                            echo ('
                                <a href="#login" data-target="#user-login" data-toggle="modal" class="mr-3">Login</a>
                                <a href="#register" data-target="#user-signup" data-toggle="modal" class="btn btn-primary">Register</a> 
                                ');
                        }
                        ?>
                    </div>
                </div>
            </nav>

        </div>
    </div>
</div>