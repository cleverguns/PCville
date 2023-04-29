<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
if(isset($_POST['UserId']) && !empty($_POST['csrf_token'])){
    $res = $user->getUserInfo($_POST['UserId']);
}else{
    $res = "error";
}

echo(json_encode($res));
?>