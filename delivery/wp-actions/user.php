<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

$logged_id = $_SESSION['user_token'];
$redirect =  header("Location: ../");

//User Function
if (isset($_POST['edit-photo']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $uid = $_POST['uid'];
        if (isset_file('avatar')) {
            $img_name = $_FILES['avatar']['name'];
            $tmp_name = $_FILES['avatar']['tmp_name'];
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);
            $img_extension = ['png', 'jpg', 'jpeg'];
            $new_name = "img_" . rand(100, 999) . '.' . $img_ext;
            if (in_array($img_ext, $img_extension) === true) {
                if (move_uploaded_file($tmp_name, "../../wp-images/users/" . $new_name)) {
                    $user->editPhoto($uid, $new_name);
                    $redirect;
                }
            } else {
                $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                $redirect;
            }
        } else {
            $user->addUser($uid, $fname, $lname, 'default-avatar.png', $username, $hash_password, $user_role);
            $redirect;
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_POST['update-user']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $uid = $_POST['user_id'];
        $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $user_role = filter_input(INPUT_POST, 'user_role', FILTER_SANITIZE_STRING);

        $c_password = $_POST['cpassword'];
        $password = $_POST['password'];

        if (!empty($password)) {
            if ($password === $c_password) {
                $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
            } else {
                $_SESSION['error'] = "Password Not Matched";
                $redirect;
            }
        } else {
            $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} else {
    $_SESSION['error'] = "Invalid Request";
    $redirect;
}
?>