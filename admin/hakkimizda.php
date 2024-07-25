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
                                <?php if (isset($_SESSION["hakkimizda_store_success_message"])) { ?>
                                <div class="alert alert-success mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['hakkimizda_store_success_message'];
                    unset($_SESSION['hakkimizda_store_success_message']); ?>
                                </div>
                                <?php } else if (isset($_SESSION["hakkimizda_store_error_message"])) { ?>
                                <div class="alert alert-danger mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['hakkimizda_store_error_message'];
                    unset($_SESSION['hakkimizda_store_error_message']); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="baslik">Başlık</label>
                                <input type="text" class="form-control"
                                    value="<?= isset($hakkimizdaCek['baslik']) ? htmlspecialchars($hakkimizdaCek['baslik']) : '' ?>"
                                    id="baslik" name="baslik" placeholder="Sitenin başlığı giriniz">
                            </div>
                            <div class="form-group">
                                <label for="detay">Detay</label>
                                <textarea class="ckeditor" id="detay"
                                    name="detay"><?= isset($hakkimizdaCek['detay']) ? htmlspecialchars($hakkimizdaCek['detay']) : '' ?></textarea>

                                <input type="text" class="form-control" value="" placeholder="Sitenin detayını giriniz">
                            </div>
                            <div class="form-group">
                                <label for="misyon">Misyon</label>
                                <input type="text" class="form-control"
                                    value="<?= isset($hakkimizdaCek['misyon']) ? htmlspecialchars($hakkimizdaCek['misyon']) : '' ?>"
                                    id="misyon" name="misyon" placeholder="Sitenin misyonunu giriniz">
                            </div>
                            <div class="form-group">
                                <label for="vizyon">Vizyon</label>
                                <input type="text" class="form-control"
                                    value="<?= isset($hakkimizdaCek['vizyon']) ? htmlspecialchars($hakkimizdaCek['vizyon']) : '' ?>"
                                    id="vizyon" name="vizyon" placeholder="Sitenin vizyonunu giriniz">
                            </div>

                            <?php if (isset($hakkimizdaCek['resim'])) { ?>
                            <div class="form-group">
                                <label>Resim:</label>
                                <div>
                                    <img width="100" height="auto"
                                        src="images/hakkimizda/<?= $hakkimizdaCek['resim'] ?>"
                                        alt="<?= isset($hakkimizdaCek['baslik']) ? htmlspecialchars($hakkimizdaCek['baslik']) : 'Resim' ?>">
                                </div>
                            </div>
                            <?php } ?>

                            <label for="resim">File input</label>
                            <div class="custom-file">
                                <input type="hidden" name="eski_resim" value="<?= $hakkimizdaCek['resim'] ?>">
                                <input type="file" class="form-control" id="resim" name="resim">
                            </div>




                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="hakkimizdaKaydet">Gönder</button>
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