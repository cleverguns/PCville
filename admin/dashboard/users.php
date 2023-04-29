<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PC Village | Users</title>
  <!-- Header Includes -->
  <?php require_once("headers.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <?php require_once("navbar.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-1">
      <!-- Brand Logo -->
      <?php require_once("logo.php"); ?>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-2">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-header">Administrator</li>
            <li class="nav-item">
              <a href="/" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="users.php" class="nav-link bg-gradient-primary active">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="billings.php" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Billings
                </p>
              </a>
            </li>
            <li class="nav-header">Products</li>
            <li class="nav-item">
              <a href="products.php" class="nav-link">
                <i class="nav-icon fa fa-box"></i>
                <p>
                  Products
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="category.php" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                <p>
                  Category
                </p>
              </a>
            </li>
            <li class="nav-header">Analytics</li>
            <li class="nav-item">
              <a href="order.php" class="nav-link">
                <i class="nav-icon fa fa-shopping-cart"></i>
                <p>
                  Orders
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="payment.php" class="nav-link">
                <i class="nav-icon fa fa-money-bill-alt"></i>
                <p>
                  Payments Record
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="logs.php" class="nav-link">
                <i class="nav-icon fas fa-history"></i>
                <p>
                  Logs
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Users</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#add-user"><i class="fa fa-plus-circle"></i> - Add User</button>
                </div>
                <div class="card-body table-responsive">
                  <table id="table" class="table table-bordered table-striped text-center">
                    <thead>
                      <tr>
                        <th style="white-space: nowrap;">#</th>
                        <th style="white-space: nowrap;">Profile</th>
                        <th style="white-space: nowrap;">First Name</th>
                        <th style="white-space: nowrap;">Last Name</th>
                        <th style="white-space: nowrap;">Username</th>
                        <th style="white-space: nowrap;">Email</th>
                        <th style="white-space: nowrap;">Role</th>
                        <th style="white-space: nowrap;">Tools</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $user_query = $conn->query("SELECT * FROM tbl_users WHERE NOT user_id = '{$user_id}' AND NOT user_role = 'administrator'");
                      $counter = 0;
                      foreach ($user_query as $row) {
                        echo ('
                        <tr>
                          <td style="white-space: nowrap;">' . ++$counter . '</td>
                          <td style="white-space: nowrap;">
                            <button data-image="' . $row['avatar'] . '" data-id="' . $row['user_id'] . '" class="bg-transparent position-relative border-0 btn-photo">
                              <i class="position-absolute p-2 text-primary fas fa-edit" style="border-radius: 50px; left: 50% !important; transform: translate(-50%, -50%) !important; top: 50% !important;"></i>
                              <img src="../../wp-images/users/' . $row['avatar'] . '" class="img-circle border" style="width: 50px; height:50px;" alt="user-photo">
                            </button>
                            </td>
                          <td style="white-space: nowrap;">' . $row['fname'] . '</td>
                          <td style="white-space: nowrap;">' . $row['lname'] . '</td>
                          <td style="white-space: nowrap;">' . $row['username'] . '</td>
                          <td style="white-space: nowrap;">' . $row['email'] . '</td>
                          <td style="white-space: nowrap;">' . $row['user_role'] . '</td>
                          <td style="white-space: nowrap;">
                            <button data-id="' . $row['user_id'] . '" class="btn btn-success mr-2 btn-edit"><i class="fa fa-edit"></i> - Edit</button>
                            <button data-id="' . $row['user_id'] . '" class="btn btn-danger btn-delete"><i class="fa fa-trash-alt"></i> - Delete</button>
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
          </div>
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="add-user" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Account</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form class="frm-add" action="../wp-actions/user.php" enctype="multipart/form-data" method="post">
            <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
            <div class="modal-body">
              <div class="form-group">
                <label for="avatar">Avatar</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" name="avatar" class="custom-file-input" id="avatar">
                    <label class="custom-file-label" for="avatar">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" name="fname" required />
              </div>
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" name="lname" required />
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" required />
              </div>
              <div class="form-group">
                <label for="user_role">User Role</label>
                <select name="user_role" class="form-control">
                  <option value="rider">Rider</option>
                  <option value="co-admin">Co-Admin</option>
                  <option value="administrator">Administrator</option>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button class="btn btn-danger" data-dismiss="modal">Close</button>
              <button name="add-user" class="btn btn-primary" type="submit">Save</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="edit-user" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Account</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form class="frm-edit" action="../wp-actions/user.php" method="post">
            <div class="modal-body">
              <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
              <input type="text" name="user_id" style="display: none;" class="user_id" hidden>

              <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control fname" name="fname" required />
              </div>
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control lname" name="lname" required />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control email" name="email" required />
              </div>
              <div class="form-group">
                <label for="user_role">User Role</label>
                <select name="user_role" class="form-control user_role">
                  <option value="rider">Rider</option>
                  <option value="co-admin">Co-Admin</option>
                  <option value="administrator">Administrator</option>
                </select>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cpassword">Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" required />
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

    <div class="modal fade" id="edit-photo" style="display: none;" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Upload Photo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="../wp-actions/user.php" enctype="multipart/form-data" method="post">
            <div class="modal-body">
              <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
              <input type="text" name="uid" id="user_id" hidden>
              <div class="text-center">
                <img class="border-0 img-fluid img-responsive img-preview" style="height: 150px;" alt="user-profile">
              </div>
              <div class="form-group">
                <label for="avatar">Photo</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" name="avatar" class="custom-file-input" id="avatar2">
                    <label class="custom-file-label" for="avatar2">Choose file</label>
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

    <?php require_once("footer.php") ?>
  </div>
  <!-- ./wrapper -->

  <?php require_once("scripts.php") ?>
  <script>
    $(".frm-add").validate({
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
    });

    $(".frm-edit").validate({
      rules: {
        password: {
          required: false,
        },
        cpassword: {
          required: false,
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
    });

    $(document).on('click', '.btn-delete', function(e) {
      e.preventDefault();
      let id = $(this).data("id");
      let token = "<?= $_SESSION['csrf_token'] ?>";
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Success!',
            text: "Successfully Deleted!",
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          })
          setTimeout(function() {
            window.location.href = `../wp-actions/user.php?uid=${id}&_token=${token}`;
          }, 1500);
        }
      })
    });

    $(document).on('click', '.btn-edit', function() {
      let token = "<?= $_SESSION['csrf_token'] ?>";
      let UserId = $(this).data("id");
      $.ajax({
        url: "../wp-actions/getUserInfo.php",
        method: "POST",
        data: {
          UserId: UserId,
          csrf_token: token
        },
        dataType: "json",
        success: function(data) {
          if (data == "error") {
            console.error("Something went wrong");
          } else {
            $(".user_id").val(UserId);
            $(".fname").val(data.fname);
            $(".lname").val(data.lname);
            $(".email").val(data.email);
            $('.user_role').val(data.user_role);
            $("#edit-user").modal('show');
          }
        }
      });
    });

    $(document).on('click', '.btn-photo', function() {
      let user_id = $(this).data("id"),
        image = $(this).data("image");
      $("#edit-photo").modal('show');
      $(".img-preview").attr("src", "../../wp-images/users/" + image)
      $("#user_id").val(user_id);
    });
  </script>
</body>

</html>