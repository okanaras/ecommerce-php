<?php require_once './header.php' ?>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li class="active">Siparişlerim</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!--Shopping Cart Area Strat-->
<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="li-product-thumbnail">Fotoğraf</th>
                                    <th class="cart-product-name">Başlık</th>
                                    <th class="li-product-price">Ücret</th>
                                    <th class="li-product-quantity">Adet</th>
                                    <th class="li-product-quantity">Sipariş Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user_id = $kullaniciCek['id'];
                                $onay = 1;

                                $siparisler = $baglanti->prepare("SELECT siparisler.*, urunler.resim AS urun_resim, urunler.baslik AS urun_baslik
                                                                  FROM siparisler 
                                                                  INNER JOIN urunler 
                                                                  ON siparisler.urun_id = urunler.id 
                                                                  WHERE siparisler.user_id = :user_id 
                                                                  AND onay=:onay
                                                                  ORDER BY siparisler.id DESC");
                                $siparisler->execute([
                                    ":user_id" => $user_id,
                                    ":onay" => $onay
                                ]);
                                $siparislerCek = $siparisler->fetchAll(PDO::FETCH_ASSOC);

                                if ($siparislerCek) {
                                    foreach ($siparislerCek as $siparis) {
                                ?>
                                        <tr id="<?= "row-{$siparis['id']}" ?>">
                                            <td class="li-product-thumbnail">
                                                <span>
                                                    <img width="100" height="auto" src="./admin/public/assets/images/urunler/<?= $siparis['urun_resim'] ?>" alt="<?= $siparis['urun_baslik'] ?>">
                                                </span>
                                            </td>
                                            <td class="li-product-name"><span><?= $siparis['urun_baslik'] ?></span></td>
                                            <td class="li-product-price"><span class="amount"><?= number_format($siparis['urun_fiyat'], 2, ',', '.') ?> ₺</span></td>
                                            <td class="li-product-name"><span><?= $siparis['urun_adet'] ?></span></td>
                                            <td class="li-product-name"><span><?= $siparis['created_at'] ?></span></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Sipariş bulunamadı.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Shopping Cart Area End-->

<?php require_once './footer.php' ?>