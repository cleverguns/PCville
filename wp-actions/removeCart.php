<?php
include_once("../wp-includes/config.php");
if(isset($_POST['removeCart'])){
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $conn->query("DELETE FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$product_id}' LIMIT 1");
    $res = "Success";
}else{
    $res = "Failed";
}

echo (json_encode($res));

?>