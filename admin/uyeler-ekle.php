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
                        <h3 class="card-title">Genel Ayarlar</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="islem/islem.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <?php if (isset($_SESSION["uyeler-ekle_store_success_message"])) { ?>
                                <div class="alert alert-success mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['uyeler-ekle_store_success_message'];
                    unset($_SESSION['uyeler-ekle_store_success_message']); ?>
                                </div>
                                <?php } else if (isset($_SESSION["uyeler-ekle_store_error_message"])) { ?>
                                <div class="alert alert-danger mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['uyeler-ekle_store_error_message'];
                    unset($_SESSION['uyeler-ekle_store_error_message']); ?>
                                </div>
                                <?php } else if (isset($_SESSION["uyeler-ekle_store_info_message"])) { ?>
                                <div class="alert alert-info mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['uyeler-ekle_store_info_message'];
                    unset($_SESSION['uyeler-ekle_store_info_message']); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="k_adi">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="k_adi" name="k_adi"
                                    placeholder="Kullanıcı adı giriniz">
                            </div>

                            <div class="form-group">
                                <label for="sifre">Kullanıcı Şifre</label>
                                <input type="password" class="form-control" id="sifre" name="sifre"
                                    placeholder="Kullanıcı şifresi giriniz">
                            </div>
                            <div class="form-group">
                                <label for="ad_soyad">Kullanıcı Ad Soyad</label>
                                <input type="text" class="form-control" id="ad_soyad" name="ad_soyad"
                                    placeholder="Kullanıcı adı ve soyadını giriniz">
                            </div>

                            <label for="resim">File input</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" id="resim" name="resim">
                            </div>




                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="uyeler_kaydet">Gönder</button>
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