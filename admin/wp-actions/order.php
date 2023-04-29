<?php
session_start();
include_once("../../wp-includes/config.php");
if(isset($_POST['change-status']) && !empty($_POST['csrf_token'])){
    
    $redirect = header("Location: ../dashboard/order.php");
    $status = $_POST['status'];
    $deliver_id = $_POST['delivery'];
    $date = date('Y-m-d H:i:s');
    if($_POST['csrf_token'] == $_SESSION['csrf_token']){

    $shipping_query = $conn->query("UPDATE tbl_shipping SET status = '{$status}', date_received = '{$date}' WHERE delivery_id = '{$deliver_id}' LIMIT 1");
    if($shipping_query){
        $_SESSION['success'] = "Successfully Updated";
        $redirect;
    }else{
        $_SESSION['error'] = "Something went wrong";
        $redirect;
    }
    }else{
        $_SESSION['error'] = "Invalid Request";
        $redirect; 
    }

}else{
    echo("Invalid Request");
}

?>