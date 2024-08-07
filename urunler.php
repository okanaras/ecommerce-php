<?php
require_once 'header.php';

// pagination
$productCountQuery = $baglanti->prepare("SELECT * FROM urunler WHERE kategori_id=:kategori_id AND durum=:durum");
$productCountQuery->execute([
    ":kategori_id" => $_GET["id"],
    ":durum" => 1
]);
$urunSayisi = $productCountQuery->rowCount();
$perPage = 8;
$page = $_GET['sayfa'] ?? 1;
$startedPage = $page * $perPage - $perPage;


$urunler = $baglanti->prepare("SELECT * FROM urunler WHERE kategori_id=:kategori_id AND durum=:durum ORDER BY sira DESC LIMIT $startedPage, $perPage");
$urunler->execute([
    ":kategori_id" => $_GET["id"],
    ":durum" => 1
]);
$urunlerCek = $urunler->fetchAll(PDO::FETCH_ASSOC);


$currentUrunSayisi = $urunler->rowCount();
$currentTotalProduct = $startedPage + $currentUrunSayisi;

$sayfaSayisi = ceil($urunSayisi / $perPage);

?>

<title>Ürünler - Yazılım Yolcusu</title>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anaysafa</a></li>
                <li class="active">Ürünler</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- Begin Li's Content Wraper Area -->
<div class="content-wraper pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Begin Li's Banner Area -->
                <div class="single-banner shop-page-banner">
                    <a href="#">
                        <img src="images/bg-banner/2.jpg" alt="Li's Static Banner">
                    </a>
                </div>
                <!-- Li's Banner Area End Here -->
                <!-- shop-top-bar start -->
                <div class="shop-top-bar mt-30">
                    <div class="shop-bar-inner">
                        <div class="toolbar-amount">
                            <span><?= "Bu kategoriye ait toplam <span class='text-info'>$urunSayisi</span> ürün mevcuttur. Mevcut gösterilen ürün aralığı <span class='text-info'>$startedPage - $currentTotalProduct</span> şeklindedir." ?></span>
                        </div>
                    </div>
                    <!-- product-select-box start -->
                    <div class="product-select-box">
                        <div class="product-short">
                            <p>Sırala:</p>
                            <select class="nice-select">
                                <option value="sales">İsme Göre (A - Z)</option>
                                <option value="sales">İsme Göre (Z - A)</option>
                                <option value="rating">Düşükten Yükseğe</option>
                                <option value="date">Yüksekten Düşüğe</option>
                            </select>
                        </div>
                    </div>
                    <!-- product-select-box end -->
                </div>
                <!-- shop-top-bar end -->
                <!-- shop-products-wrapper start -->
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">
                                    <?php
                                    $index = 1;
                                    foreach ($urunlerCek as $urun) {
                                    ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 mt-40">
                                            <!-- single-product-wrap start -->
                                            <div class="single-product-wrap">
                                                <div class="product-image">
                                                    <a href="urun-detay-<?= convertToSeoLink($urun['baslik']) . '-' . $urun['id'] ?>">
                                                        <img src="./admin/public/assets/images/urunler/<?= $urun['resim'] ?>" alt="<?= $urun['baslik'] ?>">
                                                    </a>
                                                    <span class="sticker">Yeni</span>
                                                </div>
                                                <div class="product_desc">
                                                    <div class="product_desc_info">
                                                        <h4>
                                                            <a class="product_name" href="urun-detay-<?= convertToSeoLink($urun['baslik']) . '-' . $urun['id'] ?>"><?= $urun['baslik'] ?></a>
                                                        </h4>
                                                        <div class="price-box">
                                                            <span class="new-price"><?= $urun['fiyat'] ?> TL</span>
                                                        </div>
                                                    </div>
                                                    <div class="add-actions">
                                                        <ul class="add-actions-link">
                                                            <li class="add-cart active"><a href="shopping-cart.html">Sepete Ekle</a></li>
                                                            <li>
                                                                <a href="#" title="Hemen İncele" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </li>
                                                            <li><a class="links-details" title="Favoriye Ekle" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- single-product-wrap end -->
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="paginatoin-area">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <p><?= $currentUrunSayisi ?> adet ürün bulundu.</p>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="pagination-box">
                                        <li>
                                            <a href="<?= $page == 1 ? 'javascript:void(0)' : '?sayfa=' . $page - 1 ?>" class="Previous"><i class="fa fa-chevron-left"></i> Geri</a>
                                        </li>
                                        <?php
                                        for ($i = 1; $i <= $sayfaSayisi; $i++) {
                                        ?>
                                            <li class="<?= isset($page) && $page == $i ? 'active' : '' ?>"><a href="?sayfa=<?= $i ?>"><?= $i ?></a></li>
                                        <?php } ?>
                                        <li>
                                            <a href="<?= $sayfaSayisi == $page ? 'javascript:void(0)' : '?sayfa=' . $page + 1 ?>" class="Next"> İleri <i class="fa fa-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- shop-products-wrapper end -->
            </div>
        </div>
    </div>
</div>
<!-- Content Wraper Area End Here -->

<?php require_once 'footer.php'; ?>