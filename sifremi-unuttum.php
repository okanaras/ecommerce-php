<?php require_once 'header.php'; ?>

<title>Şifremi Unuttum - Yazılım Yolcusu</title>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li class="active">Şifremi Unuttum</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Login Content Area -->
<div class="page-section mb-60">
    <div class="container">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-6 mb-30">
                <div class="login-form">
                    <h4 class="login-title">Şifremi Unuttum</h4>
                    <p class="login-box-msg">
                        <?php if (isset($_SESSION["front_login_error_message"])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                            echo $_SESSION['front_login_error_message'];
                            unset($_SESSION['front_login_error_message']); ?>
                    </div>
                <?php } else if (isset($_SESSION["normalUser_permisson_message"])) { ?>
                    <div class="alert alert-info" role="alert">
                        <?php
                            echo $_SESSION['normalUser_permisson_message'];
                            unset($_SESSION['normalUser_permisson_message']); ?>
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
                        <label for="k_adi">Kullanıcı Adı Giriniz*</label>
                        <input class="mb-0" type="text" name="k_adi" id="k_adi" placeholder="Kullanıcı Adı" required>
                    </div>
                    <div class="col-md-12">
                        <button type="button" name="sifremi_unuttum" id="btnSifremiUnuttum" class="register-button mt-0">Gönder</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btnSifremiUnuttum = document.querySelector('#btnSifremiUnuttum');
        const k_adi = document.querySelector('#k_adi');

        btnSifremiUnuttum.addEventListener('click', () => {
            const route = "./admin/app/Http/Controllers/Front/AuthController.php";

            let body = {
                k_adi: k_adi.value.trim(),
                action: 'sifremi_unuttum'
            };

            fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(body)
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            }).then(data => {
                console.log('data: ', data);
                let row = document.querySelector(`#row-${data.id}`);
                // row.remove();

                toastr.success('İşlem tamamlandı!', 'Başarılı');
            }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!')
            });

        });
    });
</script>

<!-- Login Content Area End Here -->
<?php require_once 'footer.php' ?>