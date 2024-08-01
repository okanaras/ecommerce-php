<?php require_once 'header.php';

$urunler = $baglanti->prepare("SELECT * FROM urunler WHERE id=:id ORDER BY sira DESC");
$urunler->execute([
    ":id" => $_GET["id"],
]);
$urunlerCek = $urunler->fetch(PDO::FETCH_ASSOC);

$kategori_id = $urunlerCek['kategori_id'];

?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li><a href="urunler">Ürünler</a></li>
                <li class="active"><?= $urunlerCek['baslik'] ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- content-wraper start -->
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
                <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images slider-navigation-1">
                        <?php
                        $resimler = $baglanti->prepare("SELECT * FROM cokluresim WHERE urun_id=:urun_id ORDER BY id DESC");
                        $resimler->execute([':urun_id' => $_GET['id']]);
                        $resimlerCek = $resimler->fetchAll(PDO::FETCH_ASSOC);
                        $index = 1;

                        foreach ($resimlerCek as $resim) {
                        ?>
                            <div class="lg-image">
                                <a class="popup-img venobox vbox-item" href="./admin/public/assets/images/cokluresim/<?= $resim['resim'] ?>" data-gall="myGallery">
                                    <img src="./admin/public/assets/images/cokluresim/<?= $resim['resim'] ?>" alt="<?= $resim['resim'] ?>">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        <?php
                        $resimler = $baglanti->prepare("SELECT * FROM cokluresim WHERE urun_id=:urun_id ORDER BY id DESC");
                        $resimler->execute([':urun_id' => $_GET['id']]);
                        $resimlerCek = $resimler->fetchAll(PDO::FETCH_ASSOC);
                        $index = 1;

                        foreach ($resimlerCek as $resim) {
                        ?>
                            <a class="popup-img venobox vbox-item" href="./admin/public/assets/images/cokluresim/<?= $resim['resim'] ?>" data-gall="myGallery">
                                <div class="sm-image">
                                    <img src="./admin/public/assets/images/cokluresim/<?= $resim['resim'] ?>" alt="<?= $resim['resim'] ?>">
                                </div>
                            </a>
                        <?php } ?>

                    </div>
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content sp-normal-content pt-60">
                    <div class="product-info">
                        <h2><?= $urunlerCek['baslik'] ?></h2>
                        <span class="product-details-ref">Reference: demo_15</span>
                        <div class="price-box pt-20">
                            <span class="new-price new-price-2"><?= $urunlerCek['fiyat'] ?> TL</span>
                        </div>
                        <div class="product-desc">
                            <p>
                                <span><?= $urunlerCek['aciklama'] ?></span>
                            </p>
                        </div>
                        <div class="single-add-to-cart">
                            <form action="#" class="cart-quantity">
                                <div class="quantity">
                                    <label>Adet</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" value="1" type="text">
                                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                    </div>
                                </div>
                                <button class="add-to-cart" type="submit">Sepete Ekle</button>
                            </form>
                        </div>
                        <div class="product-additional-info">
                            <div class="product-social-sharing">
                                <ul>
                                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
                                    <li class="twitter"><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
                                    <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i>Google +</a>
                                    </li>
                                    <li class="instagram"><a href="#"><i class="fa fa-instagram"></i>Instagram</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
<div class="product-area pt-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#description"><span>Açıklama</span></a></li>
                        <li><a data-toggle="tab" href="#reviews"><span>Yorumlar</span></a></li>
                    </ul>
                </div>
                <!-- Begin Li's Tab Menu Content Area -->
            </div>
        </div>
        <div class="tab-content">
            <div id="description" class="tab-pane active show" role="tabpanel">
                <div class="product-description">
                    <span><?= $urunlerCek['aciklama'] ?></span>
                </div>
            </div>

            <div id="reviews" class="tab-pane" role="tabpanel">
                <div class="product-reviews">
                    <div class="product-details-comment-block">
                        <?php
                        $onay = 1;
                        $is_spam = 0;

                        $sql = "SELECT yorumlar.*, kullanici.ad_soyad FROM yorumlar INNER JOIN kullanici ON yorumlar.user_id = kullanici.id WHERE yorumlar.urun_id=:urun_id AND yorumlar.onay=:onay AND yorumlar.is_spam=:is_spam ORDER BY yorumlar.id DESC";

                        $stmt = $baglanti->prepare($sql);

                        $stmt->execute([
                            ':urun_id' => $_GET['id'],
                            ':onay' => $onay,
                            ':is_spam' => $is_spam
                        ]);
                        $yorumlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($yorumlar) {
                            foreach ($yorumlar as $yorum) { ?>
                                <div class="comment-author-infos pt-25">
                                    <i class="fa fa-user"></i> <span><?= $yorum['ad_soyad'] ?></span>
                                    <em><?= $yorum['detay'] ?></em>
                                    <em><?= date('d-m-Y H:i', strtotime($yorum['created_at'])) ?></em>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="comment-author-infos">
                                <em>Henüz Yorum Yapılmamıştır. İlk Yorumu Siz Yapın!</em>
                            </div>
                        <?php } ?>

                        <div class="review-btn mt-3">
                            <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">Yorum Yaz!</a>
                        </div>
                        <!-- Begin Quick View | Modal Area -->
                        <div class="modal fade modal-wrapper" id="mymodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <!-- <h3 class="review-page-title">Yorumunuzu Giriniz</h3> -->
                                        <div class="modal-inner-area row">
                                            <div class="col-lg-12">
                                                <div class="li-review-content">
                                                    <!-- Begin Feedback Area -->
                                                    <div class="feedback-area">
                                                        <div class="feedback">
                                                            <h3 class="feedback-title">Yorumunuzu Giriniz</h3>
                                                            <form action="./admin/app/Http/Controllers/Front/CommentController.php" method="POST" id="yorumForm">
                                                                <?php
                                                                // print_r($_SERVER);die;

                                                                ?>
                                                                <input type="hidden" name="yorum_kaydet_input">
                                                                <input type="hidden" name="user_id" value="<?= $kullaniciCek['id'] ?>">
                                                                <input type="hidden" name="urun_id" value="<?= $urunlerCek['id'] ?>">
                                                                <input type="hidden" name="urun_id" value="<?= $urunlerCek['id'] ?>">
                                                                <p class="feedback-form">
                                                                    <label for="feedback">Yorum</label>
                                                                    <textarea id="detay" name="detay" cols="45" rows="8" aria-required="true"></textarea>
                                                                </p>
                                                                <div class="feedback-input">
                                                                    <div class="feedback-btn pb-15">
                                                                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">Kapat</a>
                                                                        <a href="javascript:void(0)" name="yorum_kaydet" id="yorum_kaydet">Gönder</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- Feedback Area End Here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quick View | Modal Area End Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->
<!-- Begin Li's Laptop Product Area -->
<section class="product-area li-laptop-product pt-30 pb-50">
    <div class="container">
        <div class="row">
            <!-- Begin Li's Section Area -->
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2>
                        <span>8 Benzer Ürünler:</span>
                    </h2>
                </div>
                <div class="row">
                    <div class="product-active owl-carousel">
                        <?php
                        $urunler = $baglanti->prepare("SELECT * FROM urunler WHERE kategori_id=:kategori_id AND durum=:durum ORDER BY sira DESC");
                        $urunler->execute([
                            ":kategori_id" => $kategori_id,
                            ":durum" => 1
                        ]);
                        $urunlerCek = $urunler->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($urunlerCek as $urun) {
                        ?>
                            <div class="col-lg-12">
                                <!-- single-product-wrap start -->
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="urun-detay-<?= convertToSeoLink($urun['baslik']) . '-' . $urun['id'] ?>">
                                            <img src="./admin/public/assets/images/urunler/<?= $urun['resim'] ?>" alt="<?= $urun['baslik'] ?>">
                                        </a>
                                        <span class="sticker">Benzer</span>
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <h4><a class="product_name" href="urun-detay-<?= convertToSeoLink($urun['baslik']) . '-' . $urun['id'] ?>"><?= $urun['baslik'] ?></a>
                                            </h4>
                                            <div class="price-box">
                                                <span class="new-price"><?= $urun['fiyat'] ?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active">
                                                    <a href="#">Sepete Ekle</a>
                                                </li>
                                                <li>
                                                    <a href="#" title="Hemen İncele" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="links-details" title="Favoriye Ekle" href="wishlist.html">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                </li>
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
            <!-- Li's Section Area End Here -->
        </div>
    </div>
</section>
<!-- Li's Laptop Product Area End Here -->

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        let yorum_kaydet = document.querySelector('#yorum_kaydet');
        let yorumForm = document.querySelector('#yorumForm');

        yorum_kaydet.addEventListener('click', (e) => {
            yorumForm.submit();
        });

        showMessages();

        function showMessages() {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-left",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",

                "timeOut": "3000",
                "extendedTimeOut": "1500",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            <?php if (isset($_SESSION["yorum_store_success_message"])) : ?>
                const commentSuccessMessage = "<?= $_SESSION["yorum_store_success_message"] ?>";
                if (commentSuccessMessage) {
                    toastr.success(commentSuccessMessage, 'Başarılı!');
                    <?php unset($_SESSION["yorum_store_success_message"]); ?>
                }
            <?php endif; ?>

            <?php if (isset($_SESSION["yorum_store_error_message"])) : ?>
                const commentErrorMessage = "<?= $_SESSION["yorum_store_error_message"] ?>";
                if (commentErrorMessage) {
                    toastr.error(commentErrorMessage, 'Hata!');
                    <?php unset($_SESSION["yorum_store_error_message"]); ?>
                }
            <?php endif; ?>
        }
    });
</script>

<?php require_once 'footer.php'; ?>