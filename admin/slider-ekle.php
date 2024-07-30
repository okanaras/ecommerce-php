<?php
require_once 'header.php';
require_once 'sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- general form elements -->
        <div class="card card-primary col-md-12">
          <div class="card-header">
            <h3 class="card-title">Yeni Slider Ekle</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="islem/islem.php" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">

                <div class="form-group col-md-12">
                  <?php if (isset($_SESSION["slider-ekle_store_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-50" role="alert">
                      <?php echo $_SESSION['slider-ekle_store_success_message'];
                      unset($_SESSION['slider-ekle_store_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["slider-ekle_store_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-50" role="alert">
                      <?php echo $_SESSION['slider-ekle_store_error_message'];
                      unset($_SESSION['slider-ekle_store_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>

                <div class="form-group col-md-12">
                  <label for="resim">Slider Görseli</label>
                  <input type="file" class="form-control" id="resim" name="resim">
                </div>

                <div class="form-group col-md-6">
                  <label for="baslik">Slider Başlık</label>
                  <input type="text" class="form-control" id="baslik" name="baslik" placeholder="Slider başlığı giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="aciklama">Slider Açıklama</label>
                  <input type="text" class="form-control" id="aciklama" name="aciklama" placeholder="Slider açıklaması giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="sira">Slider Sırası</label>
                  <input type="number" class="form-control" id="sira" name="sira" placeholder="Slider sırası giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="link">Slider Link</label>
                  <input type="text" class="form-control" id="link" name="link" placeholder="Slider linki giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label>Durum</label>
                  <select name="durum" class="form-control select2" style="width: 100%;">
                    <option value="-1">Slider Durumu Seçiniz</option>
                    <option value="0">Pasif</option>
                    <option value="1">Aktif</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label>Slider & Banner</label>
                  <select name="slider_banner" class="form-control select2" id="sliderBannerSelect" style="width: 100%;">
                    <option value="-1">Slider & Banner Durumu Seçiniz</option>
                    <option value="0">Slider</option>
                    <option value="1">Banner</option>
                  </select>
                </div>

                <div class="form-group col-md-6 slider-fields">
                  <label for="fiyat">Fiyat Yazısı</label>
                  <input type="text" class="form-control" id="fiyat" name="fiyat_yazisi" placeholder="Slider fiyat yazısı giriniz">
                </div>

                <div class="form-group col-md-6 slider-fields">
                  <label for="indirim_miktari_yazisi">İndirim Miktarı Yazısı</label>
                  <input type="text" class="form-control" id="indirim_miktari_yazisi" name="indirim_miktari_yazisi" placeholder="Slider indirim miktarı yazısı giriniz">
                </div>
                
              </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" name="slider_kaydet">Gönder</button>
            </div>
          </form>
        </div>

        <!-- /.card -->
      </div>

    </div>

    <!-- /.container-fluid -->
  </section>

  <!-- /.content -->

</div>

<!-- /.content-wrapper -->

<?php require_once 'footer.php' ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const sliderBannerSelect = document.getElementById('sliderBannerSelect');
    const sliderFields = document.querySelectorAll('.slider-fields');

    function checkForSliderFields() {
      if (sliderBannerSelect.value == '0') {
        sliderFields.forEach(field => field.style.display = 'block');
      } else {
        sliderFields.forEach(field => field.style.display = 'none');
      }
    }

    sliderBannerSelect.addEventListener('change', checkForSliderFields);
    checkForSliderFields();
  });
</script>
