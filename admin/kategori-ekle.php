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
                        <h3 class="card-title">Yeni Kategori Ekle</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="islem/islem.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <?php if (isset($_SESSION["kategori-ekle_store_success_message"])) { ?>
                                <div class="alert alert-success mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['kategori-ekle_store_success_message'];
                    unset($_SESSION['kategori-ekle_store_success_message']); ?>
                                </div>
                                <?php } else if (isset($_SESSION["kategori-ekle_store_error_message"])) { ?>
                                <div class="alert alert-danger mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['kategori-ekle_store_error_message'];
                    unset($_SESSION['kategori-ekle_store_error_message']); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="ad">Kategori Adı</label>
                                <input type="text" class="form-control" id="ad" name="ad"
                                    placeholder="Kategori adı giriniz">
                            </div>

                            <div class="form-group">
                                <label for="sira">Kategori Sırası</label>
                                <input type="number" class="form-control" id="sira" name="sira"
                                    placeholder="Kategori Sırası giriniz">
                            </div>

                            <div class="form-group">
                                <label>Durum</label>
                                <select name="durum" class="form-control select2" style="width: 100%;">
                                    <option value="-1">Kategori Durumu Seçiniz</option>
                                    <option value="0">Pasif</option>
                                    <option value="1">Aktif</option>
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="kategori_kaydet">Gönder</button>
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