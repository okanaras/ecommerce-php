<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yazılım Yolcusu E-Commerce</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page bg-dark">
    <div class="login-box">
        <div class="login-logo">
            <a class="text-white" href="index2.html"><b>Yazılım</b> Yolcusu</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    <?php if (isset($_SESSION["login_error_message"])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['login_error_message'];
            unset($_SESSION['login_error_message']); ?>
                </div>
                <?php } else if (isset($_SESSION["admin_permisson_message"])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php echo $_SESSION['admin_permisson_message'];
            unset($_SESSION['admin_permisson_message']); ?>
                </div>
                <?php } else if (isset($_SESSION["logout_message"])) { ?>
                <div class="alert alert-primary" role="alert">
                    <?php echo $_SESSION['logout_message'];
            unset($_SESSION['logout_message']); ?>
                </div>
                <?php } else {
            echo "Lütfen giriş bilgilerinizi giriniz.";
          }

      ?>

                </p>

                <form action="islem/islem.php" method="post">
                    <div class="input-group mb-3">
                        <input name="k_adi" type="text" class="form-control" placeholder="Kullanıcı Adı">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user text-dark"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input name="sifre" type="password" class="form-control" placeholder="Parola">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock text-dark"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Beni Hatırla
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button name="giris_yap" type="submit" class="btn btn-info btn-block">Giriş Yap</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

</body>

</html>
