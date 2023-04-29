    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown user-small">
                <a class="nav-link user-panel d-flex align-items-center" data-toggle="dropdown" href="#">
                    <img src="../../wp-images/users/<?= $avatar?>" class="img-circle mr-2" alt="User Image" style="width: 35px; height: 35px;">
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
    </nav>
    <!-- /.navbar -->