<?php
include_once("../wp-includes/config.php");
if (isset($_POST['addCart'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];

    $cverify_query = $conn->query("SELECT * FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$product_id}' LIMIT 1");

    if ($cverify_query->num_rows > 0) {
        $res = "Already in cart";
    } else {
        if (isset($_POST['qty'])) {
            $qty = $_POST['qty'];
            $tbl_cart = $conn->query("INSERT INTO tbl_carts(user_id, product_id, qty, total) VALUES ($user_id, $product_id, $qty, $price)");
            if ($tbl_cart) {
                $res = "Added";
            } else {
                $res = "Failed";
            }
        } else {
            $tbl_cart = $conn->query("INSERT INTO tbl_carts(user_id, product_id, qty, total) VALUES ('{$user_id}', '{$product_id}', '1', $price)");
            if ($tbl_cart) {
                $res = "Added";
            } else {
                $res = "Failed";
            }
        }
    }
} else {
    $res = "Invalid Request";
}
echo (json_encode($res));
?>