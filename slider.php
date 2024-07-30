<!-- Begin Slider With Banner Area -->
<div class="slider-with-banner">
    <div class="container">
        <div class="row">
            <!-- Begin Slider Area -->
            <div class="col-lg-8 col-md-8">
                <div class="slider-area">
                    <div class="slider-active owl-carousel">

                        <?php
                        $sliderlar = $baglanti->prepare("SELECT * FROM slider WHERE durum=:durum AND banner=:banner  ORDER BY sira DESC LIMIT 5");
                        $sliderlar->execute([
                            ':durum' => 1,
                            ':banner' => 0
                        ]);
                        $sliderlarCek = $sliderlar->fetchAll(PDO::FETCH_ASSOC);
                        $index = 1;

                        foreach ($sliderlarCek as $slider) {
                        ?>

                            <!-- Begin Single Slide Area -->
                            <div style="background-image: url(./admin/public/assets/images/slider/<?= $slider['resim'] ?>)!important;" class="single-slide align-center-left  animation-style-01 bg-1">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <h5><?= $slider['indirim_miktari_yazisi'] ?></h5>
                                    <!-- <h5>Sale Offer <span>-20% Off</span> This Week</h5> -->
                                    <h2><?= $slider['baslik'] ?></h2>
                                    <h3><?= $slider['fiyat_yazisi'] ?></h3>
                                    <!-- <h3>Starting at <span>$1209.00</span></h3> -->
                                    <div class="default-btn slide-btn">
                                        <a class="links" href="<?= $slider['link'] ?>">Detayı Gör</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                        <?php } ?>

                    </div>
                </div>
            </div>
            <!-- Slider Area End Here -->
            <!-- Begin Li Banner Area -->
            <div class="col-lg-4 col-md-4 text-center pt-xs-30">
                <?php
                $sliderlar = $baglanti->prepare("SELECT * FROM slider WHERE durum=:durum AND banner=:banner ORDER BY sira DESC LIMIT 2");
                $sliderlar->execute([
                    ':durum' => 1,
                    ':banner' => 1
                ]);
                $sliderlarCek = $sliderlar->fetchAll(PDO::FETCH_ASSOC);
                $index = 1;

                foreach ($sliderlarCek as $slider) {
                    $additionalClasses = ($index % 2 == 0) ? 'mt-15 mt-sm-30 mt-xs-30' : '';

                ?>
                    <div class="li-banner <?= $additionalClasses ?>">
                        <a href="#">
                            <img src="./admin/public/assets/images/slider/<?= $slider['resim'] ?>" alt="<?= $slider['baslik'] ?>">
                        </a>
                    </div>
                <?php
                    $index++;
                }
                ?>


            </div>
            <!-- Li Banner Area End Here -->
        </div>
    </div>
</div>
<!-- Slider With Banner Area End Here -->