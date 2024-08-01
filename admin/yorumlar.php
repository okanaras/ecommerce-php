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
                <h3 class="card-title">Yorumlar Tablosu</h3>

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
                  <?php if (isset($_SESSION["yorum_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['yorum_delete_error_message'];
                      unset($_SESSION['yorum_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["yorum_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['yorum_update_success_message'];
                      unset($_SESSION['yorum_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["yorum_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['yorum_update_error_message'];
                      unset($_SESSION['yorum_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Detayı</th>
                      <th>Ürün Id</th>
                      <th>Kullanıcı Id</th>
                      <th>Onay</th>
                      <th>Spam mı?</th>
                      <th>Oluşturulma Tarihi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $yorumlar = $baglanti->prepare("SELECT * FROM yorumlar ORDER BY id DESC");
                    $yorumlar->execute();
                    $yorumlarCek = $yorumlar->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($yorumlarCek as $yorum) {
                    ?>
                      <tr id=<?= "row-{$yorum['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><?= $yorum['id']   ?? '-' ?></td>
                        <td><?= $yorum['detay']   ?? '-' ?></td>
                        <td><?= $yorum['urun_id']  ?? '-' ?></td>
                        <td><?= $yorum['user_id']  ?? '-' ?></td>
                        <td>
                          <?= $yorum['onay'] == 1
                            ? "<a class='btn btn-success btn-change-status text-white' data-id='{$yorum['id']}'>Aktif</a>"
                            : "<a class='btn btn-danger btn-change-status text-white' data-id='{$yorum['id']}'>Pasif</a>"
                          ?>
                        </td>
                        <td>
                          <?= $yorum['is_spam'] == 1
                            ? "<a class='btn btn-dark btn-change-spam-status text-white' data-id='{$yorum['id']}'>Evet</a>"
                            : "<a class='btn btn-info btn-change-spam-status text-white' data-id='{$yorum['id']}'>Hayır</a>"
                          ?>
                        </td>
                        <td><?= $yorum['created_at']  ?? '-' ?></td>


                        <td>
                          <a href="javascript:void(0)" data-id="<?= $yorum['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $yorum['id'] ?>"></i>
                          </a>
                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $yorum['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $yorum['id'] ?>"></i>
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
  <div class="modal fade" id="yorumModal" tabindex="-1" role="dialog" aria-labelledby="yorumModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="./app/Http/Controllers/Front/CommentController" method="POST" enctype="multipart/form-data" id="yorumGuncelleme">
          <div class="modal-header">
            <h5 class="modal-title" id="yorumModalLabel">
              Yorum Güncelleme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="yorumId">
            <div class="form-group">
              <label for="yorumDetay">Yorum Detayı</label>
              <input type="text" class="form-control" id="yorumDetay" name="detay" placeholder="Yorum adı giriniz">
            </div>
            <div class="form-group">
              <label for="yorumOnay">Onay</label>
              <select name="onay" id="yorumOnay" class="form-control select2" style="width: 100%;">
                <option value="-1">Yorum Onay Durumu Seçiniz</option>
                <option value="0">Pasif</option>
                <option value="1">Aktif</option>
              </select>
            </div>

            <div class="form-group">
              <label for="yorumSpam">Spam</label>
              <select name="is_spam" id="yorumSpam" class="form-control select2" style="width: 100%;">
                <option value="-1">Spam mı?
                </option>
                <option value="0">Hayır</option>
                <option value="1">Evet</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            <button type="submit" class="btn btn-primary" name="yorum_guncelle">Güncelle</button>
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

          fetch(`./app/Http/Controllers/Front/CommentController?action=getComment&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              const comment = data.comment;
              document.querySelector('#yorumId').value = comment.id;
              document.querySelector('#yorumDetay').value = comment.detay;
              document.querySelector('#yorumSpam').value = comment.is_spam;
              document.querySelector('#yorumOnay').value = comment.onay;

              $('#yorumModal').modal('show');
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
                'action': 'changeCommentStatus'
              };

              fetch('./app/Http/Controllers/Front/CommentController', {
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
                  element.textContent = "Aktif";
                } else {
                  element.classList.remove("btn-success");
                  element.classList.add("btn-danger", "text-white");
                  element.textContent = "Pasif";
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

        if (element.classList.contains('btn-change-spam-status')) {
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
                'action': 'changeSpamStatus'
              };

              fetch('./app/Http/Controllers/Front/CommentController', {
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
                  element.classList.add("btn-dark", "text-white");
                  element.classList.remove("btn-info");
                  element.textContent = "Evet";
                } else {
                  element.classList.remove("btn-dark");
                  element.classList.add("btn-info", "text-white");
                  element.textContent = "Hayır";
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
                action: 'deleteComment'
              };

              fetch('./app/Http/Controllers/Front/CommentController', {
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
