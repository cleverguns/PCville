<?php
// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "cn_ecommerce";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
$product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
$comment = mysqli_real_escape_string($conn, $_POST['comment']);
$image = "";

// Handle image upload (if provided)
if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES['image']['name']);
  move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
  $image = $target_file;
}

// Insert comment into database
$sql = "INSERT INTO comments (user_id, product_id, comment, image) VALUES ('$user_id', '$product_id', '$comment', '$image')";
if (mysqli_query($conn, $sql)) {
  echo "Comment submitted successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
