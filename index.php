<?php
require_once("wp-includes/config.php");
require_once("wp-includes/session.php");
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PC-Village</title>
    <?php
    include_once("headers.php");
    ?>
</head>

<body>

    <!-- Navbar Start -->
    <?php require_once("navbar.php") ?>
    <!-- Navbar End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Fast Delivery</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">7 - Days Replacement</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <?php

            $product = $conn->query("SELECT * FROM tbl_products WHERE stock > 0");
            foreach ($product as $row) {
                if (isset($user_id)) {
                    $cart_query = $conn->query("SELECT product_id FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$row['product_id']}'");

                    if ($cart_query->num_rows > 0) {
                        $btn_cart = '
                    <button data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="w-100 btn btn-sm btn-danger float-right remove-cart"><i
                                    class="fas fa-times mr-1"></i>Remove Cart</button>';
                    } else {
                        $btn_cart = '
                    <button data-price="' . $row['prize'] . '" data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="w-100 btn btn-sm btn-primary float-right add-cart"><i class="fas fa-shopping-cart mr-1"></i>Add to Cart</button>
                    ';
                    }
                } else {
                    $btn_cart = '
                    <a href="#login" data-toggle="modal" data-target="#user-login" class="w-100 btn btn-sm btn-primary float-right"><i class="fas fa-shopping-cart mr-1"></i>Add To Cart</a>
                    ';
                }

                echo ('
                <div class="col-lg-3 col-md-4 pb-1">
                    <div class="card card-hover product-item border-0 mb-4 rounded">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0">
                            <img class="img-fluid w-100 bg-transparent" style="height: 230px;" src="wp-images/products/' . $row['product_photo'] . '" alt="">
                        </div>
                        <div class="card-body text-center px-2">
                            <h6 class="text-truncate mb-2 font-weight-semi-bold">' . $row['name'] . '</h6>
                            <div class="text-center">
                                <h6>₱ ' . number_format($row['prize']) . '</h6>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-6 mb-2">
                                    <a href="detail.php?_token=' . $_SESSION['csrf_token'] . '&product_id=' . $row['product_id'] . '" class="w-100 btn btn-sm btn-secondary"><i class="fas fa-eye mr-1"></i>View Detail</a>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    ' . $btn_cart . '
                                </div>

                            </div>
                        </div>
                    </div>
                 </div>
                ');
            }
            ?>

        </div>
    </div>
    <!-- Categories End -->




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

    <script>
        // Define the click event for adding items to cart
        $(document).on('click', 'button.add-cart', function() {
            let user_id = $(this).data('user');
            let product_id = $(this).data('id');
            let price = $(this).data("price");

            // Get the current cart count from the "text-cart" element
            var currentCount = parseInt($('.text-cart').text());

            // Add 1 to the cart count
            var newCount = currentCount + 1;

            // Update the "text-cart" element with the new count
            $('.text-cart').text(newCount);

            // Update the button class and text
            $(this).removeClass('btn-primary').addClass('btn-danger remove-cart').removeClass('add-cart');
            $(this).html('<i class="fas fa-times mr-1"></i> Remove Cart');

            // Send an AJAX request to add the item to the cart
            $.ajax({
                url: 'wp-actions/addCart.php',
                method: 'POST',
                data: {
                    addCart: '<?= $_SESSION['csrf_token'] ?>',
                    product_id: product_id,
                    price: price,
                    user_id: user_id
                },
            });
        });

        // Define the click event for removing items from cart
        $(document).on('click', 'button.remove-cart', function() {
            let user_id = $(this).data('user');
            let product_id = $(this).data('id');

            // Get the current cart count from the "text-cart" element
            var currentCount = parseInt($('.text-cart').text());

            // Subtract 1 from the cart count
            var newCount = currentCount-1;

            // // Update the "text-cart" element with the new count
             $('.text-cart').text(newCount);

            // Update the button class and text
            $(this).removeClass('btn-danger remove-cart');
            $(this).addClass('btn-primary add-cart');
            $(this).html('<i class="fas fa-shopping-cart mr-1"></i> Add to Cart');

            // Send an AJAX request to remove the item from the cart
            $.ajax({
                url: 'wp-actions/removeCart.php',
                method: 'POST',
                data: {
                    removeCart: '<?= $_SESSION['csrf_token'] ?>',
                    product_id: product_id,
                    user_id: user_id
                }
            });
        });
    </script>
</body>

</html>