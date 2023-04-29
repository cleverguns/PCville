<?php
session_start();
require_once("../../wp-includes/autoLoader.php");
require_once("../../wp-includes/utils.php");

$logged_id = $_SESSION['user_token'];
$redirect = header("Location: ../dashboard/category.php");

if(isset($_POST['add-category']) && !empty($_POST['csrf_token'])){
    $name = $_POST['name'];
    $category_id = "cid_". generate_number(11);
    if($_POST['csrf_token'] === $_SESSION['csrf_token']){
        $category->addLogs($logged_id, "Category - Added new category record.");
        $category->addCategory($category_id, $name);
        $redirect;
    }else{
        $_SESSION['error'] = "Invalid Request";
    }
}elseif(isset($_GET['cid']) && !empty($_GET['_token'])){
    if($_GET['_token'] === $_SESSION['csrf_token']){
        $category->addLogs($logged_id, "Category - Deleted category record.");
        $category->deleteCategory($_GET['cid']);
        $redirect;
    }else{
        $_SESSION['error'] = "Invalid Request";
        $redirect;
    }
}elseif(isset($_POST['update-category']) && !empty($_POST['csrf_token'])){
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    if($_POST['csrf_token'] === $_SESSION['csrf_token']){
        $category->addLogs($logged_id, "Category - Edited category record.");
        $category->updateCategory($category_id, $name);
        $redirect;
    }else{
        $_SESSION['error'] = "Invalid Request";
    }
}else{
    $_SESSION['error'] = "Invalid Request"; 
    header("Location: ../dashboard/category.php");
}
?>