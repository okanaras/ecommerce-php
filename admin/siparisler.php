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
                      <th>#</th>
                      <th>Sipariş Id</th>
                      <th>Kullanıcı Id</th>
                      <th>Ürün Adet</th>
                      <th>Ürün Fiyat</th>
                      <th>Toplam Fiyat</th>
                      <th>Ödeme Durumu</th>
                      <th>Sipariş Tarihi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $siparisler = $baglanti->prepare("SELECT * FROM siparisler ORDER BY id DESC");
                    $siparisler->execute();
                    $siparislerCek = $siparisler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($siparislerCek as $siparis) {
                    ?>
                      <tr id=<?= "row-{$siparis['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><?= $siparis['id']   ?? '-' ?></td>
                        <td><?= $siparis['user_id']   ?? '-' ?></td>
                        <td><?= $siparis['urun_adet'] ?></td>
                        <td><?= $siparis['urun_fiyat'] ?></td>
                        <td><?= $siparis['toplam_fiyat'] ?></td>
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

  <!-- Button trigger modal -->


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelector('.table').addEventListener('click', function(event) {
        let element = event.target;

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
