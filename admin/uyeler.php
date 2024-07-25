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
                  <div class="col-12">
                      <div class="card">
                          <div class="card-header">
                              <h3 class="card-title">Üyeler Tablosu</h3>

                              <div class="card-tools">
                                  <div class="input-group input-group-sm" style="width: 150px;">
                                      <input type="text" name="table_search" class="form-control float-right"
                                          placeholder="Search">

                                      <div class="input-group-append">
                                          <button type="submit" class="btn btn-default"><i
                                                  class="fas fa-search"></i></button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0">
                              <div class="form-group m-2">
                                  <?php if (isset($_SESSION["uyeler_delete_success_message"])) { ?>
                                  <div class="alert alert-success mt-2 w-25" role="alert">
                                      <?php echo $_SESSION['uyeler_delete_success_message'];
                      unset($_SESSION['uyeler_delete_success_message']); ?>
                                  </div>
                                  <?php } else if (isset($_SESSION["uyeler_delete_error_message"])) { ?>
                                  <div class="alert alert-danger mt-2 w-25" role="alert">
                                      <?php echo $_SESSION['uyeler_delete_error_message'];
                      unset($_SESSION['uyeler_delete_error_message']); ?>
                                  </div>
                                  <?php } ?>
                              </div>
                              <a href="uyeler-ekle" class="btn btn-success float-right mr-2">Kullanıcı Ekle</a>

                              <table class="table table-hover text-nowrap">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>ID</th>
                                          <th>Kullanıcı Adı</th>
                                          <th>Kullanıcı Adı Soyadı</th>
                                          <th>Yetkisi</th>
                                          <th>Katıldığı Tarih</th>
                                          <th>Adres</th>
                                          <th>İl</th>
                                          <th>İlçe</th>
                                          <th>Telefon</th>
                                          <th>Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                    $uyeler = $baglanti->prepare("SELECT * FROM kullanici order by id DESC");
                    $uyeler->execute();
                    $uyelerCek = $uyeler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($uyelerCek as $uye) {
                    ?>
                                      <tr>
                                          <td><?= $index++ ?></td>
                                          <td><?= $uye['id']   ?? '-' ?></td>
                                          <td><?= $uye['kullanici_adi']   ?? '-' ?></td>
                                          <td><?= $uye['ad_soyad']  ?? '-' ?></td>
                                          <td><?= $uye['yetki'] == 1 ? 'Admin' : 'Uye' ?></td>
                                          <td><?= $uye['created_at'] ?></td>
                                          <td><?= $uye['adres']  ?? '-' ?></td>
                                          <td><?= $uye['il']   ?? '-' ?></td>
                                          <td><?= $uye['ilce'] ?? '-' ?></td>
                                          <td><?= $uye['tel']  ?? '-' ?></td>
                                          <td>
                                              <a href="islem/islem?delete_user&id=<?= $uye['id'] ?>"
                                                  class="btn btn-danger btn-delete">
                                                  <i class="fa fa-trash"></i>
                                              </a>
                                              <a href="islem/islem?id=<?= $uye['id'] ?>" class="btn btn-success">
                                                  <i class="fa fa-pen"></i>
                                              </a>
                                          </td>
                                      </tr>
                                      <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  </div>
              </div>
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->






























































  <?php require_once 'footer.php' ?>