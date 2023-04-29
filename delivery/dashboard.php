<?php
include_once("../wp-includes/session.php");
require_once("../wp-includes/autoLoader.php");

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

if ($_SESSION['role'] != "rider") {
  header("Location: ../../");
}
?>

<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PCVILLAGE | Rider</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../wp-plugins/fontawesome-free/css/all.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="../wp-plugins/dist/css/adminlte.min.css" />
  <!-- Sweet Alert 2-->
  <script src="../wp-plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="../wp-plugins/sweetalert2/sweetalert2.min.css" />
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <a href="/delivery/" class="brand-link">
          <img src="../wp-images/favicon.jpg" alt="Logo" class="brand-image img-circle" />
          <span class="brand-text font-weight-light">PC Village</span>
        </a>


        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <li class="nav-item dropdown user-small">
            <a class="nav-link user-panel d-flex align-items-center" data-toggle="dropdown" href="#">
              <img src="../../wp-images/users/<?= $avatar ?>" class="img-circle mr-2" alt="User Image" style="width: 35px; height: 35px" />
              <span class="text-gray"><?= $user_name ?></span>
            </a>

            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
              <button class="dropdown-item" data-toggle="modal" data-target="#user-settings">
                <i class="fas fa-cog mr-2"></i>Settings
              </button>
              <button class="dropdown-item" data-toggle="modal" data-target="#change-profile">
                <i class="fas fa-image mr-2"></i>Change Profile
              </button>
              <div class="dropdown-divider"></div>
              <a href="../../wp-includes/logout.php" class="dropdown-item btn-danger">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
              </a>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container">
          <div class="row m-auto">
            <div class="col-lg-8 m-auto">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="delivery_id">Parcel ID</label>
                    <div class="input-group">
                      <input type="text" name="delivery_id" class="parcel-id form-control" />
                      <span class="input-group-append">
                        <button type="button" class="search-parcel btn btn-primary"><i class="fas fa-search"></i> Search</button>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-container d-none">
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h5 class="card-title">Parcel Record</h5>
                  </div>
                  <div class="card-body">
                    <div class="row justify-content-between px-2">
                      <h5>Parcel ID</h5>
                      <h5 class="parcel_id"></h5>
                    </div>
                    <div class="row justify-content-between px-2">
                      <h5 class="card-text">Name</h5>
                      <h5 class="name"></h5>
                    </div>
                    <div class="row justify-content-between px-2">
                      <h5 class="card-text">Contact</h5>
                      <h5 class="contact"></h5>
                    </div>
                    <div class="row justify-content-between px-2">
                      <h5 class="card-text">Address</h5>
                      <h5 class="address"></h5>
                    </div>
                    <div class="row justify-content-between px-2">
                      <h5 class="card-text">Additional Address</h5>
                      <h5 class="additional_address"></h5>
                    </div>
                    <form class="mt-2 border-top pt-2" enctype="multipart/form-data" method="post" action="wp-actions/updateParcelRecord.php">
                      <input type="text" name="delivery_id" class="delivery_id" hidden />
                      <input type="text" name="user_id" value="<?= $user_id ?>" hidden />
                      <div class="form-group">
                        <label for="proof">Upload Proof of Delivery</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="proof" class="custom-file-input" accept="image/*" id="proof" require>
                            <label class="custom-file-label" for="proof">Choose file</label>
                          </div>
                        </div>
                      </div>
                      <button type="submit" name="parcel-deliver" class="btn btn-primary">Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

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
              <img class="border-0 img-fluid img-responsive img-preview" src="../wp-images/users/<?= $avatar ?>" style="height: 150px;" alt="user-profile">
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


  <?php
    require_once("../wp-includes/response.php");
  ?>

  <!-- jQuery -->
  <script src="../wp-plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../wp-plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../wp-plugins/dist/js/adminlte.min.js"></script>
  <script src="../wp-plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

  <script>
    $(function() {
      bsCustomFileInput.init();
    });

    $(document).on("click", ".search-parcel", function(e) {
      let parcel_id = $(".parcel-id").val();
      e.preventDefault();
      $.ajax({
        url: "wp-actions/getParcelRecord.php",
        method: "POST",
        data: {
          getParcel: "parcel",
          parcel_id: parcel_id,
        },
        dataType: "json",
        success: function(data) {
          console.log(data);
          $(".card-container").removeClass("d-none");
          $(".card-container").removeClass("d-block");

          $(".parcel_id").text(data.delivery_id);
          $(".name").text(data.fname + ' ' + data.lname);
          $(".contact").text(data.contact);
          $(".address").text(data.address_1 + ', ' + data.address_2);
          $(".additional_address").text(data.additional_address);
          $(".delivery_id").val(data.delivery_id);
          /*
          $(".card-container").empty();
          $(".card-container").append('\
              <div class="card card-outline card-primary">\
                <div class="card-header">\
                  <h5 class="card-title">Parcel Record</h5>\
                </div>\
                <div class="card-body">\
                  <div class="row justify-content-between px-2">\
                    <h5>Parcel ID</h5>\
                    <h5>' + data.delivery_id + '</h5>\
                  </div>\
                  <div class="row justify-content-between px-2">\
                    <h5 class="card-text">Name</h5>\
                    <h5>' + data.fname + ',' + data.lname + '</h5>\
                  </div>\
                  <div class="row justify-content-between px-2">\
                    <h5 class="card-text">Contact</h5>\
                    <h5>' + data.contact + '</h5>\
                  </div>\
                  <div class="row justify-content-between px-2">\
                    <h5 class="card-text">Address</h5>\
                    <h5>' + data.address_1 + ',' + data.address_2 + '</h5>\
                  </div>\
                  <div class="row justify-content-between px-2">\
                    <h5 class="card-text">Additional Address</h5>\
                    <h5>' + data.additional_address + '</h5>\
                  </div>\
                  <form class="mt-2 border-top pt-2" enctype="multipart/form-data" method="post" action="wp-actions/updateParcelRecord.php">\
                    <input type="text" name="delivery_id" value="' + data.delivery_id + '" />\
                    <input type="text" name="user_id" value="<?= $user_id ?>" />\
                    <div class="form-group">\
                      <label for="proof">Upload Proof of Delivery</label>\
                      <div class="input-group">\
                        <div class="custom-file">\
                          <input type="file" name="proof" class="custom-file-input" accept="image/*" id="proof">\
                          <label class="custom-file-label" for="proof">Choose file</label>\
                        </div>\
                      </div>\
                    </div>\
                    <button type="submit" name="parcel-deliver" class="btn btn-primary">Save</button>\
                  </form>\
                </div>\
              </div>\
            ');
            */
        }
      });

    });
  </script>
</body>

</html>