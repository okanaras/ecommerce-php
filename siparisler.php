<?php require_once './header.php' ?>

<title>Siparişlerim - Yazılım Yolcusu</title>

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
                  <th class="li-product-thumbnail">Sipariş No</th>
                  <th class="li-product-thumbnail">Fotoğraf</th>
                  <th class="cart-product-name">Başlık</th>
                  <th class="li-product-price">Ücret</th>
                  <th class="li-product-quantity">Adet</th>
                  <th class="li-product-quantity">Sipariş Tarihi</th>
                  <th class="li-product-quantity">İşlemler</th>
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
                      <td class="li-product-name"><span><?= $siparis['id'] ?></span></td>

                      <td class="li-product-thumbnail">
                        <span>
                          <img width="100" height="auto" src="./admin/public/assets/images/urunler/<?= $siparis['urun_resim'] ?>" alt="<?= $siparis['urun_baslik'] ?>">
                        </span>
                      </td>
                      <td class="li-product-name"><span><?= $siparis['urun_baslik'] ?></span></td>
                      <td class="li-product-price"><span class="amount"><?= number_format($siparis['urun_fiyat'], 2, ',', '.') ?> ₺</span></td>
                      <td class="li-product-name"><span><?= $siparis['urun_adet'] ?></span></td>
                      <td class="li-product-name"><span><?= $siparis['created_at'] ?></span></td>
                      <td class="li-product-name">
                        <a href="javascript:void(0)" data-id="<?= $siparis['id'] ?>" class="btn btn-success btn-edit">
                          <i class="fa fa-edit btn-edit" data-id="<?= $siparis['id'] ?>"></i>
                        </a>
                      </td>
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
<!-- Modal -->
<div class="modal fade" id="siparisModal" tabindex="-1" role="dialog" aria-labelledby="siparisModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="siparisModalLabel"><span id="spanSiparisId"></span> Nolu Siparişin Adetini Güncelle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <input type="hidden" name="siparisId" id="siparisId">
          <div class="form-group col-md-12">
            <label for="yeni_adet">Yeni Sipariş Adeti</label>
            <input type="number" class="form-control" id="yeni_adet" name="yeni_adet" min="0" placeholder="Yeni sipariş adeti giriniz">
          </div>
          <div class="form-group col-md-12">
            <label for="not">Sipariş Notu</label>
            <textarea class="form-control" id="not" name="not" rows="4"></textarea>
          </div>
          <div class="form-group col-md-12">
            <small><span class="text-danger">*</span> Bu işlem sipariş zamanından sonra 24 saat geçmediyse veya henüz kargolanmamışsa ancak kabul edilebilinir.</small>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
        <button type="button" class="btn btn-primary btn-siparis-guncelle" name="siparis_guncelle">Güncelle</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {

    let btnSiparisGuncelle = document.querySelector('.btn-siparis-guncelle');

    document.querySelector('.table').addEventListener('click', function(event) {
      let siparisId = document.querySelector('#siparisId');
      let spanSiparisId = document.querySelector('#spanSiparisId');
      let element = event.target;
      if (element.classList.contains('btn-edit')) {
        let siparisID = element.getAttribute('data-id');
        siparisId.value = siparisID;
        spanSiparisId.textContent = siparisID;
        $('#siparisModal').modal('show');
      }
    });

    btnSiparisGuncelle.addEventListener('click', () => {
      let not = document.querySelector('#not');
      let yeni_adet = document.querySelector('#yeni_adet');
      let siparisId = document.querySelector('#siparisId');

      let body = {
        id: siparisId.value,
        yeni_adet: yeni_adet.value,
        not: not.value.trim(),
        action: 'siparis-guncelle'
      };
      console.log('siparisID: ', siparisId);

      const route = "./admin/app/Http/Controllers/Admin/OrderController.php";

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
        location.reload();
      }).catch(error => {
        console.error('Bir hata oluştu:', error);
        toastr.error('Bir hata oluştu', 'Hata!');
      });
    });

    <?php if (isset($_SESSION["siparis_update_success_message"])) : ?>
      const commentSuccessMessage = "<?= $_SESSION["siparis_update_success_message"] ?>";
      if (commentSuccessMessage) {
        toastr.success(commentSuccessMessage, 'Başarılı!');
        <?php unset($_SESSION["siparis_update_success_message"]); ?>
      }
    <?php endif; ?>

    <?php if (isset($_SESSION["siparis_update_error_message"])) : ?>
      const commentErrorMessage = "<?= $_SESSION["siparis_update_error_message"] ?>";
      if (commentErrorMessage) {
        toastr.error(commentErrorMessage, 'Hata!');
        <?php unset($_SESSION["siparis_update_error_message"]); ?>
      }
    <?php endif; ?>

    <?php if (isset($_SESSION["siparis_update_request_error_message"])) : ?>
      const commentErrorMessage = "<?= $_SESSION["siparis_update_request_error_message"] ?>";
      if (commentErrorMessage) {
        toastr.error(commentErrorMessage, 'Hata!');
        <?php unset($_SESSION["siparis_update_request_error_message"]); ?>
      }
    <?php endif; ?>
  });
</script>
<?php require_once './footer.php' ?>