<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

$logged_id = $_SESSION['user_token'];
$redirect = header("Location: ../dashboard/products.php");

if (isset($_POST['add-product']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $pid = "pid_" . generate_number(11);
        $category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $prize = filter_input(INPUT_POST, 'prize', FILTER_SANITIZE_NUMBER_INT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
        $shipping = filter_input(INPUT_POST, 'shipping', FILTER_SANITIZE_NUMBER_INT);
        if (isset_file('photo')) {
            $img_name = $_FILES['photo']['name'];
            $tmp_name = $_FILES['photo']['tmp_name'];
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);
            $img_extension = ['png', 'jpg', 'jpeg'];
            $new_name = "img_" . rand(100, 999) . '.' . $img_ext;
            if (in_array($img_ext, $img_extension) === true) {
                if (move_uploaded_file($tmp_name, "../../wp-images/products/" . $new_name)) {
                    $products->addLogs($logged_id, "Products - Added new product record.");
                    $products->addProduct($pid, $category_id, $new_name, $name, $description, $prize, $stock, $shipping);
                    $redirect;
                }
            } else {
                $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                $redirect;
            }
        } else {
            $_SESSION['error'] = "Please select product photo.";
            $redirect;
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_GET['pid']) && !empty($_GET['_token'])) {
    $products->addLogs($logged_id, "Products - Delete product record.");
    if ($_GET['_token'] === $_SESSION['csrf_token']) {
        $products->deleteProduct($_GET['pid']);
        $redirect;
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_POST['edit-photo']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $pid = $_POST['product_id'];
        if (isset_file('photo')) {
            $img_name = $_FILES['photo']['name'];
            $tmp_name = $_FILES['photo']['tmp_name'];
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);
            $img_extension = ['png', 'jpg', 'jpeg'];
            $new_name = "img_" . rand(100, 999) . '.' . $img_ext;
            if (in_array($img_ext, $img_extension) === true) {
                if (move_uploaded_file($tmp_name, "../../wp-images/products/" . $new_name)) {
                    $products->addLogs($logged_id, "Products - Edited product image.");
                    $products->editPhoto($pid, $new_name);
                    $redirect;
                }
            } else {
                $_SESSION['error'] = "The file is not support only jpeg, jpg and png";
                $redirect;
            }
        } else {
            $_SESSION['error'] = "Please select product photo.";
            $redirect;
        }
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} elseif (isset($_POST['update-product']) && !empty($_POST['csrf_token'])) {
    if ($_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $pid = $_POST['product_id'];

        $category_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $prize = filter_input(INPUT_POST, 'prize', FILTER_SANITIZE_NUMBER_INT);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
        $shipping = filter_input(INPUT_POST, 'shipping', FILTER_SANITIZE_NUMBER_INT);
        $products->addLogs($logged_id, "Products - Edit product record.");
        $products->updateProduct($pid, $category_id, $name, $description, $prize, $stock, $shipping);
        $redirect;
    } else {
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
} else {
    $_SESSION['error'] = "Invalid Request";
    $redirect;
}
