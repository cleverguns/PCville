<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

$logged_id = $_SESSION['user_token'];
$redirect = header("Location: ../dashboard/billings.php");

if (isset($_POST['add-billing']) && !empty($_POST['csrf_token'])) {
    $user_id = $_POST["user_id"];
    $billing_id = "bid_" . generate_number(11);
    $fname =  $_POST['fname'];
    $lname =  $_POST['lname'];
    $contact = $_POST['contact'];
    $address1 = $_POST['address_1'];
    $address2 = $_POST['address_2'];
    $additional_address = $_POST['additional_address'];
    $postal_code = $_POST['postal_code'];
    $email = $_POST['email_address'];
    $province = $_POST['province'];

    $check_same = $conn->query("SELECT * FROM tbl_billings WHERE user_id = '{$user_id}' LIMIT 1");

    if ($check_same->num_rows > 0) {
        $_SESSION['error'] = "User already have billing info.";
        $redirect;
    } else {
        $billing->addLogs($logged_id, "Billings - Added new billing record.");
        $billing->addBilling($user_id, $billing_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code);
        $redirect;
    }


} elseif (isset($_GET['bid']) && !empty($_GET['_token'])) {
    if ($_GET['_token'] === $_SESSION['csrf_token']) {
        $billing->addLogs($logged_id, "Billings - Deleted billing record.");
        $billing->deleteBilling($_GET['bid']);
        $redirect;
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_POST['update-billing']) && !empty($_POST['csrf_token'])) {

    $user_id = $_POST["user_id"];
    $billing_id =  $_POST["billing_id"];
    $fname =  $_POST['fname'];
    $lname =  $_POST['lname'];
    $contact = $_POST['contact'];
    $address1 = $_POST['address_1'];
    $address2 = $_POST['address_2'];
    $postal_code = $_POST['postal_code'];
    $email = $_POST['email_address'];
    $province = $_POST['province'];
    $additional_address = $_POST['additional_address'];

    $billing->addLogs($logged_id, "Billings - Edited billing record.");
    $billing->updateBilling($user_id, $fname, $lname, $email, $province, $contact, $address1, $address2, $additional_address, $postal_code, $billing_id);

    $redirect;
} else {
    $_SESSION['error'] = "Invalid Request";
    $redirect;
}
