<?php
session_start();
include_once("config.php");

class Login
{
    private $conn;
    public $status;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function Login($username, $password)
    {
        $getDetails = $this->conn->query("SELECT * FROM tbl_users WHERE username = '{$username}' OR email = '{$username}' LIMIT 1");
        if (mysqli_num_rows($getDetails) > 0) {
            $fetchDetails = $getDetails->fetch_assoc();
            if (password_verify($password, $fetchDetails['password'])) {
                $_SESSION['user_token'] = $fetchDetails['user_id'];
                $this->status = "success";
            } else {
                $_SESSION['error'] = "Incorrect Username or Password";
                $this->status = "failed";
            }
        } else {
            $_SESSION['error'] = "Invalid Username or Password";
            $this->status = "invalid";
        }
    }

    public function status(){
        return $this->status;
    }
}

$login = new Login($conn);

if (isset($_POST['login']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        $login->Login($username, $password);
        $status = $login->status();
        if($status == "success"){
            header("Location: ../dashboard");
        }else{
            header("Location: ../");
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        header("Location: ../admin/");
    }
}elseif(isset($_POST['user-login']) && !empty($_POST['csrf_token'])){
    if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        $login->Login($username, $password);
        $status = $login->status();
        if($status == "success"){
            header("Location: ../");
        }else{
            header("Location: ../");
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        header("Location: ../");
    }
}
?>
