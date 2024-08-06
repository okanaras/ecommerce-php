<?php
session_start();
ob_start();
require_once './admin/Database/baglanti.php';
require_once './admin/app/Helpers/Helpers.php';

$ayar = $baglanti->prepare("SELECT * FROM ayarlar WHERE id=?");
$ayar->execute([1]);

$ayarCek = $ayar->fetch(PDO::FETCH_ASSOC);

$hakkimizda = $baglanti->prepare("SELECT * FROM hakkimizda WHERE id=?");
$hakkimizda->execute([1]);

$hakkimizdaCek = $hakkimizda->fetch(PDO::FETCH_ASSOC);


$sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi";
$stmt = $baglanti->prepare($sql);
$stmt->execute([
    ":k_adi" => $_SESSION['normalUser']
]);

$kullaniciCek = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($kullaniciCek);die;
$checkUser = $stmt->rowCount();


$sepetToplamUst = 0;
if (isset($_COOKIE['sepet']) && is_array($_COOKIE['sepet'])) {
    foreach ($_COOKIE['sepet'] as $urun_id => $amount) {
        $urunler = $baglanti->prepare("SELECT * FROM urunler WHERE id=:id ORDER BY sira DESC");
        $urunler->execute([
            ":id" => $urun_id,
        ]);
        $urunlerCek = $urunler->fetch(PDO::FETCH_ASSOC);
        $sepetToplamUst += $urunlerCek['fiyat'] * $amount;
    }
}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<!-- index28:48-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Yazılım Yolcusu E-Commerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <!-- Material Design Iconic Font-V2.2.0 -->
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Font Awesome Stars-->
    <link rel="stylesheet" href="css/fontawesome-stars.css">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="css/meanmenu.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="css/slick.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Jquery-ui CSS -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="css/venobox.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/nice-select.css">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Bootstrap V4.1.3 Fremwork CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Helper CSS -->
    <link rel="stylesheet" href="css/helper.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Modernizr js -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- BENIM EKLEDIGIM CSSLER -->
    <link rel="stylesheet" href="public/assets/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="public/assets/toastr/build/toastr.min.css">
</head>

<body>

    <div class="body-wrapper">
        <!-- Begin Header Area -->
        <header>
            <!-- Begin Header Top Area -->
            <div class="header-top bg-dark text-white">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Top Left Area -->
                        <div class="col-lg-3 col-md-4">
                            <div class="header-top-left">
                                <ul class="phone-wrap">
                                    <li><span class="text-white">Telefon: </span><a href="tel:<?= $ayarCek['telefon'] ?>" class="text-white"><?= $ayarCek['telefon'] ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Header Top Left Area End Here -->
                        <!-- Begin Header Top Right Area -->
                        <?php
                        if (isset($_SESSION['normalUser']) && isset($_SESSION['normalUserPermission'])) { ?>
                            <div class="col-lg-9 col-md-8">
                                <div class="header-top-right">
                                    <ul class="ht-menu">
                                        <!-- Begin Setting Area -->
                                        <li>
                                            <div class="ht-setting-trigger"><span>Ayarlar</span></div>
                                            <div class="setting ht-setting">
                                                <ul class="ht-setting-list">
                                                    <li><a href="kullanici"><i class="fa fa-gear"></i> Hesabım</a></li>
                                                    <li><a href="sepet"><i class="fa fa-shopping-cart"></i> Sepetim</a></li>
                                                    <li><a href="siparisler"><i class="fa fa-list"></i> Siparişlerim</a></li>
                                                    <li><a href="sifremi-degistir"><i class="fa fa-key"></i> Şifre</a></li>
                                                    <li>
                                                        <a href="logout">
                                                            <i class="fa fa-sign-out"></i> Çıkış Yap
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <!-- Setting Area End Here -->
                                    </ul>
                                </div>
                            </div>
                            <!-- Header Top Right Area End Here -->
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Begin Header Middle Area -->
            <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
                <div class="container">
                    <div class="row">
                        <!-- Begin Header Logo Area -->
                        <div class="col-lg-3">
                            <div class="logo pb-sm-30 pb-xs-30">
                                <a href="index.html">
                                    <img src="images/menu/logo/1.jpg" alt="">
                                </a>
                            </div>
                        </div>
                        <!-- Header Logo Area End Here -->
                        <!-- Begin Header Middle Right Area -->
                        <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                            <!-- Begin Header Middle Searchbox Area -->
                            <form action="#" class="hm-searchbox">
                                <select class="nice-select select-search-category">
                                    <option value="0">All</option>
                                    <option value="10">Laptops</option>
                                </select>
                                <input type="text" placeholder="Enter your search key ...">
                                <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <div class="header-middle-right">
                                <ul class="hm-menu">
                                    <!-- Begin Header Middle Wishlist Area -->
                                    <li class="hm-wishlist">
                                        <a href="kullanici">
                                            <i class="fa fa-user-o"></i>
                                        </a>
                                    </li>
                                    <li class="hm-minicart">
                                        <div class="hm-minicart-trigger">
                                            <span class="item-icon"></span>
                                            <span class="item-text"><?= number_format($sepetToplamUst, 2, ',', '.') ?> ₺
                                                <span class="cart-item-count"><?= isset($_COOKIE['sepet']) ? count($_COOKIE['sepet']) : '0' ?></span>
                                            </span>
                                        </div>
                                        <span></span>
                                        <div class="minicart">
                                            <ul class="minicart-product-list">
                                                <?php
                                                if (isset($_COOKIE['sepet']) && is_array($_COOKIE['sepet'])) {
                                                    $sepetToplam = 0;
                                                    $kdv = 0;

                                                    foreach ($_COOKIE['sepet'] as $urun_id => $amount) {
                                                        $urunler = $baglanti->prepare("SELECT * FROM urunler WHERE id=:id ORDER BY sira DESC");
                                                        $urunler->execute([
                                                            ":id" => $urun_id,
                                                        ]);
                                                        $urunlerCek = $urunler->fetch(PDO::FETCH_ASSOC);
                                                ?>
                                                        <li>
                                                            <a href="single-product.html" class="minicart-product-image">
                                                                <img src="./admin/public/assets/images/urunler/<?= $urunlerCek['resim'] ?>" alt="<?= $urunlerCek['baslik'] ?>">
                                                            </a>
                                                            <div class="minicart-product-details">
                                                                <h6><a href="single-product.html"><?= $urunlerCek['baslik'] ?></a>
                                                                </h6>
                                                                <span><?= number_format($urunlerCek['fiyat'], 2, ',', '.') . " ₺ x " . $amount . " adet" ?></span>
                                                            </div>
                                                            <a href="javascript:void(0)" class="sepet-sil" data-product-id="<?= $urun_id ?>">
                                                                <button class="close sepet-sil" title="Sil" data-product-id="<?= $urun_id ?>">
                                                                    <i class="fa fa-close sepet-sil" data-product-id="<?= $urun_id ?>"></i>
                                                                </button>
                                                            </a>
                                                        </li>
                                                    <?php
                                                        $sepetToplam += $urunlerCek['fiyat'] * $amount;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <span class="badge badge-warning text-white" style="font-size: 13px;">Sepetinizde ürün bulunmamaktadır.</span>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </ul>
                                            <?php
                                            if (isset($_COOKIE['sepet']) && is_array($_COOKIE['sepet'])) {
                                            ?>
                                                <p class="minicart-total">TOPLAM FİYAT: <span><?= number_format($sepetToplam, 2, ',', '.') ?> ₺</span></p>
                                                <div class="minicart-button">
                                                    <a href="sepet" class="li-button li-button-fullwidth li-button-dark">
                                                        <span>Sepeti Göster</span>
                                                    </a>
                                                    <a href="alisveris" class="li-button li-button-fullwidth">
                                                        <span>Alışverişi Tamamla</span>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <!-- Header Mini Cart Area End Here -->
                                </ul>
                            </div>
                            <!-- Header Middle Right Area End Here -->
                        </div>
                        <!-- Header Middle Right Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Header Middle Area End Here -->
            <!-- Begin Header Bottom Area -->
            <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Header Bottom Menu Area -->
                            <div class="hb-menu">
                                <nav>
                                    <ul>
                                        <li><a href="index">Anasayfa</a></li>
                                        <li class="megamenu-holder">
                                            <a href="shop-left-sidebar.html">Kategoriler</a>
                                            <ul class="megamenu hb-megamenu">
                                                <li>
                                                    <a href="">BURASI KATEGORI ADI OLABILIR (ERKEK KADIN)</a>
                                                    <ul>
                                                        <?php
                                                        $kategoriler = $baglanti->prepare("SELECT * FROM kategori WHERE durum=:durum AND sira BETWEEN 1 AND 10 LIMIT 8");
                                                        $kategoriler->execute([
                                                            ":durum" => 1
                                                        ]);
                                                        $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                                                        $index = 1;

                                                        foreach ($kategorilerCek as $kategori) {
                                                        ?>
                                                            <li><a href="urunler-<?= convertToSeoLink($kategori['ad']) . '-' . $kategori['id'] ?>"><?= $kategori['ad'] ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="single-product-gallery-left.html">CAT TITLE</a>
                                                    <ul>
                                                        <?php
                                                        $kategoriler = $baglanti->prepare("SELECT * FROM kategori WHERE durum=:durum AND sira BETWEEN 10 AND 20 LIMIT 8");
                                                        $kategoriler->execute([
                                                            ":durum" => 1
                                                        ]);
                                                        $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                                                        $index = 1;

                                                        foreach ($kategorilerCek as $kategori) {
                                                        ?>
                                                            <li>
                                                                <a href="urunler-<?= convertToSeoLink($kategori['ad']) . '-' . $kategori['id'] ?>"><?= $kategori['ad'] ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="single-product.html">CAT TITLE 2</a>
                                                    <ul>
                                                        <?php
                                                        $kategoriler = $baglanti->prepare("SELECT * FROM kategori WHERE durum=:durum AND sira BETWEEN 20 AND 30 LIMIT 8");
                                                        $kategoriler->execute([
                                                            ":durum" => 1
                                                        ]);
                                                        $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                                                        $index = 1;

                                                        foreach ($kategorilerCek as $kategori) {
                                                        ?>
                                                            <li>
                                                                <a href="urunler-<?= convertToSeoLink($kategori['ad']) . '-' . $kategori['id'] ?>"><?= $kategori['ad'] ?></a>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a href="about-us.html">Hakkımızda</a></li>
                                        <li><a href="contact.html">Kargo Bilgileri</a></li>
                                        <li><a href="contact.html">İletişim</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- Header Bottom Menu Area End Here -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Bottom Area End Here -->
            <!-- Begin Mobile Menu Area -->
            <div class="mobile-menu-area d-lg-none d-xl-none col-12">
                <div class="container">
                    <div class="row">
                        <div class="mobile-menu">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu Area End Here -->
        </header>
        <!-- Header Area End Here -->
    </div>