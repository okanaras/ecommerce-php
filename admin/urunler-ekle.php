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
            <h3 class="card-title">Yeni Ürün Ekle</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="./app/controllers/Admin/ProductController.php" method="POST" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">

                <div class="form-group col-md-12">
                  <?php if (isset($_SESSION["urun-ekle_store_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-50" role="alert">
                      <?php echo $_SESSION['urun-ekle_store_success_message'];
                      unset($_SESSION['urun-ekle_store_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["urun-ekle_store_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-50" role="alert">
                      <?php echo $_SESSION['urun-ekle_store_error_message'];
                      unset($_SESSION['urun-ekle_store_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>

                <div class="form-group col-md-12">
                  <label for="resim">Ürün Görseli</label>
                  <input type="file" class="form-control" id="resim" name="resim">
                </div>

                <div class="form-group col-md-6">
                  <label for="baslik">Ürün Başlık</label>
                  <input type="text" class="form-control" id="baslik" name="baslik" required placeholder="Ürün başlığı giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="kategori_id">Kategori</label>
                  <select name="kategori_id" class="form-control select2" style="width: 100%;">
                    <option value="-1" disabled>Ürün Kategorisi Seçiniz</option>
                    <?php
                    $kategoriler = $baglanti->prepare("SELECT * FROM kategori order by id DESC");
                    $kategoriler->execute();
                    $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($kategorilerCek as $kategori) {
                    ?>
                      <option value="<?= $kategori['id'] ?>" <?=
                                                              $kategori['id'] == $_GET['kategoriId'] ?  'selected' : ''
                                                              ?>>
                        <?= $kategori['ad'] ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label for="sira">Ürün Sıra</label>
                  <input type="number" class="form-control" id="sira" name="sira" required placeholder="Ürün sırası giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="model">Ürün Model</label>
                  <input type="text" class="form-control" id="model" name="model" required placeholder="Ürün model giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="renk">Ürün Renk</label>
                  <input type="text" class="form-control" id="renk" name="renk" required placeholder="Ürün rengi giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="adet">Ürün Adet</label>
                  <input type="number" class="form-control" id="adet" name="adet" required placeholder="Ürün adeti giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="fiyat">Ürün Fiyat</label>
                  <input type="number" class="form-control" id="fiyat" name="fiyat" required placeholder="Ürün fiyatı giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label for="etiket">Ürün Seo Keywords</label>
                  <input type="text" class="form-control" id="etiket" name="etiket" required placeholder="Ürün seo kelimelerini giriniz">
                </div>

                <div class="form-group col-md-6">
                  <label>Durum</label>
                  <select name="durum" class="form-control select2" style="width: 100%;">
                    <option value="-1">Ürün Durumu Seçiniz</option>
                    <option value="0">Pasif</option>
                    <option value="1">Aktif</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label>Ürün Öne Çıkarılsın Mı?</label>
                  <select name="is_featured" class="form-control select2" style="width: 100%;">
                    <option value="-1">Ürün Çıkarılma Durumu Seçiniz</option>
                    <option value="0">Hayır</option>
                    <option value="1">Evet</option>
                  </select>
                </div>

                <div class="form-group col-md-12">
                  <label for="aciklama">Ürün Açıklama</label>
                  <textarea class="ckeditor" id="aciklama" name="aciklama"></textarea>
                </div>
              </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" name="urunler_kaydet">Gönder</button>
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
