<?php
require_once 'header.php';
?>
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">About Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- about wrapper start -->
<div class="about-us-wrapper pt-60 pb-40">
    <div class="container">
        <div class="row">
            <!-- About Text Start -->
            <div class="col-lg-6 order-last order-lg-first">
                <div class="about-text-wrap">
                    <h2><?= $hakkimizdaCek['baslik'] ?></h2>
                    <p><?= $hakkimizdaCek['detay'] ?></p>

                    <h4>Vizyonumuz</h4>
                    <p><?= $hakkimizdaCek['vizyon'] ?></p>

                    <h4>Misyonumuz</h4>
                    <p><?= $hakkimizdaCek['misyon'] ?></p>
                </div>
            </div>
            <!-- About Text End -->
            <!-- About Image Start -->
            <div class="col-lg-5 col-md-10">
                <div class="about-image-wrap">
                    <img class="img-full" src="./admin/public/assets/images/hakkimizda/<?= $hakkimizdaCek['resim'] ?>"
                        alt="<?= $hakkimizdaCek['baslik'] ?>" />
                </div>
            </div>
            <!-- About Image End -->
        </div>
    </div>
</div>
<!-- about wrapper end -->

<!-- // ! BURAYA DIKKAT -->
<!-- // TODO BURAYA DIKKAT -->
<!-- Begin Counterup Area -->
<!-- <div class="counterup-area">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <div class="limupa-counter white-smoke-bg">
                    <div class="container">
                        <div class="counter-img">
                            <img src="images/about-us/icon/1.png" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-number">
                                <h3 class="counter">2169</h3>
                            </div>
                            <div class="counter-text">
                                <span>HAPPY CUSTOMERS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="images/about-us/icon/2.png" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">869</h3>
                        </div>
                        <div class="counter-text">
                            <span>AWARDS WINNED</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="limupa-counter white-smoke-bg">
                    <div class="counter-img">
                        <img src="images/about-us/icon/3.png" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">689</h3>
                        </div>
                        <div class="counter-text">
                            <span>HOURS WORKED</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="images/about-us/icon/4.png" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">2169</h3>
                        </div>
                        <div class="counter-text">
                            <span>COMPLETE PROJECTS</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- Counterup Area End Here -->


<?php require_once 'footer.php'; ?>