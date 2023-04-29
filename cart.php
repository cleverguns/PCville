<?php
require_once("wp-includes/config.php");
require_once("wp-includes/session.php");
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if (!isset($user_id)) {
    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PC-Village - Cart</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <?php require_once("headers.php") ?>
    <!-- iCheck Bootstrap-->
    <link rel="stylesheet" href="wp-plugins//icheck-bootstrap/icheck-bootstrap.min.css">

</head>

<body>

    <!-- Navbar Start -->
    <?php require_once("navbar.php") ?>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th colspan="2">Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php

                        if (isset($user_id)) {
                            $cart_query = $conn->query("SELECT c.status, c.total, c.qty, c.user_id  as user, p.product_id as product, p.prize, p.product_photo as image, p.name as name , c.qty as quantity, p.stock FROM tbl_carts c LEFT JOIN tbl_products p ON c.product_id = p.product_id WHERE c.user_id = '{$user_id}'");
                            $counter = 0;
                            if ($cart_query->num_rows > 0) {
                                foreach ($cart_query as $row) {
                                    ++$counter;
                                    if (!empty($row['status'])) {
                                        $check_tag = "checked";
                                    } else {
                                        $check_tag = "";
                                    }
                                    echo ('
                                    <tr class="product">
                                        <td class="align-middle">
                                        <div class="form-group clearfix checkout">
                                        <div class="icheck-primary d-inline">
                                          <input type="checkbox" class="add-check" data-id="' . $row['product'] . '" name="' . $row['product'] . '" id="' . $counter . '" value="' . $row['product'] . '" ' . $check_tag . '>
                                          <label for="' . $counter . '">
                                          </label>
                                        </div>
                                      </div>
                                      
                                        </div>
                                        </td>
                                        <td class="align-middle">
                                            <img src="wp-images/products/' . $row['image'] . '" alt="product-photo" class="float-left" style="width: 50px; height: 50px;">
                                            ' . $row['name'] . '
                                        </td>
                                        <td class="align-middle">₱ <span class="product-price">' . $row['prize'] . '</span></td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center">
                                                <div class="input-group quantity" style="width: 100px;">
                                                    <div class="input-group-prepend">
                                                        <button data-id="' . $row['product'] . '" class="btn btn-sm btn-outline-secondary bg-none btn-minus" type="button" id="show-password-toggle" aria-label="Show password">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text" class="product-qty form-control form-control-sm text-center" style="width: 10px !important;" value="' . $row['qty'] . '" disabled>
                                                    <div class="input-group-append">
                                                        <button data-max="' . $row['stock'] . '" data-id="' . $row['product'] . '" class="btn btn-sm btn-outline-primary bg-none btn-plus" type="button" id="show-password-toggle" aria-label="Show password">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">₱ <span class="product-total">' . $row['total']. '</span></td>
                                        <td class="align-middle">
                                            <button data-id="' . $row['product'] . '" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-times"></i></button>
                                            </td>
                                    
                                    </tr>
                                ');
                                }
                            } else {
                                echo ('
                                <tr class="product">
                                <td colspan="6"><span class="badge badge-danger p-2">Empty Cart</span></td>
                            </tr>
                            ');
                            }
                        } else {
                            echo ('
                            <tr class="product">
                                <td colspan="6"><span class="badge badge-danger p-2">Empty Cart</span></td>
                            </tr>
                            ');
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between pt-1">
                            <h4 class="font-weight-bold">Total</h6>
                                <h4 class="font-weight-bold">₱
                                    <?php
                                    if (isset($user_id)) {
                                        $getUpdate = $conn->query("SELECT SUM(total) as total FROM tbl_carts WHERE user_id = '{$user_id}' AND status = 'checkout' LIMIT 1");
                                        if ($getUpdate->num_rows > 0) {
                                            $fetchRow = $getUpdate->fetch_assoc();
                                            $total = number_format($fetchRow['total']);
                                        } else {
                                            $total = 0;
                                        }
                                    } else {
                                        $total = 0;
                                    }


                                    ?>
                                    <span class="sub-total"><?= $total ?></span>
                                </h4>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent border-top">
                        <a <?= $cart_tag ?> class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>



    <?php
    require_once("wp-includes/response.php");
    require_once("scripts.php");
    if (!isset($user_id)) {
        require_once("modal.php");
    }
    require_once("footer.php");
    ?>
    <!-- jQuery -->

    <script>
        let userId = "<?= !empty($user_id) ?>";

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let id = $(this).data("id");
            let token = "<?= $_SESSION['csrf_token'] ?>";
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Success!',
                        text: "Successfully Deleted!",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function() {
                        window.location.href = `wp-actions/deleteCart.php?uid=${id}&_token=${token}`;
                    }, 1500);
                }
            })
        });

        $('.quantity button').on('click', function() {
            var button = $(this);
            var row = button.closest('tr'); // find the nearest row to the button
            var total = row.find('.product-total'); // find the total within that row
            var price = row.find('.product-price'); // find the price within that row
            var oldValue = button.parent().parent().find('input').val();
            var quantity = button.parent().parent().find('input');


            let isChecked = row.find(".add-check").is(":checked");
            let product_price = parseInt(price.text()); //Get Product Price for RTU.

            if (button.hasClass('btn-plus')) {
                let max = $(this).data("max");
                let productID = $(this).data("id");
                if (oldValue == max) {
                    var newVal = max;
                } else {
                    var newVal = parseFloat(oldValue) + 1;
                    var newPrice = parseInt(total.text()) + parseInt(price.text());

                    $.ajax({
                        url: "wp-actions/updateCart.php",
                        method: "POST",
                        data: {
                            userId: userId,
                            productId: productID,
                            price: product_price,
                            quantity: newVal,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (isChecked) {
                                let newTotal = data.total;
                                $(".sub-total").text(newTotal.toLocaleString());
                            }
                        }
                    });
                }
            } else {
                let productID = $(this).data("id");
                if (oldValue > 1) {
                    var newVal = parseFloat(oldValue) - 1;
                    var newPrice = parseInt(total.text()) - parseInt(price.text());

                    $.ajax({
                        url: "wp-actions/updateCart.php",
                        method: "POST",
                        data: {
                            userId: userId,
                            productId: productID,
                            price: product_price,
                            quantity: newVal,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (isChecked) {
                                let newTotal = data.total;
                                $(".sub-total").text(newTotal.toLocaleString());
                            }
                        }
                    });
                } else {
                    newVal = 1;
                    newPrice = parseInt(price.text());

                }
            }

            total.text(newPrice);
            button.parent().parent().find('input').val(newVal);

        });

        $('.checkout input').on('change', function() {
            let productID = $(this).data("id");
            var checkbox = $(this);
            var row = checkbox.closest('tr'); // find the nearest row to the button
            var total = row.find('.product-total').text(); // find the total within that row
            var tmp_price = $('.sub-total').text(); // find the price within that row
            let price = tmp_price.replace(",", "");

            if (!$(this).prop('checked')) { // Check if the checkbox is unchecked
                let unChecked_price = parseInt(total); // Get the unchecked product-total value
                let newTotal = parseInt(price) - unChecked_price; // Subtract the unchecked product-total value from the sub-total
                $('.sub-total').text(newTotal.toLocaleString());

                $.ajax({
                    url: "wp-actions/updateCart.php",
                    method: "POST",
                    data: {
                        productId: productID,
                        status: "remove-checkout",
                    },
                    dataType: "json",
                    success: function(data) {
                        let newTotal = data.total;
                        $(".sub-total").text(newTotal.toLocaleString());
                    }
                });
            } else { // Checkbox is checked
                let newTotal = parseInt(total) + parseInt(price); // Add the product-total value to the sub-total
                $('.sub-total').text(newTotal.toLocaleString());

                $.ajax({
                    url: "wp-actions/updateCart.php",
                    method: "POST",
                    data: {
                        productId: productID,
                        status: "checkout",
                    },
                    dataType: "json",
                    success: function(data) {
                        let newTotal = data.total;
                       //$(".sub-total").text(newTotal.toLocaleString());
                    }
                });
            }
        });
    </script>
</body>

</html>