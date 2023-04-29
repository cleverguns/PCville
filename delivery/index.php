<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
if(isset($_SESSION['user_token'])){
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider | Login</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../wp-plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../wp-plugins/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../wp-plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Sweet Alert 2-->
    <script src="../wp-plugins/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../wp-plugins/sweetalert2/sweetalert2.min.css" />

</head>

<body class="hold-transition login-page" style="height:  100vh !important;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="" class="h1">Rider Login</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form class="login" action="../wp-includes/login.php" method="post">
                    <input type="text" name="csrf_token" value="<?=$_SESSION['csrf_token'] ?>" hidden>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button name="rider-login" type="submit" class="btn btn-primary btn-block w-100">Sign In</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- jQuery -->
    <script src="../wp-plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../wp-plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../wp-plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../wp-plugins/dist/js/adminlte.js"></script>
    <!-- Validation Plugins -->
    <script src="../wp-plugins/jquery-validation/jquery.validate.js"></script>
   
    <script>
        $('.login').validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },

        }); 
    </script>
     <?php require_once("../wp-includes/response.php");?>
</body>

</html>