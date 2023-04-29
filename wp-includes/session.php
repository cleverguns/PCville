<?php
session_start();
include_once('config.php');
if(isset($_SESSION['user_token'])){
    $user_id = $_SESSION['user_token'];
    $user_query = $conn->query("SELECT u.user_id, u.fname, u.lname, u.username, u.email , u.user_role, u.avatar, u.status FROM tbl_users u LEFT JOIN tbl_verification v ON u.user_id = v.user_id WHERE u.user_id = '{$user_id}' LIMIT 1");
    if($user_query->num_rows > 0){
        $fetch_data = $user_query->fetch_assoc();
        $first_name = $fetch_data['fname'];
        $last_name = $fetch_data['lname'];
        $user_name = ucfirst($fetch_data['fname']). " ". ucfirst($fetch_data['lname']) ;
        $username = $fetch_data['username'];
        $p_email = $fetch_data['email'];
        $role = $fetch_data['user_role'];
        $avatar = $fetch_data['avatar'];
        $_SESSION['role'] = $fetch_data['user_role'];

        if($fetch_data['status'] != "verified"){
            $_SESSION['name'] = ucfirst($fetch_data['fname']). " ". ucfirst($fetch_data['lname']);
            $_SESSION['email'] = $fetch_data['email'];
            header("Location: ../verification.php");
        }
      
    }else{
        header("Location: ../");
    }
}
?>