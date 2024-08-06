<?php require_once './header.php' ?>

<title>Sepetim - Yazılım Yolcusu</title>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li class="active">Sepet</li>
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
                                    <th class="li-product-remove">Kaldır</th>
                                    <th class="li-product-thumbnail">Fotoğraf</th>
                                    <th class="cart-product-name">Başlık</th>
                                    <th class="li-product-price">Ücret</th>
                                    <th class="li-product-quantity">Adet</th>
                                    <th class="li-product-subtotal">Toplam Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                        <tr id="<?= "row-{$urun_id}" ?>">
                                            <td class="li-product-remove">
                                                <a href="javascript:void(0)" class="sepet-sil" data-product-id="<?= $urun_id ?>">
                                                    <i class="fa fa-times sepet-sil" data-product-id="<?= $urun_id ?>"></i>
                                                </a>
                                            </td>
                                            <td class="li-product-thumbnail">
                                                <a href="#">
                                                    <img width="100" height="auto" src="./admin/public/assets/images/urunler/<?= $urunlerCek['resim'] ?>" alt="<?= $urunlerCek['baslik'] ?>">
                                                </a>
                                            </td>
                                            <td class="li-product-name"><a href="#"><?= $urunlerCek['baslik'] ?></a></td>
                                            <td class="li-product-price"><span class="amount"><?= $urunlerCek['fiyat'] ?> ₺</span></td>
                                            <td class="quantity">
                                                <label>Quantity</label>
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box" value="<?= htmlspecialchars($amount) ?>" type="text">
                                                    <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                    <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                </div>
                                            </td>
                                            <td class="product-subtotal"><span class="amount"><?= $urunlerCek['fiyat'] * $amount ?> ₺</span></td>
                                        </tr>
                                    <?php
                                        $sepetToplam += $urunlerCek['fiyat'] * $amount;
                                        $kdv = $sepetToplam * 0.18;

                                        $toplamFiyat = $kdv + $sepetToplam;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6"><span class="badge badge-warning text-white" style="font-size: 13px;">Sepetinizde ürün bulunmamaktadır.</span></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <?php
                    if (isset($_COOKIE['sepet']) && is_array($_COOKIE['sepet'])) {
                    ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="coupon-all">
                                    <div class="coupon">
                                        <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Kupon Kodu" type="text">
                                        <input class="button" name="apply_coupon" value="Uygula" type="submit">
                                    </div>
                                    <div class="coupon2">
                                        <input class="button" name="update_cart" value="Sepeti Güncelle" type="submit">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 ml-auto">
                                <div class="cart-page-total">
                                    <h2>Toplam Fiyat</h2>
                                    <ul>
                                        <li>Toplam <span><?= number_format($sepetToplam, 2, ',', '.') ?> ₺</span></li>
                                        <li>KDV <span><?= number_format($kdv, 2, ',', '.') ?> ₺</span></li>
                                        <li>Genel Toplam <span><?= number_format($toplamFiyat, 2, ',', '.') ?> ₺</span></li>
                                    </ul>
                                    <a href="alisveris?toplam-fiyat=<?= number_format($toplamFiyat, 2, ',', '.') ?>">Alışverişi Tamamla</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Shopping Cart Area End-->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelector('.table').addEventListener('click', function(event) {
            let element = event.target;

            if (element.classList.contains('sepet-sil')) {
                Swal.fire({
                    title: "Sepetteki ürünü kaldırmak istediğinize emin misiniz?",
                    showDenyButton: true,
                    icon: "info",
                    confirmButtonText: "Evet",
                    denyButtonText: "Hayır"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let dataID = element.getAttribute('data-product-id');
                        console.log('dataID: ', dataID);

                        let body = {
                            id: dataID,
                            action: 'urun-kaldir'
                        };

                        const route = "./admin/app/Http/Controllers/Front/CardController";

                        fetch(route, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(body)
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        }).then(data => {
                            location.reload();
                            // toastr.success('İşlem tamamlandı!', 'Başarılı');
                        }).catch(error => {
                            console.error('Bir hata oluştu:', error);
                            toastr.error('Bir hata oluştu', 'Hata!');
                        });
                    } else if (result.isDenied) {
                        toastr.info('Herhangi bir işlem gerçekleştirilmedi!', 'Bilgi');
                    }
                });
            }
        });

        <?php if (isset($_SESSION["sepet_store_success_message"])) : ?>
            const commentSuccessMessage = "<?= $_SESSION["sepet_store_success_message"] ?>";
            if (commentSuccessMessage) {
                toastr.success(commentSuccessMessage, 'Başarılı!');
                <?php unset($_SESSION["sepet_store_success_message"]); ?>
            }
        <?php endif; ?>

        <?php if (isset($_SESSION["sepet_store_error_message"])) : ?>
            const commentErrorMessage = "<?= $_SESSION["sepet_store_error_message"] ?>";
            if (commentErrorMessage) {
                toastr.error(commentErrorMessage, 'Hata!');
                <?php unset($_SESSION["sepet_store_error_message"]); ?>
            }
        <?php endif; ?>

        <?php if (isset($_SESSION["sepet_delete_success_message"])) : ?>
            const commentSuccessMessage = "<?= $_SESSION["sepet_delete_success_message"] ?>";
            if (commentSuccessMessage) {
                toastr.success(commentSuccessMessage, 'Başarılı!');
                <?php unset($_SESSION["sepet_delete_success_message"]); ?>
            }
        <?php endif; ?>

        <?php if (isset($_SESSION["siparis_success_message"])) : ?>
            const commentSuccessMessage = "<?= $_SESSION["siparis_success_message"] ?>";
            if (commentSuccessMessage) {
                toastr.success(commentSuccessMessage, 'Başarılı!');
                <?php unset($_SESSION["siparis_success_message"]); ?>
            }
        <?php endif; ?>

        <?php if (isset($_SESSION["siparis_error_message"])) : ?>
            const commentErrorMessage = "<?= $_SESSION["siparis_error_message"] ?>";
            if (commentErrorMessage) {
                toastr.error(commentErrorMessage, 'Hata!');
                <?php unset($_SESSION["siparis_error_message"]); ?>
            }
        <?php endif; ?>
    });
</script>


<?php require_once './footer.php' ?>