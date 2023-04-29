<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo 'You must be logged in to submit a comment.';
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'ecommerce');

    if (!$conn) {
        echo 'Error connecting to the database.';
        exit;
    }

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
