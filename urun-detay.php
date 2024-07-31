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
                        <div class="lg-image">
                            <img src="images/product/large-size/1.jpg" alt="product image">
                        </div>
                        <div class="lg-image">
                            <img src="images/product/large-size/2.jpg" alt="product image">
                        </div>
                        <div class="lg-image">
                            <img src="images/product/large-size/3.jpg" alt="product image">
                        </div>
                        <div class="lg-image">
                            <img src="images/product/large-size/4.jpg" alt="product image">
                        </div>
                        <div class="lg-image">
                            <img src="images/product/large-size/5.jpg" alt="product image">
                        </div>
                        <div class="lg-image">
                            <img src="images/product/large-size/6.jpg" alt="product image">
                        </div>
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        <div class="sm-image"><img src="images/product/small-size/1.jpg" alt="product image thumb">
                        </div>
                        <div class="sm-image"><img src="images/product/small-size/2.jpg" alt="product image thumb">
                        </div>
                        <div class="sm-image"><img src="images/product/small-size/3.jpg" alt="product image thumb">
                        </div>
                        <div class="sm-image"><img src="images/product/small-size/4.jpg" alt="product image thumb">
                        </div>
                        <div class="sm-image"><img src="images/product/small-size/5.jpg" alt="product image thumb">
                        </div>
                        <div class="sm-image"><img src="images/product/small-size/6.jpg" alt="product image thumb">
                        </div>
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
                        <div class="comment-review">
                            <span>Grade</span>
                            <ul class="rating">
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                            </ul>
                        </div>
                        <div class="comment-author-infos pt-25">
                            <span>HTML 5</span>
                            <em>01-12-18</em>
                        </div>
                        <div class="comment-details">
                            <h4 class="title-block">Demo</h4>
                            <p>Plaza</p>
                        </div>
                        <div class="review-btn">
                            <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">Write Your
                                Review!</a>
                        </div>
                        <!-- Begin Quick View | Modal Area -->
                        <div class="modal fade modal-wrapper" id="mymodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3 class="review-page-title">Write Your Review</h3>
                                        <div class="modal-inner-area row">
                                            <div class="col-lg-6">
                                                <div class="li-review-product">
                                                    <img src="images/product/large-size/3.jpg" alt="Li's Product">
                                                    <div class="li-review-product-desc">
                                                        <p class="li-product-name">Today is a good day Framed poster</p>
                                                        <p>
                                                            <span>Beach Camera Exclusive Bundle - Includes Two Samsung
                                                                Radiant 360 R3 Wi-Fi Bluetooth Speakers. Fill The Entire
                                                                Room With Exquisite Sound via Ring Radiator Technology.
                                                                Stream And Control R3 Speakers Wirelessly With Your
                                                                Smartphone. Sophisticated, Modern Design </span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="li-review-content">
                                                    <!-- Begin Feedback Area -->
                                                    <div class="feedback-area">
                                                        <div class="feedback">
                                                            <h3 class="feedback-title">Our Feedback</h3>
                                                            <form action="#">
                                                                <p class="your-opinion">
                                                                    <label>Your Rating</label>
                                                                    <span>
                                                                        <select class="star-rating">
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                    </span>
                                                                </p>
                                                                <p class="feedback-form">
                                                                    <label for="feedback">Your Review</label>
                                                                    <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                                </p>
                                                                <div class="feedback-input">
                                                                    <p class="feedback-form-author">
                                                                        <label for="author">Name<span class="required">*</span>
                                                                        </label>
                                                                        <input id="author" name="author" value="" size="30" aria-required="true" type="text">
                                                                    </p>
                                                                    <p class="feedback-form-author feedback-form-email">
                                                                        <label for="email">Email<span class="required">*</span>
                                                                        </label>
                                                                        <input id="email" name="email" value="" size="30" aria-required="true" type="text">
                                                                        <span class="required"><sub>*</sub> Required
                                                                            fields</span>
                                                                    </p>
                                                                    <div class="feedback-btn pb-15">
                                                                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">Close</a>
                                                                        <a href="#">Submit</a>
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

<?php require_once 'footer.php'; ?>