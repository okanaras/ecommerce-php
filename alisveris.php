<?php require_once './header.php' ?>

<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index">Anasayfa</a></li>
                <li class="active">Alışveriş</li>
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
                    <div class="row">
                        <input type="hidden" name="toplam_fiyat" id="toplam_fiyat" value="<?= $_GET['toplam-fiyat'] ?>">

                        <input type="hidden" name="user_id" id="user_id" value="<?= $kullaniciCek['id'] ?>">

                        <div class="col-md-7 ml-auto">
                            Genel Toplam : <span><?= $_GET['toplam-fiyat'] ?> ₺</span>
                        </div>

                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <select name="odeme" id="odeme">
                                    <option value="0">Kapıda Ödeme</option>
                                    <option value="1">Kart İle Ödeme</option>
                                </select>
                                <a class="alisveris-bitir" href="javascript:void(0)">Alışverişi Tamamla</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Shopping Cart Area End-->

<script>
    document.addEventListener('DOMContentLoaded', () => {

        let btnFinish = document.querySelector('.alisveris-bitir');
        btnFinish.addEventListener('click', function(event) {

            let user_id = document.querySelector('#user_id').value;
            let toplam_fiyat = document.querySelector('#toplam_fiyat').value;
            let odeme = document.querySelector('#odeme').value;

            let body = {
                user_id: user_id,
                toplam_fiyat: toplam_fiyat,
                odeme: odeme,
                action: 'alisveris-bitir'
            };

            const route = "./admin/app/Http/Controllers/Front/CardController";

            fetch(route, {
                method: 'POST',
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
                window.history.back();
            }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!');
            });
        });
    });
</script>


<?php require_once './footer.php' ?>