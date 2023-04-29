<!-- User Login -->
<div class="modal fade" id="user-login" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Sign In
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="frm-login" action="wp-includes/login.php" method="post">
                <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="username" class="form-label">Username or Email</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                    </div>
                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="lgn-password" name="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary bg-none" type="button" id="show-password-toggle" aria-label="Show password">
                                    <i class="fa fa-eye-slash"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="#" data-target="#user-forgot" data-toggle="modal" data-dismiss="modal" class="float-end pe-auto">Forgot Password?</a>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="user-login" class="btn btn-primary">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forgot Password -->
<div class="modal fade" id="user-forgot" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Forgot Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="frm-forgot" action="wp-actions/forgot.php" method="post">
                <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="forgot" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- User Sign Up -->
<div class="modal fade" id="user-signup" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Register
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="frm-register" action="wp-actions/register.php" method="post">
                <input type="text" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="password">First Name</label>
                            <input type="text" name="fname" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="password">Password</label>
                            <input id="sgn-password" type="password" name="password" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const passwordInput = document.getElementById('lgn-password');
    const showPasswordToggle = document.getElementById('show-password-toggle');

    showPasswordToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        showPasswordToggle.innerHTML = type === 'password' ? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';
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


    $(".frm-login").validate({
        rules: {
            username: {
                required: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            username: {
                required: "*Required.",
            },
            password: {
                required: "*Required.",
            },
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
    });


    $(".frm-forgot").validate({
        rules: {
            email: {
                required: true,
                email: true,
                allowedEmailDomain: true
            },
        },
        messages: {
            email: {
                required: "*Required.",
            },

        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
    });



    $(".frm-register").validate({
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
                required: true,
                minlength: 8,
                customRegex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.*[^\s]).{8,20}$/
            },
            cpassword: {
                required: true,
                minlength: 8,
                equalTo: "#sgn-password"
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
                required: "*Required.",
                customRegex: "Your password must contain at least 1 uppercase, 1 lowercase letter, 1 number, and 1 special character."
            },
            cpassword: {
                required: "*Required.",
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