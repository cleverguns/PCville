<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

$logged_id = $_SESSION['user_token'];
$redirect =  header("Location: ../dashboard/users.php");

//User Function
if (isset($_POST['add-user']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $uid = "uid_" . generate_number(11);
        $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_role = filter_input(INPUT_POST, 'user_role', FILTER_SANITIZE_STRING);

        $username = "#".$lname.generate_number(4);

        $c_password = $_POST['cpassword'];
        $password = $_POST['password'];

        if ($password === $c_password) {
            if (isset_file('avatar')) {
                $img_name = $_FILES['avatar']['name'];
                $tmp_name = $_FILES['avatar']['tmp_name'];
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);
                $img_extension = ['png', 'jpg', 'jpeg'];
                $new_name = "img_" . rand(100, 999) . '.' . $img_ext;
                if (in_array($img_ext, $img_extension) === true) {
                    if (move_uploaded_file($tmp_name, "../../wp-images/users/" . $new_name)) {
                        $user->addLogs($logged_id, "Users - Added new user record.");
                        $user->addUser($uid, $fname, $lname, $new_name, $username, $email, $hash_password, $user_role, "verified");
                        $redirect;
                    }
                } else {
                    $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                    $redirect;
                }
            } else {
                $user->addLogs($logged_id, "Users - Added new user record.");
                $user->addUser($uid, $fname, $lname, 'default-avatar.png', $username, $email, $hash_password, $user_role, "verified");
                $redirect;
            }
        } else {
            $_SESSION['error'] = "Password not matched";
            $redirect;
        }
        echo ("Same");
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }

    //Delete User Function
} elseif (isset($_GET['uid']) && !empty($_GET['_token'])) {

    if ($_GET['_token'] === $_SESSION['csrf_token']) {
        $voucher->addLogs($logged_id, "Users - Deleted user record.");
        $user->deleteUser($_GET['uid']);
        $redirect;
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }

    //Edit User Photo
} elseif (isset($_POST['edit-photo']) && !empty($_POST['csrf_token'])) {
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
                    $user->addLogs($logged_id, "Users - Edited user photo.");
                    $user->editPhoto($uid, $new_name);
                    $redirect;
                }
            } else {
                $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                $redirect;
            }
        } else {
            $user->addLogs($logged_id, "Users - Edit user photo.");
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
                $user->addLogs($logged_id, "Users - Edited user record.");
                $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
            } else {
                $_SESSION['error'] = "Password Not Matched";
                $redirect;
            }
        } else {
            $user->addLogs($logged_id, "Users - Edited user record.");
            $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif(isset($_POST['update-admin']) && !empty($_POST['csrf_token'])){
    $redirect = header("Location: ../dashboard/");
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
                $user->addLogs($logged_id, "Users - Edit personal record.");
                $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
            } else {
                $_SESSION['error'] = "Password Not Matched";
                $redirect;
            }
        } else {
            $user->addLogs($logged_id, "Users - Edited personal record.");
            $user->updateUserInfo($uid, $fname, $lname, $email, $password, $user_role);
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_POST['admin-photo']) && !empty($_POST['csrf_token'])) {
    $redirect = header("Location: ../dashboard/");

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
                    $user->addLogs($logged_id, "Users - Edited personal profile.");
                    $user->editPhoto($uid, $new_name);
                    $redirect;
                }
            } else {
                $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                $redirect;
            }
        } else {
            $user->addLogs($logged_id, "Users - Edited personal photo.");
            $user->addUser($uid, $fname, $lname, 'default-avatar.png', $username, $hash_password, $user_role);
            $redirect;
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