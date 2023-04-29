<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
if(isset($_POST['ProductId']) && !empty($_POST['csrf_token'])){
    $res = $products->getProductInfo($_POST['ProductId']);
}else{
    $res = "error";
}

echo(json_encode($res));
?>