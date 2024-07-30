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
                      <th>Fiyat Yazısı</th>
                      <th>İndirim Miktari Yazısı</th>
                      <th>Link</th>
                      <th>Sıra</th>
                      <th>Durum</th>
                      <th>Banner</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sliderlar = $baglanti->prepare("SELECT * FROM slider ORDER BY sira DESC");
                    $sliderlar->execute();
                    $sliderlarCek = $sliderlar->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($sliderlarCek as $slider) {
                    ?>
                      <tr id=<?= "row-{$slider['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td>
                          <?php if (isset($slider['resim'])) { ?>
                            <img src="./public/assets/images/slider/<?= $slider['resim'] ?>" alt="<?= $slider['resim'] ?>" title="<?= $slider['resim'] ?>" width="50" height="auto">
                          <?php } else {
                            echo '<span class="badge badge-info text-white">İlgili veriye ait görsel bulunmamaktadır.</span>';
                          } ?>
                        </td>

                        <td><?= $slider['id']   ?? '-' ?></td>

                        <td <?php if (isset($slider['baslik']) && strlen(trim($slider['baslik'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $slider['baslik'] . '"';
                            } ?>>
                          <?php
                          if (!isset($slider['baslik'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($slider['baslik']) > 15) {
                            echo substr($slider['baslik'], 0, 15) . '...';
                          } else {
                            echo $slider['baslik'];
                          } ?>
                        </td>
                        <td <?php if (isset($slider['aciklama']) && strlen(trim($slider['aciklama'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $slider['aciklama'] . '"';
                            } ?>>
                          <?php
                          if (!isset($slider['aciklama'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($slider['aciklama']) > 15) {
                            echo substr($slider['aciklama'], 0, 15) . '...';
                          } else {
                            echo $slider['aciklama'];
                          } ?>
                        </td>
                        <td <?php if (isset($slider['fiyat_yazisi']) && strlen(trim($slider['fiyat_yazisi'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $slider['fiyat_yazisi'] . '"';
                            } ?>>
                          <?php
                          if (!isset($slider['fiyat_yazisi'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($slider['fiyat_yazisi']) > 15) {
                            echo substr($slider['fiyat_yazisi'], 0, 15) . '...';
                          } else {
                            echo $slider['fiyat_yazisi'];
                          } ?>
                        </td>
                        <td <?php if (isset($slider['indirim_miktari_yazisi']) && strlen(trim($slider['indirim_miktari_yazisi'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $slider['indirim_miktari_yazisi'] . '"';
                            } ?>>
                          <?php
                          if (!isset($slider['indirim_miktari_yazisi'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($slider['indirim_miktari_yazisi']) > 15) {
                            echo substr($slider['indirim_miktari_yazisi'], 0, 15) . '...';
                          } else {
                            echo $slider['indirim_miktari_yazisi'];
                          } ?>
                        </td>
                        <td <?php if (isset($slider['link']) && strlen(trim($slider['link'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $slider['link'] . '"';
                            } ?>>
                          <?php
                          if (!isset($slider['link'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($slider['link']) > 15) {
                            echo substr($slider['link'], 0, 15) . '...';
                          } else {
                            echo $slider['link'];
                          } ?>
                        </td>
                        <td><?= $slider['sira'] ?></td>
                        <td>
                          <?= $slider['durum'] == 1
                            ? "<a class='btn btn-success btn-change-status text-white' data-id='{$slider['id']}'>Aktif</a>"
                            : "<a class='btn btn-danger btn-change-status text-white' data-id='{$slider['id']}'>Pasif</a>"
                          ?>
                        </td>
                        <td>
                          <?= $slider['banner'] == 0
                            ? "<a class='btn btn-info btn-change-slider-status text-white' data-id='{$slider['id']}'>Slider</a>"
                            : "<a class='btn btn-dark btn-change-slider-status text-white' data-id='{$slider['id']}'>Banner</a>"
                          ?>
                        </td>

                        <td>
                          <a href="javascript:void(0)" data-id="<?= $slider['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $slider['id'] ?>"></i>
                          </a>

                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $slider['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $slider['id'] ?>"></i>
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
            <div class="row">
              <input type="hidden" name="id" id="sliderId">

              <div class="form-group col-md-12">
                <label for="sliderResim">Slider Görseli</label>
                <input type="file" class="form-control" id="sliderResim" name="resim">
              </div>

              <div class="form-group col-md-6">
                <label for="sliderBaslik">Slider Başlık</label>
                <input type="text" class="form-control" id="sliderBaslik" name="baslik" placeholder="Slider başlığı giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="sliderAciklama">Slider Açıklama</label>
                <input type="text" class="form-control" id="sliderAciklama" name="aciklama" placeholder="Slider açıklaması giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="sliderLink">Slider Link</label>
                <input type="text" class="form-control" id="sliderLink" name="link" placeholder="Slider linki giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="sliderSira">Slider Sırası</label>
                <input type="number" class="form-control" id="sliderSira" name="sira" placeholder="Slider sırası giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="sliderDurum">Durum</label>
                <select name="durum" id="sliderDurum" class="form-control select2" style="width: 100%;">
                  <option value="-1">Slider Durumu Seçiniz</option>
                  <option value="0">Pasif</option>
                  <option value="1">Aktif</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="sliderBanner">Slider & Banner</label>
                <select id="sliderBanner" name="slider_banner" class="form-control select2" style="width: 100%;">
                  <option value="-1">Slider & Banner Durumu Seçiniz</option>
                  <option value="0">Slider</option>
                  <option value="1">Banner</option>
                </select>
              </div>

              <div class="form-group col-md-6 slider-fields">
                <label for="sliderFiyatYazisi">Slider Fiyat Yazısı</label>
                <input type="text" class="form-control" id="sliderFiyatYazisi" name="fiyat_yazisi" placeholder="Slider fiyat yazısı giriniz">
              </div>

              <div class="form-group col-md-6 slider-fields">
                <label for="sliderIndirimYazisi">Slider İndirim Miktarı Yazısı</label>
                <input type="text" class="form-control" id="sliderIndirimYazisi" name="indirim_miktari_yazisi" placeholder="Slider indirim miktarı yazısı giriniz">
              </div>


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
                    document.querySelector('#sliderId').value = data.slider.id;
                    document.querySelector('#sliderBaslik').value = data.slider.baslik;
                    document.querySelector('#sliderAciklama').value = data.slider.aciklama;
                    document.querySelector('#sliderSira').value = data.slider.sira;
                    document.querySelector('#sliderLink').value = data.slider.link;
                    document.querySelector('#sliderDurum').value = data.slider.durum;
                    document.querySelector('#sliderBanner').value = data.slider.banner;
                    document.querySelector('#sliderFiyatYazisi').value = data.slider.fiyat_yazisi;
                    document.querySelector('#sliderIndirimYazisi').value = data.slider.indirim_miktari_yazisi;

                    // Call function to set visibility of fields
                    checkForSliderFields();

                    $('#sliderModal').modal('show');
                  })
                  .catch(error => {
                    console.error('Bir hata oluştu:', error);
                    toastr.error('Bir hata oluştu', 'Hata!');
                  });
                }

                if (element.classList.contains('btn-change-slider-status')) {
                  Swal.fire({
                    title: "Değişiklik yapmak istediğinize emin misiniz?",
                    showDenyButton: true,
                    icon: "info",
                    confirmButtonText: "Evet",
                    denyButtonText: `Hayır`
                  }).then((result) => {
                    if (result.isConfirmed) {
                      let dataID = element.getAttribute('data-id');

                      let body = {
                        id: dataID,
                        'action': 'changeSliderBannerStatus'
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
                        if (data.banner) {
                          element.classList.remove("btn-info");
                          element.classList.add('btn-dark', "text-white");
                          element.textContent = "Banner";
                        } else {
                          element.classList.add("btn-info", "text-white");
                          element.classList.remove('btn-dark');
                          element.textContent = "Slider";
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

                if (element.classList.contains('btn-change-status')) {
                  Swal.fire({
                    title: "Değişiklik yapmak istediğinize emin misiniz?",
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

            const sliderBannerSelect = document.getElementById('sliderBanner');
            const sliderFields = document.querySelectorAll('.slider-fields');

            function checkForSliderFields() {
              if (sliderBannerSelect.value == '0') {
                sliderFields.forEach(field => field.style.display = 'block');
              } else {
                sliderFields.forEach(field => field.style.display = 'none');
              }
            }

            sliderBannerSelect.addEventListener('change', checkForSliderFields); checkForSliderFields(); // Initialize visibility on page load

          });
  </script>

  <?php require_once 'footer.php' ?>
