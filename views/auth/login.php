<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/";
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: " . $baseUrl);
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.jpg">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/sweetalert2.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $baseUrl ?>assets/img/favicon.jpg">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/toastr/toatr.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/animate.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/css/select2.min.css">

</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo d-flex align-items-center">
                            <i class="fa fa-university" style="font-size: 24px; font-weight: bold;"></i>
                            <span style="font-size: 24px; font-weight: bold; margin-left: 10px; line-height: 1;">BookVault</span>
                        </div>


                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>
                        <div class="form-login">
                            <label>Username</label>
                            <div class="form-addons">
                                <input type="text" placeholder="Enter your username" id="login_username" autocomplete="off">
                                <img src="<?= $baseUrl ?>assets/img/icons/mail.svg" alt="img">
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" placeholder="Enter your password" id="login_password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>

                        <div class="form-login">
                            <a class="btn btn-login" href="#" id="login_btn">Sign In</a>
                        </div>


                    </div>
                </div>
                <div class="login-img">
                    <img src="<?= $baseUrl ?>assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>


    <script src="<?= $baseUrl ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/feather.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $baseUrl ?>assets/js/script.js"></script>
    <script src="<?= $baseUrl ?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="<?= $baseUrl ?>assets/plugins/sweetalert/sweetalerts.min.js"></script>

    <script>
        $(document).ready(function() {

            localStorage.clear();


            // Fungsi untuk login
            function login() {
                var username = $("#login_username").val();
                var password = $("#login_password").val();

                if (username === "" || password === "") {
                    alert("Username dan Password tidak boleh kosong!");
                    return;
                }

                $.ajax({
                    url: "verify-login",
                    type: "POST",
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        if (response.status === "success") {
                            window.location.href = "<?= $baseUrl ?>";
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Login gagal! Periksa kembali username dan password.',
                                'error'
                            );
                            // alert("Login gagal! Periksa kembali username dan password.");
                        }
                    }
                });
            }

            // Klik tombol login
            $("#login_btn").click(function(e) {
                e.preventDefault();
                login();
            });

            // Tekan Enter untuk login
            $("#login_username, #login_password").keypress(function(e) {
                if (e.which === 13) { // 13 = Enter key
                    login();
                }
            });

        });
    </script>

</body>

</html>