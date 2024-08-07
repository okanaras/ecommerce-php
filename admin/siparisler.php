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
                <h3 class="card-title">Siparişler Tablosu</h3>

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
                  <?php if (isset($_SESSION["siparis_delete_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['siparis_delete_success_message'];
                      unset($_SESSION['siparis_delete_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["siparis_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['siparis_delete_error_message'];
                      unset($_SESSION['siparis_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["siparis_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['siparis_update_success_message'];
                      unset($_SESSION['siparis_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["siparis_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['siparis_update_error_message'];
                      unset($_SESSION['siparis_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Sipariş Id</th>
                      <th>Kullanıcı Adı</th>
                      <th>Ürün Adı</th>
                      <th>Ürün Adet</th>
                      <th>Ürün Fiyat</th>
                      <th>KDV</th>
                      <th>Toplam Fiyat</th>
                      <th>Sipariş Durumu</th>
                      <th>Ödeme Durumu</th>
                      <th>Yeni Adet</th>
                      <th>Sipariş Notu</th>
                      <th>Sipariş Tarihi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $siparisler = $baglanti->prepare(
                      "SELECT siparisler.*, urunler.baslik AS urun_adi, kullanici.kullanici_adi AS username
                       FROM siparisler 
                       INNER JOIN urunler ON siparisler.urun_id = urunler.id 
                       INNER JOIN kullanici ON siparisler.user_id = kullanici.id 
                       ORDER BY siparisler.id DESC
                      "
                    );

                    $siparisler->execute();
                    $siparislerCek = $siparisler->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($siparislerCek as $siparis) {
                    ?>
                      <tr id=<?= "row-{$siparis['id']}" ?>>
                        <td><?= $siparis['id']   ?? '-' ?></td>
                        <td><?= $siparis['username']   ?? '-' ?></td>
                        <td><?= $siparis['urun_adi']   ?? '-' ?></td>
                        <td><?= number_format($siparis['urun_adet'], 0, '', '.') ?></td>
                        <td><?= number_format($siparis['urun_fiyat'], 2, ',', '.') ?>₺</td>
                        <td><?= number_format(($siparis['urun_adet'] * $siparis['urun_fiyat']) * 0.18, 2, ',', '.') ?>₺</td>
                        <td><?= $siparis['toplam_fiyat'] ?>₺</td>
                        <td>
                          <?php
                          $statusText = "";
                          $btnClass = "";
                          $attr = "";
                          switch ($siparis['onay']) {
                            case -1:
                              $statusText = "Sipariş Beklemede";
                              $btnClass = "btn-change-status btn-warning";
                              break;
                            case 0:
                              $statusText = "Sipariş İptal Edildi";
                              $btnClass = "btn-danger";
                              $attr = 'disabled title="Bu işlem geri alınamaz!"';
                              break;
                            case 1:
                              $statusText = "Sipariş Onaylandı";
                              $btnClass = "btn-success";
                              $attr = 'disabled title="Bu işlem geri alınamaz!"';
                              break;
                          }
                          ?>
                          <a class="btn <?= $btnClass ?> text-white" data-id="<?= $siparis['id'] ?>" <?= $attr ?>><?= $statusText ?></a>
                        </td>

                        <td>
                          <?= $siparis['odeme_turu'] == 0
                            ? "<a class='btn btn-info text-white'>Kapıda Ödeme</a>"
                            : "<a class='btn btn-dark text-white'>Kart İle Ödeme</a>"
                          ?>
                        </td>
                        <td id='<?= isset($siparis['yeni_adet']) ? "row-{$siparis['id']}-urun" : "row-{$siparis['id']}-urun"  ?>'><?= isset($siparis['yeni_adet']) ? number_format($siparis['yeni_adet'], 0, '', '.') : number_format($siparis['urun_adet'], 0, '', '.') ?></td>

                        <td <?php if (isset($siparis['siparis_not']) && strlen(trim($siparis['siparis_not'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="left" title="' . $siparis['siparis_not'] . '"';
                            } ?>>
                          <?php
                          if (isset($siparis['siparis_not']) == '' || !isset($siparis['siparis_not'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($siparis['siparis_not']) > 15) {
                            echo substr($siparis['siparis_not'], 0, 15) . '...';
                          } else {
                            echo $siparis['siparis_not'];
                          } ?>
                        </td>

                        <td><?= $siparis['created_at'] ?></td>
                        <td>
                          <a href="javascript:void(0)" data-id="<?= $siparis['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $siparis['id'] ?>"></i>
                          </a>

                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $siparis['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $siparis['id'] ?>"></i>
                          </a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <form id="deleteForm"></form>
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
  <div class="modal fade" id="siparisModal" tabindex="-1" role="dialog" aria-labelledby="siparisModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="siparisModalLabel"><span id="spanSiparisId"></span> Nolu Siparişi Güncelle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <input type="hidden" name="siparisId" id="siparisId">
            <div class="form-group col-md-12">
              <label for="adet">Yeni Sipariş Adeti</label>
              <input type="number" class="form-control" id="adet" name="adet" readonly>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
          <button type="button" class="btn btn-primary btn-siparis-guncelle" name="siparis_guncelle_admin">Güncelle</button>
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

          let urunRowQuery = `#row-${siparisID}-urun`;
          let urunAdetRow = document.querySelector(urunRowQuery);
          let urunAdet = document.querySelector('#adet');
          urunAdet.value = urunAdetRow.textContent;

          $('#siparisModal').modal('show');
        }

        if (element.classList.contains('btn-change-status')) {
          Swal.fire({
            title: "Sipariş Onay Durumu",
            text: 'Bu işlem geri alınamaz!',
            showDenyButton: true,
            icon: "info",
            confirmButtonText: "Onayla",
            confirmButtonColor: '#1e7e34',
            denyButtonText: `Reddet`
          }).then((result) => {
            if (result.isConfirmed) {
              let dataID = element.getAttribute('data-id');

              let body = {
                id: dataID,
                action: 'approveSiparisStatus'
              };

              let route = './app/Http/Controllers/Admin/OrderController';

              fetch(route, {
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
                if (data.onay) {
                  element.classList.remove("btn-warning");
                  element.classList.add("btn-success", "text-white");
                  element.textContent = "Sipariş Onaylandı";
                }

                toastr.success(data.message, 'Başarılı');

                setTimeout(() => {
                  location.reload();
                }, 1000);
              }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!')
              });
            } else if (result.isDenied) {
              let dataID = element.getAttribute('data-id');

              let body = {
                id: dataID,
                action: 'rejectSiparisStatus'
              };

              let route = './app/Http/Controllers/Admin/OrderController';

              fetch(route, {
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
                if (data.onay == 0) {
                  element.classList.remove("btn-warning");
                  element.classList.add("btn-danger", "text-white");
                  element.textContent = "Sipariş İptal Edildi";
                }

                toastr.success(data.message, 'Başarılı');

                setTimeout(() => {
                  location.reload();
                }, 1000);
              }).catch(error => {
                console.error('Bir hata oluştu:', error);
                toastr.error('Bir hata oluştu', 'Hata!')
              });
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
                action: 'deleteSiparis'
              };

              let route = './app/Http/Controllers/Admin/OrderController';

              fetch(route, {
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

      btnSiparisGuncelle.addEventListener('click', () => {
        let urunAdet = document.querySelector('#adet');
        let siparisId = document.querySelector('#siparisId');


        let body = {
          id: siparisId.value,
          adet: urunAdet.value,
          action: 'siparis-guncelle-admin'
        };
        console.log('siparisID: ', siparisId);

        const route = "./app/Http/Controllers/Admin/OrderController.php";

        fetch(route, {
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
          location.reload();
        }).catch(error => {
          console.error('Bir hata oluştu:', error);
          toastr.error('Bir hata oluştu', 'Hata!');
        });
      });

      <?php if (isset($_SESSION["fiyat_update_success_message"])) : ?>
        const commentSuccessMessage = "<?= $_SESSION["fiyat_update_success_message"] ?>";
        if (commentSuccessMessage) {
          toastr.success(commentSuccessMessage, 'Başarılı!');
          <?php unset($_SESSION["fiyat_update_success_message"]); ?>
        }
      <?php endif; ?>

      <?php if (isset($_SESSION["fiyat_update_error_message"])) : ?>
        const commentErrorMessage = "<?= $_SESSION["fiyat_update_error_message"] ?>";
        if (commentErrorMessage) {
          toastr.error(commentErrorMessage, 'Başarılı!');
          <?php unset($_SESSION["fiyat_update_error_message"]); ?>
        }
      <?php endif; ?>
    });
  </script>

  <?php require_once 'footer.php' ?>
