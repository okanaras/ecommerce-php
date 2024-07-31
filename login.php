<?php require_once 'header.php'; ?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Anasayfa</a></li>
                <li class="active">Login & Register</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                <!-- Login Form s-->
                <form action="./app/controllers/FrontAuthController.php" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Giriş Yap</h4>
                        <p class="login-box-msg">
                            <?php if (isset($_SESSION["front_login_error_message"])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                echo $_SESSION['front_login_error_message'];
                                unset($_SESSION['front_login_error_message']); ?>
                        </div>
                    <?php } else if (isset($_SESSION["logout_message"])) { ?>
                        <div class="alert alert-primary" role="alert">
                            <?php
                                echo $_SESSION['logout_message'];
                                unset($_SESSION['logout_message']); ?>
                        </div>
                    <?php } else {
                                echo "";
                            }
                    ?>
                    </p>
                    <div class="row">
                        <div class="col-md-12 col-12 mb-20">
                            <label for="login_k_adi">Kullanıcı Adı*</label>
                            <input class="mb-0" type="text" name="k_adi" id="login_k_adi" placeholder="Kullanıcı Adı" required>
                        </div>
                        <div class="col-12 mb-20">
                            <label for="login_pass">Parola</label>
                            <input class="mb-0" type="password" name="sifre" id="login_pass" placeholder="Parola" required>
                        </div>
                        <div class="col-md-8">
                            <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                <input type="checkbox" id="remember_me">
                                <label for="remember_me">Beni Hatırla</label>
                            </div>
                        </div>
                        <div class="col-md-4 mt-10 mb-20 text-left text-md-right">
                            <a href="#">Şifrenizi mi unuttunuz?</a>
                        </div>
                        <div class="col-md-12">
                            <button name="login" class="register-button mt-0">Giriş Yap</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                <form action="./app/controllers/FrontAuthController.php" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Kayıt Ol</h4>
                        <p class="login-box-msg">
                            <?php if (isset($_SESSION["front_login_user_error_message"])) { ?>
                        <div class="alert alert-info" role="alert">
                            <?php
                                echo $_SESSION['front_login_user_error_message'];
                                unset($_SESSION['front_login_user_error_message']); ?>
                        </div>
                    <?php } else if (isset($_SESSION["front_login_pass_len_error_message"])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                echo $_SESSION['front_login_pass_len_error_message'];
                                unset($_SESSION['front_login_pass_len_error_message']); ?>
                        </div>
                    <?php } else if (isset($_SESSION["front_login_pass_error_message"])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                echo $_SESSION['front_login_pass_error_message'];
                                unset($_SESSION['front_login_pass_error_message']); ?>
                        </div>
                    <?php } else if (isset($_SESSION["logout_message"])) { ?>
                        <div class="alert alert-primary" role="alert">
                            <?php
                                echo $_SESSION['logout_message'];
                                unset($_SESSION['logout_message']); ?>
                        </div>
                    <?php } else {
                                echo "";
                            }
                    ?>

                    </p>
                    <div class="row">
                        <div class="col-md-6 col-12 mb-20">
                            <label for="k_adi">Kullanıcı Adı</label>
                            <input name="k_adi" id="k_adi" class="mb-0" type="text" placeholder="Kullanıcı Adı" required>
                        </div>
                        <div class="col-md-6 col-12 mb-20">
                            <label for="ad_soyad">Ad Soyad</label>
                            <input name="ad_soyad" id="ad_soyad" class="mb-0" type="text" placeholder="Ad Soyad" required>
                        </div>
                        <div class="col-md-12 mb-20">
                            <label for="email">Email Adresi</label>
                            <input name="email" id="email" class="mb-0" type="email" placeholder="Email Adresi" required>
                        </div>
                        <div class="col-md-6 mb-20">
                            <label for="sifre">Parola</label>
                            <input name="sifre" id="sifre" class="mb-0" type="password" placeholder="Parola" required>
                        </div>
                        <div class="col-md-6 mb-20">
                            <label for="sifre_tekrar">Parola Doğrulama</label>
                            <input name="sifre_tekrar" id="sifre_tekrar" class="mb-0" type="password" placeholder="Parola Doğrulama" required>
                        </div>
                        <div class="col-12">
                            <button name="register" class="register-button mt-0">Kayıt Ol</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Login Content Area End Here -->
<?php require_once 'footer.php' ?>