<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
if(isset($_POST['BillingId']) && !empty($_POST['csrf_token'])){
    $res = $billing->getBillingInfo($_POST['BillingId']);
}else{
    $res = "error";
}

echo(json_encode($res));
?>