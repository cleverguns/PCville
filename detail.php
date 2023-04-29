<?php
// Start session
session_start();

// Include database config file
include 'config.php';

// Check if the product id is set in the URL
if(isset($_GET['id'])){
    $product_id = $_GET['id'];
    
    // Get product details from the database
    $query = "SELECT * FROM tbl_products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['name'];
        $product_image = $row['image'];
        $product_price = $row['price'];
        $product_desc = $row['description'];
    }else{
        // Redirect to home page if product is not found
        header('Location: index.php');
        exit();
    }
}else{
    // Redirect to home page if product id is not set
    header('Location: index.php');
    exit();
}

// Get comments from the database
$query = "SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE product_id = $product_id";
$comments_result = mysqli_query($conn, $query);

// Handle comment submission
if(isset($_POST['submit_comment'])){
    // Get input data
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_type = $_FILES['image']['type'];
    $image_error = $_FILES['image']['error'];

    // Check if image file is uploaded
    if($image_name != ''){
        $upload_dir = 'uploads/';
        $file_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $file_name;

        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if(!in_array(strtolower($file_extension), $allowed_types)){
            $error_msg = 'Invalid file type. Only JPG, JPEG, PNG and GIF files are allowed.';
        }elseif($image_size > 5000000){ // Check file size
            $error_msg = 'File size exceeded. Maximum allowed file size is 5MB.';
        }elseif($image_error != 0){ // Check for errors
            $error_msg = 'An error occurred while uploading the file.';
        }elseif(move_uploaded_file($image_tmp_name, $upload_path)){ // Upload file
            // Insert comment data into database
            $query = "INSERT INTO comments (user_id, product_id, comment, image) VALUES ('$user_id', '$product_id', '$comment', '$file_name')";
            $result = mysqli_query($conn, $query);

            if($result){
                // Redirect to product detail page
                header("Location: detail.php?id=$product_id");
                exit();
            }else{
                $error_msg = 'An error occurred while submitting your comment.';
            }
        }
    }else{ // If no image is uploaded
        // Insert comment data into database
        $query = "INSERT INTO comments (user_id, product_id, comment) VALUES ('$user_id', '$product_id', '$comment')";
        $result = mysqli_query($conn, $query);

    // Get the user id and product id from the form data
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $comment = $_POST['comment'];
    
    // Upload the image file
    $image_file = $_FILES['image_file'];
    $upload_dir = 'uploads/';
    $target_file = $upload_dir . basename($image_file['name']);
    $upload_success = move_uploaded_file($image_file['tmp_name'], $target_file);
    
    if (!$upload_success) {
        echo 'Error uploading image file.';
        exit;
    }
    
    // Insert the comment data into the comments table
    $insert_query = "INSERT INTO comments (user_id, product_id, comment, image) VALUES ('$user_id', '$product_id', '$comment', '$target_file')";
    $insert_result = mysqli_query($conn, $insert_query);
    
    if (!$insert_result) {
        echo 'Error inserting comment data into database.';
        exit;
    }
    
    // Redirect the user back to the detail page
    header("Location: detail.php?id=$product_id");
}
