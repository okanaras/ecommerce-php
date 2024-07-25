<?php
session_start();
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
                        <h3 class="card-title">İletişim Ayarları</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="islem/islem.php" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <?php if (isset($_SESSION["iletisim_store_success_message"])) { ?>
                                <div class="alert alert-success mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['iletisim_store_success_message'];
                    unset($_SESSION['iletisim_store_success_message']); ?>
                                </div>
                                <?php } else if (isset($_SESSION["iletisim_store_error_message"])) { ?>
                                <div class="alert alert-danger mt-2 w-50" role="alert">
                                    <?php echo $_SESSION['iletisim_store_error_message'];
                    unset($_SESSION['iletisim_store_error_message']); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="telefon">Telefon Numarası</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($ayarCek['telefon']) ?>" id="telefon"
                                    name="telefon" placeholder="Sitenin telefon numarası giriniz">
                            </div>
                            <div class="form-group">
                                <label for="adres">Adres</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($ayarCek['adres']) ?>" id="adres" name="adres"
                                    placeholder="Sitenin adresini giriniz">
                            </div>
                            <div class="form-group">
                                <label for="email">Mail</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($ayarCek['email']) ?>" id="email" name="email"
                                    placeholder="Sitenin mailini giriniz">
                            </div>
                            <div class="form-group">
                                <label for="mesai">Mesai</label>
                                <input type="text" class="form-control"
                                    value="<?php echo htmlspecialchars($ayarCek['mesai']) ?>" id="mesai" name="mesai"
                                    placeholder="Sitenin mesai saatini giriniz">
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" name="iletisimKaydet">Gönder</button>
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