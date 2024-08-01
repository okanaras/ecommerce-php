<?php require_once 'header.php';

if ($checkUser == 0) {
    $_SESSION['normalUser_permisson_message'] = 'Lütfen giriş yapınız.';
    header('Location:./login');
}

?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li class="active">Hesabım</li>
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
                <form action="./admin/app/Http/Controllers/Front/UserController.php" method="POST">
                    <div class="login-form">
                        <h4 class="login-title">Kullanıcı Bilgileri <i class="fa fa-info-circle fa-lg text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Kullanıcı adı alanı değiştirilemez. (*) alanlar zorunludur."></i></h4>
                        <p class="login-box-msg">
                            <?php if (isset($_SESSION["user_update_success_message"])) { ?>
                        <div class="alert alert-success" role="alert">
                            <?php
                                echo $_SESSION['user_update_success_message'];
                                unset($_SESSION['user_update_success_message']); ?>
                        </div>
                    <?php } else if (isset($_SESSION["user_update_error_message"])) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                                echo $_SESSION['user_update_error_message'];
                                unset($_SESSION['user_update_error_message']); ?>
                        </div>
                    <?php } else {
                                echo "";
                            }
                    ?>
                    <div class="row">
                        <input type="hidden" name="id" value="<?= $kullaniciCek['id'] ?>">
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label>Kullanıcı Adı</label>
                            <input class="mb-0" style="background-color: #dedede;" type="text" value="<?= $kullaniciCek['kullanici_adi'] ?>" disabled>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label for="ad_soyad">Ad Soyad <span class="text-danger">*</span></label>
                            <input class="mb-0" type="text" value="<?= $kullaniciCek['ad_soyad'] ?>" name="ad_soyad" id="ad_soyad" placeholder="Ad Soyad">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label for="tel">Telefon <span class="text-danger">*</span></label>
                            <input class="mb-0" type="text" value="<?= $kullaniciCek['tel'] ?>" name="tel" id="tel" placeholder="Telefon">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input class="mb-0" type="email" value="<?= $kullaniciCek['email'] ?>" name="email" id="email" placeholder="Email">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label for="il">İl <span class="text-danger">*</span></label>
                            <input class="mb-0" type="text" value="<?= $kullaniciCek['il'] ?>" name="il" id="il" placeholder="İl">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12 mb-20">
                            <label for="ilce">İlçe <span class="text-danger">*</span></label>
                            <input class="mb-0" type="text" value="<?= $kullaniciCek['ilce'] ?>" name="ilce" id="ilce" placeholder="İlçe">
                        </div>

                        <div class="col-12 mb-20">
                            <label for="adres">Adres <span class="text-danger">*</span></label>
                            <input class="mb-0" type="text" value="<?= $kullaniciCek['adres'] ?>" name="adres" id="adres" placeholder="Adres">
                        </div>

                        <div class="col-12">
                            <button name="kullanici_duzenle" class="register-button mt-0">Kaydet</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xs-12">
                <form action="./admin/app/Http/Controllers/Front/UserController.php" method="POST">
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