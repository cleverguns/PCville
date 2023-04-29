<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

if (isset($_POST['parcel-deliver'])) {
    $redirect = header("Location: ../dashboard.php");

    $delivery_id = $_POST['delivery_id'];
    $user_id = $_POST['user_id'];
    $proof_id = generate_text(15);

    if (isset_file('proof')) {
        $img_name = $_FILES['proof']['name'];
        $tmp_name = $_FILES['proof']['tmp_name'];
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);
        $img_extension = ['png', 'jpg', 'jpeg'];
        $new_name = "img_" . rand(100, 999) . '.' . $img_ext;
        if (in_array($img_ext, $img_extension) === true) {
            if (move_uploaded_file($tmp_name, "../../wp-images/proof/" . $new_name)) {
                $delivery->addLogs($user_id, "Rider - Update delivery status to delivered.");
                $delivery->addProof($delivery_id, $proof_id, $user_id, $new_name);
                $_SESSION['success'] = "Successfully updated";
                $redirect;
            }
        } else {
            $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
            $redirect;
            echo ("error");
        }
    } else {
        echo ("error 1");
        $redirect;
    }
}
?>