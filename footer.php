<!-- Footer Start -->
<div class="container-fluid bg-light-blue text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-2 mr-1">PC</span>Village</h1>
            </a>
            <p>Computer and CCTV</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>MacArthur Highway, ASM Plaza Bldg, Ground Floor. Caniogan, Calumpit, Bulacan Landmark in front of Colegio de Calumpit Shop hours 8 AM - 5 PM.</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@pcvillage.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+639053687936 &bullet; +639224869516</p>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">

        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">PC Village</a>. All Rights Reserved.
                Designed
                by
                <a class="text-dark font-weight-semi-bold" href="https://namcodes.com">PC Village Team</a><br>
                Distributed By <a href="https://facebook.com" target="_blank">PC Village</a>
            </p>
        </div>

    </div>
</div>
<!-- Footer End -->

<!-- Change Profile -->
<div class="modal fade" id="change-profile" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload Photo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="wp-actions/user.php" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                    <input type="text" name="uid" value="<?= $user_id ?>" hidden>
                    <div class="text-center">
                        <img class="border-0 img-fluid img-responsive img-preview" src="wp-images/users/<?= $avatar ?>" style="height: 150px;" alt="user-profile">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Photo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar3">
                                <label class="custom-file-label" for="avatar3">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button name="edit-photo" class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Search Product -->
<div class="modal fade" id="search-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Search Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive mx-10 w-auto">
                    <table id="table" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">Photo</th>
                                <th style="white-space: nowrap;">Name</th>
                                <th style="white-space: nowrap;">Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product = $conn->query("SELECT * FROM tbl_products WHERE stock > 0");
                            foreach ($product as $row) {
                                if (isset($user_id)) {
                                    $cart_query = $conn->query("SELECT product_id FROM tbl_carts WHERE user_id = '{$user_id}' AND product_id = '{$row['product_id']}'");

                                    if ($cart_query->num_rows > 0) {
                                        $btn_cart = '
                                                    <button data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="w-100 btn btn-sm btn-danger float-right remove-cart"><i
                                                                    class="fas fa-times mr-1"></i>Remove Cart</button>';
                                    } else {
                                        $btn_cart = '
                                                    <button data-price="' . $row['prize'] . '" data-user="' . $user_id . '" data-id="' . $row['product_id'] . '" class="w-100 btn btn-sm btn-primary float-right add-cart"><i class="fas fa-shopping-cart mr-1"></i>Add to Cart</button>
                                                    ';
                                    }
                                } else {
                                    $btn_cart = '
                                                    <a href="#login" data-toggle="modal" data-target="#user-login" class="w-100 btn btn-sm btn-primary float-right"><i class="fas fa-shopping-cart mr-1"></i>Add To Cart</a>
                                                    ';
                                }
                                echo ('
                                    <tr>
                                        <td style="white-space: nowrap;">
                                            <img src="../../wp-images/products/' . $row['product_photo'] . '" class="text-center border" style="width: 50px; height: 50px;" alt="product-photo">
                                        </td>
                                        <td style="white-space: nowrap;">' . $row['name'] . '</td>
                                        <td style="white-space: nowrap;">
                                            <a href="detail.php?_token=' . $_SESSION['csrf_token'] . '&product_id=' . $row['product_id'] . '" class="w-100 btn btn-sm btn-secondary"><i class="fas fa-eye mr-1"></i>View Detail</a>
                                        </td>
                                    </tr>
                                    ');
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Personal Settings -->
<div class="modal fade" id="user-settings" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Settings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="frm-info" action="wp-actions/user.php" method="post">
                <div class="modal-body">
                    <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                    <input type="text" name="user_id" style="display: none;" value="<?= $user_id ?>" hidden>

                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" name="fname" value="<?= $first_name ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" name="lname" value="<?= $last_name ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" name="email" value="<?= $p_email ?>" required />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="dt-password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" class="form-control" name="cpassword" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button name="update-user" class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Notification -->
<div class="modal fade" id="user-notification" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notification</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="table-reponsive"style="height: 390px; overflow-y: scroll;">
                    <table id="table" class="table table-bordered table-striped text-center">
                     
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">#</th>
                                <th style="white-space: nowrap;">Order ID</th>
                                <th style="white-space: nowrap;">Status</th>
                                <th style="white-space: nowrap;">Date Order</th>
                                <th style="white-space: nowrap;">Tools</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        //$date_insert = date('Y-m-d H:i:s');

                        $tbl_shipping = $conn->query("SELECT status, date_shipping, delivery_id FROM tbl_shipping WHERE user_id = '{$user_id}' ORDER BY _id DESC");

                        
                        $date = date_create();
                        $formatted_date = date_format($date, 'Y • F • d • g:i A');

                        $counter = 0;
                        foreach($tbl_shipping as $row){
                            $date_format = date_create($row['date_shipping']);
                            $formatted_date = date_format($date_format, 'Y • F • d • g:i A');
                            switch($row['status']){
                                case 'order-placed':{
                                    $status = "Order Placed";
                                    break;
                                }

                                case 'parcel-ship':{
                                    $status = "Parcel Shipped";
                                    break;
                                }

                                case 'parcel-transit':{
                                    $status = "Parcel is in Transit";
                                    break;
                                }

                                case 'parcel-delivered':{
                                    $status = "Parcel Delivered";
                                    break;
                                }

                                case 'cancel-order':{
                                    $status = "Cancelled Order";
                                    break;
                                }
                            }

                            $d_id = $row['delivery_id'];
                            $delivery_id = preg_replace('/[#]/', '', $d_id);

                            echo('
                            <tr>
                                <td>'. ++$counter .'</td>
                                <td class="text-left">'.$row['delivery_id'].'</td>
                                <td><b>'. $status.'</b></td>
                                <td>'. $formatted_date .'</td>
                                <td>
                                    <a href="view-parcel.php?_token='.$_SESSION['csrf_token'].'&_key='.$delivery_id.'" class="btn btn-primary"><i class="fa fa-eye"></i> View Details</a>
                                </td>
                            </tr>
                            ');
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $("#table").DataTable();
    $("#table-search").DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
    });
    // Add a custom regex validation rule
    $.validator.addMethod(
        "customRegex",
        function(value, element, regexp) {
            return this.optional(element) || regexp.test(value);
        },
        "Please enter a valid value."
    );

    $.validator.addMethod("allowedEmailDomain", function(value, element) {
        // List of allowed domains
        var allowedDomains = ["gmail.com", "yahoo.com", "outlook.com"];
        // Get the email domain
        var domain = value.split('@')[1];
        // Check if the domain is in the allowed list
        return allowedDomains.indexOf(domain) !== -1;
    }, "Please enter a valid email address with Gmail, Yahoo or Outlook.");

    $(".frm-info").validate({
        rules: {
            fname: {
                required: true,
                customRegex: /^[a-zA-Z ]+$/
            },
            lname: {
                required: true,
                customRegex: /^[a-zA-Z ]+$/
            },
            email: {
                required: true,
                email: true,
                allowedEmailDomain: true
            },
            password: {
                minlength: 8,
                customRegex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.*[^\s]).{8,20}$/
            },
            cpassword: {
                minlength: 8,
                equalTo: "#dt-password"
            },
        },
        messages: {
            fname: {
                required: "*Required.",
                customRegex: "Please enter only letters."
            },
            lname: {
                required: "*Required.",
                customRegex: "Please enter only letters."
            },
            email: {
                required: "*Required.",
            },
            password: {
                customRegex: "Your password must contain at least 1 uppercase, 1 lowercase letter, 1 number, and 1 special character."
            },
            cpassword: {
                equalTo: "Passwords do not match"
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
    });
</script>