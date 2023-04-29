<?php
require_once("../wp-includes/config.php");
require_once("../wp-includes/session.php");

$redirect = header("Location: ../cart.php");
if(isset($_GET['_token']) && isset($_GET['uid'])){
    if($_GET['_token'] == $_SESSION['csrf_token']){
        $product = $_GET['uid'];
        $delete_cart = $conn->query("DELETE FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$product}' LIMIT 1");
        if($delete_cart){
            $redirect;
        }else{
            $_SESSION['error'] = "Something went wrong";
            $redirect;
        }
    }else{
        $_SESSION['error'] = "Invalid Token";
        $redirect;  
    }

}else{
    $_SESSION['error'] = "Invalid Request";
    $redirect;
}

?>