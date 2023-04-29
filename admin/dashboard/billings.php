<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PC Village | Category</title>

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
              <a href="users.php" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Users
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="billings.php" class="nav-link bg-gradient-primary active">
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
              <h1 class="m-0">Billings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Billings</li>
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
                  <button class="btn btn-primary" data-toggle="modal" data-target="#add-billing"><i class="fa fa-plus-circle"></i> - Add Billing</button>
                </div>
                <div class="card-body table-responsive">
                  <table id="table" class="table table-bordered table-striped text-center">
                    <thead>
                      <tr>
                        <th style="white-space: nowrap;">#</th>
                        <th style="white-space: nowrap;">Full Name</th>
                        <th style="white-space: nowrap;">Contacts</th>
                        <th style="white-space: nowrap;">Email</th>
                        <th style="white-space: nowrap;">Province</th>
                        <th style="white-space: nowrap;">City</th>
                        <th style="white-space: nowrap;">Baranggay</th>
                        <th style="white-space: nowrap;">Additional Address</th>
                        <th style="white-space: nowrap;">Postal Code</th>
                        <th style="white-space: nowrap;">Tools</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $tbl_billings = $conn->query("SELECT * FROM tbl_billings");
                      $counter = 0;
                      foreach ($tbl_billings as $row) {
                        echo ('
                      <tr>
                        <td style="white-space: nowrap;">' . ++$counter . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['fname'] . ' ' . $row['lname'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['contact'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['email'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['province'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['address_1'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['address_2'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['additional_address'] . '</td>
                        <td style="white-space: nowrap;" class="text-left">' . $row['postal_code'] . '</td>
                        <td style="white-space: nowrap;">
                          <button data-id="' . $row['billing_id'] . '" class="btn btn-success mr-2 btn-edit"><i class="fa fa-edit"></i> - Edit</button>
                          <button data-id="' . $row['billing_id'] . '" class="btn btn-danger btn-delete"><i class="fa fa-trash-alt"></i> - Delete</button>
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

    <!-- Main Footer -->
    <?php require_once("footer.php") ?>
  </div>
  <!-- ./wrapper -->

  <div class="modal fade" id="add-billing" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Billing</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="frm-add" action="../wp-actions/billings.php" method="post">
          <div class="modal-body">
            <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
            <div class="form-group">
              <label for="user_id">User</label>
              <select name="user_id" class="form-control" required>
                <option value="">SELECT User</option>
                <?php
                $tbl_user = $conn->query("SELECT user_id, fname, lname FROM tbl_users WHERE NOT user_id = '{$user_id}'");
                foreach ($tbl_user as $row) {
                  echo ('
                <option value="' . $row['user_id'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</option>
                ');
                }
                ?>

              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control" name="fname" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" class="form-control" name="lname" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="text" class="form-control" name="email" />
            </div>
            <div class="form-group">
              <label for="province">Province</label>
              <input type="text" class="form-control" name="province" />
            </div>
            <div class="form-group">
              <label for="contact">Contact</label>
              <input type="text" class="form-control" name="contact" />
            </div>
            <div class="form-group">
              <label for="address_1">City</label>
              <input type="text" class="form-control" name="address_1" />
            </div>
            <div class="form-group">
              <label for="address_2">Baranggay</label>
              <input type="text" class="form-control" name="address_2" />
            </div>
            <div class="form-group">
              <label for="postal_code">Postal Code</label>
              <input type="text" class="form-control" name="postal_code" />
            </div>
            <div class="form-group">
              <label for="additional_address">Additional Address</label>
              <textarea type="text" class="form-control" name="additional_address" style="resize: none;" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-danger" data-dismiss="modal">Close</button>
            <button name="add-billing" class="btn btn-primary" type="submit">Save</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <div class="modal fade" id="edit-billing" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Billing</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form class="frm-add" action="../wp-actions/billings.php" method="post">
          <div class="modal-body">
            <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
            <input type="text" name="billing_id" class="billing_id" hidden>
            <div class="form-group">
              <label for="user_id">User</label>
              <select name="user_id" class="form-control user_id" required>
                <option value="">SELECT User</option>
                <?php
                $tbl_user = $conn->query("SELECT user_id, fname, lname FROM tbl_users WHERE user_id = '{$user_id}'");
                foreach ($tbl_user as $row) {
                  echo ('
                <option value="' . $row['user_id'] . '">' . $row['fname'] . ' ' . $row['lname'] . '</option>
                ');
                }
                ?>

              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" class="form-control fname" name="fname" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" class="form-control fname" name="lname" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="contact">Contact</label>
              <input type="text" class="form-control contact" name="contact" />
            </div>
            <div class="form-group">
              <label for="email_address">Email Address</label>
              <input type="text" class="form-control email" name="email_address" />
            </div>
            <div class="form-group">
              <label for="province">Province</label>
              <input type="text" class="form-control province" name="province" />
            </div>
            <div class="form-group">
              <label for="address_1">City</label>
              <input type="text" class="form-control address_1" name="address_1" />
            </div>
            <div class="form-group">
              <label for="address_2">Baranggay</label>
              <input type="text" class="form-control address_2" name="address_2" />
            </div>
            <div class="form-group">
              <label for="postal_code">Postal Code</label>
              <input type="text" class="form-control postal_code" name="postal_code" />
            </div>
            <div class="form-group">
              <label for="additional_address">Additional Address</label>
              <textarea type="text" class="form-control additional_address" name="additional_address" rows="3" style="resize: none;"></textarea>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-danger" data-dismiss="modal">Close</button>
            <button name="update-billing" class="btn btn-primary" type="submit">Save</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <?php require_once("scripts.php") ?>
  <script>
    $(".frm-add").validate({
      rules: {
        user_id: {
          required: true,
        },
        fullname: {
          required: true,
        },
        contact: {
          required: true,
        },
        address_1: {
          required: true,
        },
        address_2: {
          required: true,
        },
        postal_code: {
          number: true,
          required: true,
          minlength: 4
        },
        contact: {
          number: true,
          required: true,
          minlength: 11
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
    });

    $(document).on('click', '.btn-edit', function() {
      // $("#edit-billing").modal('show');
      let billing_id = $(this).data("id");
      let token = "<?= $_SESSION['csrf_token'] ?>";
      $.ajax({
        url: "../wp-actions/getBillingInfo.php",
        method: "POST",
        data: {
          BillingId: billing_id,
          csrf_token: token
        },
        dataType: "json",
        success: function(data) {
          if (data == "error") {
            console.error("Something went wrong");
          } else {
            $(".billing_id").val(data.billing_id);
            $(".user_id").val(data.user_id);
            $(".fname").val(data.fname);
            $(".lname").val(data.lname);
            $(".email").val(data.email);
            $(".province").val(data.province);
            $(".contact").val(data.contact);
            $(".address_1").val(data.address_1);
            $(".address_2").val(data.address_2);
            $(".postal_code").val(data.postal_code);
            $(".additional_address").val(data.additional_address);
            $("#edit-billing").modal('show');
          }
        }


      })
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
            window.location.href = `../wp-actions/billings.php?bid=${id}&_token=${token}`;
          }, 1500);
        }
      })
    });
  </script>
</body>

</html>