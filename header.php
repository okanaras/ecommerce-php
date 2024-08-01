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
                                            <span class="item-text">£80.00
                                                <span class="cart-item-count">2</span>
                                            </span>
                                        </div>
                                        <span></span>
                                        <div class="minicart">
                                            <ul class="minicart-product-list">
                                                <li>
                                                    <a href="single-product.html" class="minicart-product-image">
                                                        <img src="images/product/small-size/5.jpg" alt="cart products">
                                                    </a>
                                                    <div class="minicart-product-details">
                                                        <h6><a href="single-product.html">Aenean eu tristique</a>
                                                        </h6>
                                                        <span>£40 x 1</span>
                                                    </div>
                                                    <button class="close" title="Remove">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="single-product.html" class="minicart-product-image">
                                                        <img src="images/product/small-size/6.jpg" alt="cart products">
                                                    </a>
                                                    <div class="minicart-product-details">
                                                        <h6><a href="single-product.html">Aenean eu tristique</a>
                                                        </h6>
                                                        <span>£40 x 1</span>
                                                    </div>
                                                    <button class="close" title="Remove">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                            <p class="minicart-total">SUBTOTAL: <span>£80.00</span></p>
                                            <div class="minicart-button">
                                                <a href="shopping-cart.html" class="li-button li-button-fullwidth li-button-dark">
                                                    <span>View Full Cart</span>
                                                </a>
                                                <a href="checkout.html" class="li-button li-button-fullwidth">
                                                    <span>Checkout</span>
                                                </a>
                                            </div>
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
                                        <?php
                                        if (isset($_SESSION['normalUser']) && isset($_SESSION['normalUserPermission'])) { ?>
                                            <li>
                                                <a href="logout">
                                                    <button class="btn btn-danger">
                                                        <i class="fa fa-sign-out"></i> Çıkış Yap
                                                    </button>
                                                </a>
                                            </li>
                                        <?php } ?>
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