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
                <h3 class="card-title">Kategoriler Tablosu</h3>

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
                  <?php if (isset($_SESSION["kategoriler_delete_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['kategoriler_delete_success_message'];
                      unset($_SESSION['kategoriler_delete_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["kategoriler_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['kategoriler_delete_error_message'];
                      unset($_SESSION['kategoriler_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["kategori_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['kategori_update_success_message'];
                      unset($_SESSION['kategori_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["kategori_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['kategori_update_error_message'];
                      unset($_SESSION['kategori_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <a href="kategori-ekle" class="btn btn-success float-right mr-2">Kategori Ekle</a>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Adı</th>
                      <th>Sıra</th>
                      <th>Durum</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $kategoriler = $baglanti->prepare("SELECT * FROM kategori order by id DESC");
                    $kategoriler->execute();
                    $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($kategorilerCek as $kategori) {
                    ?>
                      <tr id=<?= "row-{$kategori['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><?= $kategori['id']   ?? '-' ?></td>
                        <td><?= $kategori['ad']   ?? '-' ?></td>
                        <td><?= $kategori['sira']  ?? '-' ?></td>
                        <td>
                          <?= $kategori['durum'] == 1
                            ? "<a class='btn btn-success btn-change-status text-white' data-id='{$kategori['id']}'>Aktif</a>"
                            : "<a class='btn btn-danger btn-change-status text-white' data-id='{$kategori['id']}'>Pasif</a>"
                          ?>
                        </td>

                        <td>
                          <a href="javascript:void(0)" data-id="<?= $kategori['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $kategori['id'] ?>"></i>
                          </a>
                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $kategori['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $kategori['id'] ?>"></i>
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


  <!-- Modal -->
  <div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="islem/islem.php" method="POST" enctype="multipart/form-data" id="kategoriGuncelleme">
          <div class="modal-header">
            <h5 class="modal-title" id="kategoriModalLabel">
              Kategori Güncelleme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="kategoriId">
            <div class="form-group">
              <label for="kategoriAdi">Kategori Adı</label>
              <input type="text" class="form-control" id="kategoriAdi" name="ad" placeholder="Kategori adı giriniz">
            </div>
            <div class="form-group">
              <label for="kategoriSira">Kategori
                Sırası</label>
              <input type="number" class="form-control" id="kategoriSira" name="sira" placeholder="Kategori sırası giriniz">
            </div>
            <div class="form-group">
              <label for="kategoriDurum">Durum</label>
              <select name="durum" id="kategoriDurum" class="form-control select2" style="width: 100%;">
                <option value="-1">Kategori Durumu Seçiniz
                </option>
                <option value="0">Pasif</option>
                <option value="1">Aktif</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            <button type="submit" class="btn btn-primary" name="kategori_guncelle">Güncelle</button>
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

          fetch(`islem/islem.php?action=getCategory&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              document.querySelector('#kategoriId').value = data.category.id;
              document.querySelector('#kategoriAdi').value = data.category.ad;
              document.querySelector('#kategoriSira').value = data.category.sira;
              document.querySelector('#kategoriDurum').value = data.category.durum;

              $('#kategoriModal').modal('show');
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
                'action': 'changeCategoryStatus'
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
                if (data.durum) {
                  element.classList.add("btn-success", "text-white");
                  element.classList.remove("btn-danger");
                } else {
                  element.classList.remove("btn-success");
                  element.classList.add("btn-danger", "text-white");
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
                action: 'deleteCategory'
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
