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
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
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
                  <?php } else if (isset($_SESSION["uyeler_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['uyeler_update_success_message'];
                      unset($_SESSION['uyeler_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["uyeler_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['uyeler_update_error_message'];
                      unset($_SESSION['uyeler_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <a href="uyeler-ekle" class="btn btn-success float-right mr-2">Kullanıcı Ekle</a>

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Resim</th>
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
                      <tr id=<?= "row-{$uye['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td>
                          <?php
                          if (isset($uye['resim'])) { ?>
                            <img src="./public/assets/images/kullanici/<?= $uye['resim'] ?>" alt="<?= $uye['resim'] ?>" title=" <?= $uye['resim'] ?>" width="50" height="auto">
                          <?php } else {
                            echo '<span class="badge badge-info text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="İlgili veriye ait görsel bulunmamaktadır.">İlgili veriye ait...</span>';
                          } ?>
                        </td>
                        <td><?= $uye['id']  ?></td>
                        <td <?php if (isset($uye['kullanici_adi']) && strlen(trim($uye['kullanici_adi'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['kullanici_adi'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['kullanici_adi'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($uye['kullanici_adi']) > 15) {
                            echo substr($uye['kullanici_adi'], 0, 15) . '...';
                          } else {
                            echo $uye['kullanici_adi'];
                          } ?>
                        </td>
                        <td <?php if (isset($uye['ad_soyad']) && strlen(trim($uye['ad_soyad'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['ad_soyad'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['ad_soyad'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($uye['ad_soyad']) > 15) {
                            echo substr($uye['ad_soyad'], 0, 15) . '...';
                          } else {
                            echo $uye['ad_soyad'];
                          } ?>
                        </td>
                        <td>
                          <?= $uye['yetki'] == 1
                            ? "<a class='btn btn-success btn-change-status text-white' data-id='{$uye['id']}'>Admin</a>"
                            : "<a class='btn btn-danger btn-change-status text-white' data-id='{$uye['id']}'>Üye</a>"
                          ?>
                        </td>

                        <td><?= date('Y-m-d', strtotime($uye['created_at'])) ?></td>
                        <td <?php if (isset($uye['adres']) && strlen(trim($uye['adres'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['adres'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['adres'])) {
                            echo '<span class="badge badge-warning text-white">---</span>';
                          } else if (strlen($uye['adres']) > 15) {
                            echo substr($uye['adres'], 0, 15) . '...';
                          } else {
                            echo $uye['adres'];
                          }                          ?>
                        </td>
                        <td <?php if (isset($uye['il']) && strlen(trim($uye['il'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['il'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['il'])) {
                            echo '<span class="badge badge-warning text-white">---</span>';
                          } else if (strlen($uye['il']) > 15) {
                            echo substr($uye['il'], 0, 15) . '...';
                          } else {
                            echo $uye['il'];
                          }                          ?>
                        </td>
                        <td <?php if (isset($uye['ilce']) && strlen(trim($uye['ilce'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['ilce'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['ilce'])) {
                            echo '<span class="badge badge-warning text-white">---</span>';
                          } else if (strlen($uye['ilce']) > 15) {
                            echo substr($uye['ilce'], 0, 15) . '...';
                          } else {
                            echo $uye['ilce'];
                          }                          ?>
                        </td>
                        <td <?php if (isset($uye['tel']) && strlen(trim($uye['tel'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $uye['tel'] . '"';
                            } ?>>
                          <?php
                          if (!isset($uye['tel'])) {
                            echo '<span class="badge badge-warning text-white">---</span>';
                          } else if (strlen($uye['tel']) > 15) {
                            echo substr($uye['tel'], 0, 15) . '...';
                          } else {
                            echo $uye['tel'];
                          } ?>
                        </td>
                        <td>
                          <a href="javascript:void(0)" data-id="<?= $uye['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $uye['id'] ?>"></i>
                          </a>
                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $uye['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $uye['id'] ?>"></i>
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

  <!-- Modal -->
  <div class="modal fade" id="uyeModal" tabindex="-1" role="dialog" aria-labelledby="uyeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="islem/islem.php" method="POST" enctype="multipart/form-data" id="uyeGuncelleme">
          <div class="modal-header">
            <h5 class="modal-title" id="uyeModalLabel">
              Uye Güncelleme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" name="id" id="uyeId">

              <div class="form-group col-md-12">
                <label for="resim">Üye Görseli</label>
                <input type="file" class="form-control" id="resim" name="resim">
              </div>

              <div class="form-group col-md-6">
                <label for="username">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Kullanıcı adı giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="sifre">Şifre</label>
                <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="ad_soyad">Ad Soyad</label>
                <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" placeholder="Ad soyad giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="yetki">Yetki</label>
                <select name="yetki" id="yetki" class="form-control select2" style="width: 100%;">
                  <option value="-1">Yetki Durumu Seçiniz</option>
                  <option value="0">Üye</option>
                  <option value="1">Admin</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="adres">Adres</label>
                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="il">İl</label>
                <input type="text" class="form-control" id="il" name="il" placeholder="İl giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="ilce">İlçe</label>
                <input type="text" class="form-control" id="ilce" name="ilce" placeholder="İlçe giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="tel">Telefon</label>
                <input type="text" class="form-control" id="tel" name="tel" placeholder="Telefon giriniz">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            <button type="submit" class="btn btn-primary" name="uye_guncelle">Güncelle</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelector('.table').addEventListener('click', (event) => {
        let element = event.target;

        if (element.classList.contains('btn-edit')) {
          let dataID = element.getAttribute('data-id');

          fetch(`islem/islem.php?action=getMember&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              console.log('data: ', data);
              document.querySelector('#uyeId').value = data.member.id;
              document.querySelector('#username').value = data.member.kullanici_adi;
              document.querySelector('#ad_soyad').value = data.member.ad_soyad;
              document.querySelector('#yetki').value = data.member.yetki;
              document.querySelector('#adres').value = data.member.adres;
              document.querySelector('#il').value = data.member.il;
              document.querySelector('#ilce').value = data.member.ilce;
              document.querySelector('#tel').value = data.member.tel;

              $('#uyeModal').modal('show');
            })
            .catch(error => {
              console.error('Bir hata oluştu:', error);
              toastr.error('Bir hata oluştu', 'Hata!')
            });
        }

        if (element.classList.contains('btn-change-status')) {
          Swal.fire({
            title: "Değişiklikler kaydedilsin mi?",
            showDenyButton: true,
            icon: "info",
            confirmButtonText: "Evet",
            denyButtonText: `Hayır`
          }).then((result) => {
            if (result.isConfirmed) {
              let dataID = element.getAttribute('data-id');

              let body = {
                id: dataID,
                'action': 'changeMemberStatus'
              };

              fetch('islem/islem.php', {
                method: 'PUT',
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
                if (data.yetki) {
                  element.classList.add("btn-success", "text-white");
                  element.classList.remove("btn-danger");
                  element.textContent = "Admin";
                } else {
                  element.classList.remove("btn-success");
                  element.classList.add("btn-danger", "text-white");
                  element.textContent = "Üye";
                }

                toastr.success('İşlem tamamlandı!', 'Başarılı');
              }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!')
              });
            } else if (result.isDenied) {
              toastr.info('Herhangi bir işlem gerçekleştirilmedi!', 'Bilgi');
            }
          });
        }

        if (element.classList.contains("btn-delete")) {
          Swal.fire({
            title: "Silmek istediğinize emin misiniz?",
            showDenyButton: true,
            icon: "info",
            confirmButtonText: "Evet",
            denyButtonText: `Hayır`
          }).then((result) => {
            if (result.isConfirmed) {
              let deleteForm = document.querySelector('#deleteForm');
              let dataID = element.getAttribute('data-id');
              console.log('dataID: ', dataID);

              let body = {
                id: dataID,
                action: 'deleteMember'
              };

              fetch('islem/islem.php', {
                method: 'DELETE',
                headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json'
                },
                body: JSON.stringify(body)
              }).then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                console.log('response: ', response);
                return response.json();
              }).then(data => {
                let row = document.querySelector(`#row-${data.id}`);
                row.remove();

                toastr.success('İşlem tamamlandı!', 'Başarılı');
              }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!')
              });
            } else if (result.isDenied) {
              toastr.info('Herhangi bir işlem gerçekleştirilmedi!', 'Bilgi');
            }
          });
        }
      });
    });
  </script>

  <?php require_once 'footer.php' ?>
