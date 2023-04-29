<?php
require_once("wp-includes/config.php");
require_once("wp-includes/session.php");
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if (!isset($user_id)) {
    header("Location: /");
}

$checkout_product = $conn->query("SELECT p.name as name, p.prize as price, c.qty, c.product_id 
FROM tbl_carts c 
LEFT JOIN tbl_products p ON c.product_id = p.product_id 
WHERE c.user_id = '{$user_id}' AND c.status IS NOT NULL
");
if ($checkout_product->num_rows < 1) {
    $_SESSION['error'] = "Please select atleast 1 item.";
    header("Location: cart.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PC-Village - Check Out</title>
    <link rel="stylesheet" href="wp-plugins/select2/css/select2.min.css" />
    <?php
    include_once("headers.php");
    ?>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->



    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <!-- action="wp-actions/checkout.php" -->
        <form action="wp-actions/checkout.php" class="frm-billing row px-xl-5" method="post">
            <div class="col-lg-8">
                <div class="mb-4">
                    <?php
                    $billing_query = $conn->query("SELECT * FROM tbl_billings WHERE user_id = '{$user_id}' LIMIT 1");
                    if ($billing_query->num_rows > 0) {
                        $billing_row = $billing_query->fetch_assoc();
                        $checked = "checked";
                        $display_1 = "d-none";
                        $display_2 = "";
                    } else {
                        $display_1 = "";
                        $display_2 = "d-none";
                        $billing_row = [
                            "billing_id" => "",
                            "fname" => "",
                            "lname" => "",
                            "email" => "",
                            "contact" => "",
                            "province" => "BULACAN",
                            "address_1" => "",
                            "address_2" => "",
                            "postal_code" => "",
                            "additional_address" => "",
                        ];
                        $checked = "";
                    }
                    ?>
                    <h4 class="font-weight-semi-bold mb-4 border-bottom pb-2">Billing Address</h4>
                    <div class="billing-edit row <?= $display_1 ?>">
                        <input type="text" name="billing_id" value="<?= $billing_row['billing_id'] ?>" hidden>
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control" type="text" name="fname" value="<?= $billing_row['fname'] ?>" placeholder="John">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control" type="text" name="lname" value="<?= $billing_row['lname'] ?>" placeholder="Doe">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="text" name="email" value="<?= $billing_row['email'] ?>" placeholder="Johndoe123@example.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Province</label>
                            <input type="text" data-id="0314" class="form-control" name="province" id="province" value="<?= $billing_row['province'] ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <select id="city" data-city="<?= $billing_row['address_1'] ?>" class="form-control select2 select2-hidden-accessible" name="address1" value="<?= $billing_row['address_1'] ?>" style="width: 100%" disabled>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Baranggay</label>
                            <select id="brgy" data-brgy="<?= $billing_row['address_2'] ?>" class="form-control select2 select2-hidden-accessible" name="address2" value="<?= $billing_row['address_2'] ?>" style="width: 100%" disabled>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Contact</label>
                            <input class="form-control" type="text" name="contact" value="<?= $billing_row['contact'] ?>" placeholder="0941 381 1583">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Zip Code</label>
                            <input class="form-control" id="zipCode" readonly type="text" name="postal" value="<?= $billing_row['postal_code'] ?>" placeholder="8371">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Additional Address Information</label>
                            <textarea class="form-control" style="resize: none;" name="additional_address" id="additional_address" rows="3" placeholder="Block 6, San Jose,"><?= $billing_row['additional_address'] ?></textarea>
                        </div>
                    </div>
                    <div class="billing-default row <?= $display_2 ?> border-bottom justify-content-between">
                        <div class="form-group">
                            <div class="icheck-primary clearfix d-inline">
                                <input type="checkbox" class="add-check" name="default" checked>
                                <label for="default">
                                    Default Delivery Address
                                    <div>
                                        <h6><?= $billing_row['fname'] . ' ' . $billing_row['lname'] . ' | ' . $billing_row['contact'] . '<br/>' . $billing_row['address_1'] . ', ' . $billing_row['address_2'] . ' ' . $billing_row['postal_code'] ?></h6>
                                    </div>
                                </label>

                            </div>

                        </div>

                        <div>
                            <button type="button" class="btn-edit btn btn-primary"><i class="fas fa-edit"></i> Edit Billing</button>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-3">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            <h5 class="font-weight-medium mb-3">Quantity</h5>
                        </div>

                        <?php

                        $description = "";
                        $totalShipping = 0;

                        foreach ($checkout_product as $product_row) {
                            $shipping = $conn->query("SELECT shipping FROM tbl_products WHERE product_id = '{$product_row['product_id']}'");
                            $shipping_row = $shipping->fetch_assoc();
                            $totalShipping += $shipping_row['shipping'];

                            echo ('
                            <input type="text" class="form-control p-4" value="' . $product_row['product_id'] . '" name="product[]" hidden>
                            <input type="text" class="form-control p-4" value="' . $product_row['qty'] . '" name="stock[]" hidden>
                            <div class="d-flex justify-content-between">
                                <p>' . $product_row['name'] . '</p>
                                <p>' . $product_row['qty'] . 'x</p>
                            </div>
                            ');

                            $description .=  $product_row['name'] . '  |  ' . $product_row['qty'] . 'x | ' . $product_row['price'] . ' </br>';
                        }

                        ?>
                    </div>
                    <textarea name="description" hidden><?= $description ?></textarea>
                    <div class="card-footer bg-transparent">
                        <div class="row justify-content-between mt-2">
                            <h5 class="font-weight-semi-bold text-md">Shipping Fee</h5>
                            <h5 class="font-weight-semi-bold text-md">₱ <span class="txt-shipping"></span></h5>
                        </div>
                        <div class="row justify-content-between mt-2 pt-2 border-top">
                            <?php
                            if (isset($user_id)) {
                                $getUpdate = $conn->query("SELECT SUM(total) as total FROM tbl_carts WHERE user_id = '{$user_id}' AND status = 'checkout' LIMIT 1");
                                if ($getUpdate->num_rows > 0) {
                                    $fetchRow = $getUpdate->fetch_assoc();
                                    $shipping = $fetchRow['total'];
                                    $total = number_format($shipping);
                                } else {
                                    $total = 0;
                                }
                            } else {
                                $total = 0;
                            }
                            ?>


                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">₱ <span class="txt-total"></span></h5>
                        </div>
                    </div>
                </div>

                <div class="card border-secondary my-3">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <input type="number" class="total" name="amount" hidden>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="cod" value="cash-on-delivery" checked>
                                <label class="custom-control-label" for="cod">Cash On Delivery</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="gcash" value="gcash">
                                <label class="custom-control-label" for="gcash">Gcash</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button name="checkout" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 btn-order">Place Order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>



    <?php
    require_once("wp-includes/response.php");
    require_once("scripts.php");
    require_once("footer.php");
    if (!isset($user_id)) {
        require_once("modal.php");
    }
    ?>
    <script src="wp-plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            let cityData;
            let brgyData;
            // Load city data
            const selectedProvinceCode = $("#province").data("id");

            $.getJSON('city.json', function(data) {
                cityData = data;
                const citySelect = $('#city');
                // Clear the city select box
                citySelect.empty();
                // Populate the city select box with cities in the selected province
                $.each(cityData, function(index, city) {
                    if (city.provCode === selectedProvinceCode) {
                        citySelect.append('<option data-id="' + city.zipCode + '" data-code="' + city.citymunCode + '" value="' + city.citymunDesc + '">' + city.citymunDesc + '</option>');
                        $("#zipCode").val(city.zipCode);
                    }
                });
                citySelect.removeAttr("disabled");

                // check if the data-city attribute of the select box has a value
                const dataCityValue = citySelect.data("city");
                if (dataCityValue) {
                    // find the corresponding option in the select box and select it
                    const selectedOption = citySelect.find('option[value="' + dataCityValue + '"]');
                    if (selectedOption.length) {
                        selectedOption.prop('selected', true);
                    }
                } else {
                    // Select first city in list
                    citySelect.find('option:first').prop('selected', true);
                }

                // Load brgy data
                citySelect.change(function() {
                    let citySelected = $(this).find("option:selected").data("code");
                    let zipCode = $(this).find("option:selected").data("id");
                    $("#zipCode").val(zipCode);
                    $.getJSON('brgy.json', function(data) {
                        brgyData = data;
                        const brgySelect = $('#brgy');
                        brgySelect.empty();
                        $.each(brgyData, function(index, brgy) {
                            if (brgy.citymunCode === citySelected) {
                                brgySelect.append('<option data-id="' + brgy.brgyCode + '" value="' + brgy.brgyDesc + '">' + brgy.brgyDesc + '</option>');
                            }
                        });
                        brgySelect.removeAttr("disabled");

                        // check if the data-brgy attribute of the select box has a value
                        const dataBrgyValue = brgySelect.data("brgy");
                        if (dataBrgyValue) {
                            // find the corresponding option in the select box and select it
                            const selectedOption = brgySelect.find('option[value="' + dataBrgyValue + '"]');
                            if (selectedOption.length) {
                                selectedOption.prop('selected', true);
                            }
                        } else {
                            // Select first city brgy list
                            brgySelect.find('option:first').prop('selected', true);
                        }

                    });
                });
                citySelect.trigger('change');
            });

            // Get the current selected city
            const citySelect = $('#city');
            const targetCity = citySelect.val();

            // set the verification criteria
            let totalShipping = "<?= $shipping ?>";
            let productShipping = "<?= $totalShipping ?>";

            $.getJSON('city.json', function(data) {
                $.each(data, function(index, item) {
                    if (item.citymunDesc === targetCity) {
                        var shippingValue = item.shipping;
                        $(".txt-shipping").text(shippingValue + parseInt(productShipping));
                        let total = parseInt(totalShipping) + shippingValue + parseInt(productShipping);
                        $(".txt-total").text(total);
                        $(".total").val(total + "00");
                        // do something with the shipping value, e.g. update a form field
                        return false; // exit the loop early if a match is found
                    } 
                });
            });

            // Update the shipping cost whenever the user selects a different city
            citySelect.on('change', function() {
                const targetCity = $(this).val();

                $.getJSON('city.json', function(data) {
                $.each(data, function(index, item) {
                    if (item.citymunDesc === targetCity) {
                        var shippingValue = item.shipping;
                        $(".txt-shipping").text(shippingValue + parseInt(productShipping));
                        let total = parseInt(totalShipping) + shippingValue + parseInt(productShipping);
                        $(".txt-total").text(total);
                        $(".total").val(total + "00");
                        // do something with the shipping value, e.g. update a form field
                        return false; // exit the loop early if a match is found
                    }
                });
            });
            });

            bsCustomFileInput.init();

            $(".frm-billing").validate({
                rules: {
                    fname: {
                        required: true,
                        customRegex: /^[a-zA-Z ]+$/
                    },
                    lname: {
                        required: true,
                        customRegex: /^[a-zA-Z ]+$/
                    },
                    email: {
                        required: true,
                        email: true,
                        allowedEmailDomain: true
                    },
                    contact: {
                        number: true,
                        minlength: 11,
                        maxlength: 11,
                        required: true,
                        digits: true,
                        customRegex: /^09\d{9}$/,
                    },
                    province: {
                        required: true,
                        customRegex: /^[a-zA-Z0-9 ]+$/
                    },
                    address1: {
                        required: true,
                        customRegex: /^[a-zA-Z0-9, ]+$/
                    },
                    address2: {
                        required: true,
                        customRegex: /^[a-zA-Z0-9, ]+$/
                    },
                    additional_address: {
                        required: true,
                    },
                    postal: {
                        required: true,
                        minlength: 4,
                        maxlength: 4,
                        number: true,
                        digits: true,
                    },
                },
                messages: {
                    fname: {
                        required: "*Required.",
                        customRegex: "Please enter only letters."
                    },
                    lname: {
                        required: "*Required.",
                        customRegex: "Please enter only letters."
                    },

                    contact: {
                        required: "*Required.",
                        digits: "Please enter a valid number",
                        minlength: "Please enter a 11-digit number",
                        maxlength: "Please enter a 11-digit number",
                        customRegex: "Please enter only PH number, eg. 09xxxxxxxxx."
                    },
                    additional_address: "*Required",
                    province: "*Required.",
                    address1: "*Required.",
                    address2: "*Required.",
                    email: "*Required.",
                    postal: {
                        required: "*Required.",
                        digits: "Please enter a valid number",
                        minlength: "Please enter a 4-digit number",
                        maxlength: "Please enter a 4-digit number"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
            });

            $(".btn-edit").on("click", function() {
                $(".billing-edit").removeClass("d-none");
                $(".billing-default").addClass("d-none");
            });

        });
    </script>
</body>

</html>