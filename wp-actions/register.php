<?php
session_start();
require_once("../wp-includes/autoLoader.php");
require_once("../wp-includes/utils.php");

$redirect =  header("Location: ../");

//User Function
if (isset($_POST['register']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $uid = "uid_" . generate_number(11);
        $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
        $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST['email']));
        $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user_role = "user";

        $username = "#" . $lname . generate_number(4);

        $user_select = $conn->query("SELECT * FROM tbl_users WHERE email = '{$email}' LIMIT 1");
        if($user_select->num_rows > 0){
            $_SESSION['error'] = "Email is already exist";
            $redirect;
        }else{
            $c_password = $_POST['cpassword'];
            $password = $_POST['password'];
    
            if ($password === $c_password) {
                $user->addUser($uid, $fname, $lname, 'default-avatar.png', $username, $email, $hash_password, $user_role, "not-verified");
                $redirect;
            } else {
                $_SESSION['error'] = "Password not matched";
                $redirect;
            }
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
}
?>