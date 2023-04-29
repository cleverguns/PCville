<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
if(isset($_POST["parcel_id"]) && isset($_POST["getParcel"])) {
    $delivery_id = $_POST['parcel_id'];
    $parcel = $conn->query("SELECT s.delivery_id, b.fname, b.lname, b.contact, b.address_1, b.address_2, b.additional_address FROM tbl_shipping s RIGHT JOIN tbl_billings b ON s.billing_id = b.billing_id WHERE s.delivery_id = '{$delivery_id}'");

   if($parcel->num_rows > 0){
    $parcel_record = $parcel->fetch_assoc();
   }else{
    $parcel_record = "error";
   }
}
echo(json_encode($parcel_record));
?>