<?php
require_once("../wp-includes/session.php");

if(isset($_POST['cancel_order'])){
    $order_id = $_POST['delivery_id'];

    if($_POST['cancel_order'] == $_SESSION['csrf_token']){
        $select_order = $conn->query("SELECT* FROM tbl_shipping WHERE delivery_id = '{$order_id}' AND user_id = '{$user_id}' LIMIT 1");
        if($select_order->num_rows > 0){
            $update = $conn->query("UPDATE tbl_shipping SET status = 'cancel-order' WHERE delivery_id = '{$order_id}' AND user_id = '{$user_id}' LIMIT 1 ");
            if($update ){
                $res = [
                    "status" => "Success"
                ];
            }else{
                $res = [
                    "status" => "Failed"
                ];
            }
           
        }else{
            $res = [
                "status" => "Failed"
            ];
        }
    }else{
        $res = [
            "status" => "Failed"
        ];
    }

   
}else{
    header("Location: ../");
}

echo(json_encode($res));
?>