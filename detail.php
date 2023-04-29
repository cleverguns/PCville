<?php
require_once("wp-includes/config.php");
require_once("wp-includes/session.php");

if (isset($_GET['_token']) && isset($_GET['product_id'])) {
    if ($_GET['_token'] === $_SESSION['csrf_token']) {
        $product_id = htmlspecialchars($_GET['product_id']);
        $product_query = $conn->query("SELECT * FROM tbl_products WHERE product_id = '{$product_id}' LIMIT 1");

        if ($product_query->num_rows > 0) {
            $product_row = $product_query->fetch_assoc();
        } else {
            header("Location: ../index.php");
        }
    } else {
        header("Location: ../");
    }
} else {
    header("Location: ../");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PC-Village - Details</title>
    <?php
    include_once("headers.php");
    ?>
</head>

<body>

    <!-- Navbar Start -->
    <?php require_once("navbar.php") ?>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <img class="w-100 img-fluid" style="height: 350px;" src="wp-images/products/<?= $product_row['product_photo'] ?>" alt="product-image">
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="text-xl"><?= $product_row['name']; ?></h3>
                <p class="mb-4"><?= $product_row['description']; ?></p>
                <div class="mb-3">
                    <h4 class="text-dark text-lg mb-0 mr-3">Shipping Fee : <?= $product_row['shipping'] ?></h4>
                    <h4 class="text-dark text-lg mb-0 mr-3">Stocks : <?= $product_row['stock'] ?></h4>
                    <h4 class="text-dark text-lg mb-0 mr-3">Prize : ₱ <?= number_format($product_row['prize']) ?></h4>
                </div>

                <div class="mb-4 pt-2">
                    <div class="d-flex">
                        <p>Quantity </p>
                        <div class="d-flex justify-content-center mx-4" style="width: 100px; height: 10px;">
                            <div class="input-group quantity">
                                <div class="input-group-prepend">
                                    <button class="btn btn-sm btn-outline-secondary bg-none btn-minus" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <?php
                                if (isset($user_id)) {
                                    $getRecord = $conn->query("SELECT qty FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$product_id}' LIMIT 1");
                                    if ($getRecord->num_rows > 0) {
                                        $fetchRecord = $getRecord->fetch_assoc();
                                        $qtyTotal = $fetchRecord['qty'];
                                    } else {
                                        $qtyTotal = 1;
                                    }
                                } else {
                                    $qtyTotal = 1;
                                }

                                ?>
                                <input type="text" class="product-qty form-control form-control-sm text-center" style="width: 10px !important;" value="<?= $qtyTotal ?>" disabled>
                                <div class="input-group-append">
                                    <button data-max="<?= $product_row['stock'] ?>" class="btn btn-sm btn-outline-primary bg-none btn-plus" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($user_id)) {
                        echo ('
                        <button data-product="' . $product_row['product_id'] . '" data-price="' . $product_row['prize'] . '" data-qty="1" class="btn btn-primary px-3 btn-add-cart"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                        ');
                    } else {
                        echo ('
                        <a href="#login" data-toggle="modal" data-target="#user-login" class="btn btn-primary px-3"><i class="fas fa-shopping-cart mr-1"></i>Add To Cart</a>
                        ');
                    }
                    ?>

                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on :</p>
                    <div class="d-inline-flex" style="gap: 10px;">
                        <a class="px-3 badge badge-primary p-2 text-white" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="px-3 badge badge-info text-white p-2" href="" role="button" style="background-color: #55acee;">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="px-3 p-2 badge badge-primary text-white" href="" role="button" style="background-color: #0082ca;">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="px-3 p-2 badge badge-danger text-white" href="" role="button" style="background-color: #c61118;">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <?php
  session_start();
  include('config.php');

  // get product details
 /*
  $product_id = $_GET['id'];
  $query = "SELECT * FROM products WHERE id='$product_id'";
  $result = mysqli_query($conn, $query);
*/
  // get product details
$product_id = $_GET['id'];
$query = "SELECT * FROM products WHERE id='$product_id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
$product_name = $product['name'];

  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $product_name = $row['name'];
      $product_desc = $row['description'];
      $product_price = $row['price'];
      $product_image = $row['image'];
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $product_name; ?> - PCville</title>
</head>
<body>

  <h1><?php echo $product_name; ?></h1>
  <p><?php echo $product_desc; ?></p>
  <p><strong>Price:</strong> $<?php echo $product_price; ?></p>
  <img src="<?php echo $product_image; ?>" width="300">

  <hr>

  <!-- display comments -->
  <?php
    $query = "SELECT * FROM comments WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "<p><strong>" . $row['user_id'] . ":</strong> " . $row['comment'] . "</p>";
      }
    } else {
      echo "<p>No comments yet.</p>";
    }
  ?>

  <!-- add comment form -->
  

  <?php
include('navbar.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM tbl_products WHERE product_id = '$product_id'";
    $result = mysqli_query($con, $query);
    if (!$result) {
        die('Error: ' . mysqli_error($con));
    }
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_description = $row['product_description'];
        $product_image = $row['product_image'];
    } else {
        echo "No product found.";
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="images/<?php echo $product_image; ?>" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-md-6">
            <h2><?php echo $product_name; ?></h2>
            <h4>Price: <?php echo $product_price; ?></h4>
            <p><?php echo $product_description; ?></p>
        </div>
    </div>
</div>

<!-- add comment form -->
<h2>Add a comment</h2>
<form action="add_comment.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="photo">Upload a photo</label>
        <input type="file" class="form-control-file" id="photo" name="photo">
    </div>
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php include('footer.php'); ?>



<!-- end -->
    <!-- Products Start -->
    <div class="container-fluid py-5 border-top">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php

            $product = $conn->query("SELECT * FROM tbl_products WHERE stock > 0 AND NOT product_id = '{$product_id}'");
            foreach ($product as $row) {
                if (isset($user_id)) {
                    $cart_query = $conn->query("SELECT product_id FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$row['product_id']}'");

                    if ($cart_query->num_rows > 0) {
                        $btn_cart = '
                    <button data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="btn btn-sm btn-danger float-right remove-cart"><i
                                    class="fas fa-times mr-1"></i>Remove to cart</button>';
                    } else {
                        $btn_cart = '
                    <button data-price="' . $row['prize'] . '" data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="btn btn-sm btn-primary float-right add-cart"><i class="fas fa-shopping-cart mr-1"></i>Add To Cart</button>
                    ';
                    }
                } else {
                    $btn_cart = '
                    <a href="#login" data-toggle="modal" data-target="#user-login" class="btn btn-sm btn-primary float-right"><i class="fas fa-shopping-cart mr-1"></i>Add To Cart</a>
                    ';
                }
                echo ('
                <div class="col-lg-3 col-md-4 pb-1">
                    <div class="card product-item border-0 mb-4 rounded">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent p-0">
                            <img class="img-fluid w-100 bg-transparent" style="height: 230px;" src="wp-images/products/' . $row['product_photo'] . '" alt="">
                        </div>
                        <div class="card-body text-center px-2">
                            <h6 class="text-truncate mb-2 font-weight-semi-bold">' . $row['name'] . '</h6>
                            <div class="text-center">
                                <h6>₱ ' . $row['prize'] . '</h6>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="detail.php?_token=' . $_SESSION['csrf_token'] . '&product_id=' . $row['product_id'] . '" class="btn btn-sm btn-secondary"><i class="fas fa-eye mr-1"></i>View Detail</a>
                            
                           ' . $btn_cart . '
                        </div>
                    </div>
                 </div>
                ');
            }
            ?>

        </div>
    </div>
    <!-- Products End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php
    require_once("scripts.php");
    require_once("wp-includes/response.php");
    if (!isset($user_id)) {
        require_once("modal.php");
    }
    require_once("footer.php");
    ?>

    <script>
        $(document).ready(function() {
            $('.quantity button').on('click', function() {
                var button = $(this);
                var oldValue = button.parent().parent().find('input').val();
                if (button.hasClass('btn-plus')) {
                    let max = $(this).data("max");
                    if (oldValue == max) {
                        console.error("Reached Max Quantity");
                        var newVal = max;
                    } else {
                        var newVal = parseFloat(oldValue) + 1;
                    }
                } else {
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                    }
                }
                $(".btn-add-cart").attr("data-qty", newVal);
                button.parent().parent().find('input').val(newVal);
            });

            $('.btn-add-cart').click(function() {
                let quantity = $(this).data("qty");
                let product = $(this).data("product");
                let price = $(this).data("price");
                console.log(quantity);
                $.ajax({
                    url: 'wp-actions/verifyCart.php', // URL to send the request to
                    method: 'POST', // HTTP method to use (e.g. POST or GET)
                    data: {
                        updateCart: '<?= $_SESSION['csrf_token'] ?>',
                        product_id: product,
                        quantity: quantity,
                        price: price,
                    }, // Data to send to the server
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>

</html>
