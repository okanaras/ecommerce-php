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
                <h3 class="card-title">Resimler Tablosu</h3>

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
                <label class="m-2">Çoklu Resim Yükleme</label>
                <form action="./app/Http/Controllers/Admin/MultipleImageController" method="POST" class="dropzone m-2" enctype="multipart/form-data">
                  <input type="hidden" name="urunId" value="<?= $_GET['id'] ?>">
                </form>

                <div class="form-group m-2">
                  <?php if (isset($_SESSION["resim_delete_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['resim_delete_success_message'];
                      unset($_SESSION['resim_delete_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["resim_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['resim_delete_error_message'];
                      unset($_SESSION['resim_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["resim_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['resim_update_success_message'];
                      unset($_SESSION['resim_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["resim_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['resim_update_error_message'];
                      unset($_SESSION['resim_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <a href="resim-ekle" class="btn btn-success float-right mr-2">Resim Ekle</a>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Id</th>
                      <th>Resim</th>
                      <th>Urun Id</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $resimler = $baglanti->prepare("SELECT * FROM cokluresim WHERE urun_id=:urun_id ORDER BY id DESC");
                    $resimler->execute([':urun_id' => $_GET['id']]);
                    $resimlerCek = $resimler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($resimlerCek as $resim) {
                    ?>
                      <tr id=<?= "row-{$resim['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><?= $resim['id']   ?? '-' ?></td>
                        <td>
                          <?php if (isset($resim['resim'])) { ?>
                            <img src="./public/assets/images/cokluresim/<?= $resim['resim'] ?>" alt="<?= $resim['resim'] ?>" title="<?= $resim['resim'] ?>" width="125" height="auto">
                          <?php } else {
                            echo '<span class="badge badge-info text-white">İlgili veriye ait görsel bulunmamaktadır.</span>';
                          } ?>
                        </td>

                        <td><?= $resim['urun_id']   ?? '-' ?></td>
                        <td>
                          <a href="javascript:void(0)" data-id="<?= $resim['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $resim['id'] ?>"></i>
                          </a>

                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $resim['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $resim['id'] ?>"></i>
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

        if (element.classList.contains('btn-edit')) {
          let dataID = element.getAttribute('data-id');

          fetch(`islem/islem.php?action=getResim&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              document.querySelector('#resimId').value = data.resim.id;
              document.querySelector('#resimBaslik').value = data.resim.baslik;
              document.querySelector('#resimAciklama').value = data.resim.aciklama;
              document.querySelector('#resimSira').value = data.resim.sira;
              document.querySelector('#resimLink').value = data.resim.link;
              document.querySelector('#resimDurum').value = data.resim.durum;
              document.querySelector('#resimBanner').value = data.resim.banner;
              document.querySelector('#resimFiyatYazisi').value = data.resim.fiyat_yazisi;
              document.querySelector('#resimIndirimYazisi').value = data.resim.indirim_miktari_yazisi;

              // Call function to set visibility of fields
              checkForResimFields();

              $('#resimModal').modal('show');
            })
            .catch(error => {
              console.error('Bir hata oluştu:', error);
              toastr.error('Bir hata oluştu', 'Hata!');
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
                action: 'deleteResim'
              };

              fetch('./app/Http/Controllers/Admin/MultipleImageController.php', {
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
