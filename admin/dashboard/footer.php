<div class="modal fade" id="change-profile" style="display: none;" aria-hidden="true">
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
                    <input type="text" name="uid" value="<?= $user_id ?>" hidden>
                    <div class="text-center">
                        <img class="border-0 img-fluid img-responsive img-preview" src="../../wp-images/users/<?= $avatar?>" style="height: 150px;" alt="user-profile">
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
                    <button name="admin-photo" class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="user-settings" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Settings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="frm-edit" action="../wp-actions/user.php" method="post">
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
                                <input type="password" class="form-control" name="password" />
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
                    <button name="update-admin" class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<footer class="main-footer">
    <strong>Copyright &copy; 2023-2023 <a href="https://facebook.com">PC Village</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0
    </div>
</footer>