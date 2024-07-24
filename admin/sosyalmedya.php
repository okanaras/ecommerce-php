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
            <h3 class="card-title">Sosyal Medya Ayarları</h3>
          </div>
          <!-- /.card-header -->
          <?php
          if (isset($_GET["success"]) == "1") { ?>
            <div class="alert alert-success mt-2 w-25" role="alert">
              İşlem başarılı.
            </div>
          <?php
          } else if (isset($_GET["error"]) == "1") {
          ?>
            <div class="alert alert-danger mt-2 w-25" role="alert">
              İşlem başarısız.
            </div>
          <?php } ?>
          <!-- form start -->
          <form action="islem/islem.php" method="POST">
            <div class="card-body">
              <div class="form-group">
                <label for="facebook">Facebook</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($ayarCek['facebook']) ?>" id="facebook" name="facebook" placeholder="Sitenin facebook adresini giriniz">
              </div>
              <div class="form-group">
                <label for="instagram">Instagram</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($ayarCek['instagram']) ?>" id="instagram" name="instagram" placeholder="Sitenin instagram adresini giriniz">
              </div>
              <div class="form-group">
                <label for="twitter">Twitter</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($ayarCek['twitter']) ?>" id="twitter" name="twitter" placeholder="Sitenin twitter adresini giriniz">
              </div>
              <div class="form-group">
                <label for="youtube">Youtube</label>
                <input type="text" class="form-control" value="<?php echo htmlspecialchars($ayarCek['youtube']) ?>" id="youtube" name="youtube" placeholder="Sitenin youtube adresini giriniz">
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" name="sosyalMedyaKaydet">Gönder</button>
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