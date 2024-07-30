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
                <h3 class="card-title">Sliderlar Tablosu</h3>

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
                  <?php if (isset($_SESSION["slider_delete_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['slider_delete_success_message'];
                      unset($_SESSION['slider_delete_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["slider_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['slider_delete_error_message'];
                      unset($_SESSION['slider_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["slider_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['slider_update_success_message'];
                      unset($_SESSION['slider_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["slider_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['slider_update_error_message'];
                      unset($_SESSION['slider_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <a href="slider-ekle" class="btn btn-success float-right mr-2">Slider Ekle</a>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Resim</th>
                      <th>Id</th>
                      <th>Başlık</th>
                      <th>Açıklama</th>
                      <th>Link</th>
                      <th>Sıra</th>
                      <th>Banner</th>
                      <th>Durum</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $Sliderlar = $baglanti->prepare("SELECT * FROM slider order by id DESC");
                    $Sliderlar->execute();
                    $SliderlarCek = $Sliderlar->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($SliderlarCek as $slider) {
                    ?>
                      <tr id=<?= "row-{$slider['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><img src="./public/assets/images/slider/<?= $slider['resim'] ?>" alt="<?= $slider['resim'] ?>" title="<?= $slider['resim'] ?>" width="50" height="auto"></td>
                        <td><?= $slider['id']   ?? '-' ?></td>
                        <td><?= $slider['baslik']   ?? '-' ?></td>
                        <td><?= $slider['aciklama']   ?? '-' ?></td>
                        <td><?= $slider['link']   ?? '-' ?></td>
                        <td><?= $slider['sira']  ?? '-' ?></td>
                        <td>
                          <?= $slider['banner'] == 1
                            ? "<a class='btn btn-info btn-change-slider-status' data-id='{$slider['id']}'><span class='text-white btn-change-slider-status' data-id='{$slider['id']}'>Slider</span></a>"
                            : "<a class='btn btn-dark btn-change-slider-status' data-id='{$slider['id']}'><span class='text-white btn-change-slider-status' data-id='{$slider['id']}'>Banner</span></a>"
                          ?>
                        </td>
                        <td>
                          <?= $slider['durum'] == 1
                            ? "<a class='btn btn-success btn-change-status' data-id='{$slider['id']}'><span class='text-white btn-change-status' data-id='{$slider['id']}'>Aktif</span></a>"
                            : "<a class='btn btn-danger btn-change-status' data-id='{$slider['id']}'><span class='text-white btn-change-status' data-id='{$slider['id']}'>Pasif</span></a>"
                          ?>
                        </td>

                        <td>
                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $slider['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $slider['id'] ?>"></i>
                          </a>

                          <a href="javascript:void(0)" data-id="<?= $slider['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $slider['id'] ?>"></i>
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
  <div class="modal fade" id="sliderModal" tabindex="-1" role="dialog" aria-labelledby="sliderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="islem/islem.php" method="POST" enctype="multipart/form-data" id="sliderGuncelleme">
          <div class="modal-header">
            <h5 class="modal-title" id="sliderModalLabel">
              Slider Güncelleme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="sliderId">

            <div class="form-group">
              <label for="sliderResim">Slider Görseli</label>
              <input type="file" class="form-control" id="sliderResim" name="resim">
            </div>

            <div class="form-group">
              <label for="sliderBaslik">Slider Başlık</label>
              <input type="text" class="form-control" id="sliderBaslik" name="baslik" placeholder="Slider başlığı giriniz">
            </div>

            <div class="form-group">
              <label for="sliderAciklama">Slider Açıklama</label>
              <input type="text" class="form-control" id="sliderAciklama" name="aciklama" placeholder="Slider açıklaması giriniz">
            </div>


            <div class="form-group">
              <label for="sliderSira">Slider Sırası</label>
              <input type="number" class="form-control" id="sliderSira" name="sira" placeholder="Slider sırası giriniz">
            </div>

            <div class="form-group">
              <label for="sliderLink">Slider Link</label>
              <input type="text" class="form-control" id="sliderLink" name="link" placeholder="Slider linki giriniz">
            </div>

            <div class="form-group">
              <label for="sliderButton">Slider Button</label>
              <input type="text" class="form-control" id="sliderButton" name="button" placeholder="Slider buttonu giriniz">
            </div>

            <div class="form-group">
              <label for="sliderDurum">Durum</label>
              <select name="durum" id="sliderDurum" class="form-control select2" style="width: 100%;">
                <option value="-1">Slider Durumu Seçiniz</option>
                <option value="0">Pasif</option>
                <option value="1">Aktif</option>
              </select>
            </div>

            <div class="form-group">
              <label for="sliderBanner">Slider & Banner</label>
              <select id="sliderBanner" name="slider_banner" class="form-control select2" style="width: 100%;">
                <option value="-1">Slider & Banner Durumu Seçiniz</option>
                <option value="0">Banner</option>
                <option value="1">Slider</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            <button type="submit" class="btn btn-primary" name="slider_guncelle">Güncelle</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelector('.table').addEventListener('click', function(event) {
        let element = event.target;

        if (element.classList.contains('btn-edit')) {
          let dataID = element.getAttribute('data-id');

          fetch(`islem/islem.php?action=getSlider&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              console.log('data: ', data);
              document.querySelector('#sliderId').value = data.slider.id;
              document.querySelector('#sliderBaslik').value = data.slider.baslik;
              document.querySelector('#sliderAciklama').value = data.slider.sira;
              document.querySelector('#sliderSira').value = data.slider.sira;
              document.querySelector('#sliderLink').value = data.slider.link;
              document.querySelector('#sliderButton').value = data.slider.button;
              document.querySelector('#sliderDurum').value = data.slider.durum;
              document.querySelector('#sliderBanner').value = data.slider.banner;

              $('#sliderModal').modal('show');
            })
            .catch(error => {
              console.error('Bir hata oluştu:', error);
              toastr.error('Bir hata oluştu', 'Hata!');
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
                'action': 'changeSliderStatus'
              };

              if (element.tagName === "SPAN") {
                element = element.parentElement;
              }

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
                  element.classList.add("btn-success");
                  element.classList.remove('btn-danger');
                } else {
                  element.classList.remove("btn-success");
                  element.classList.add('btn-danger');
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
                action: 'deleteSlider'
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
