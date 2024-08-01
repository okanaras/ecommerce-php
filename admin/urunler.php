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
                <h3 class="card-title">Ürünler Tablosu</h3>

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
                  <?php if (isset($_SESSION["urun_delete_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['urun_delete_success_message'];
                      unset($_SESSION['urun_delete_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["urun_delete_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['urun_delete_error_message'];
                      unset($_SESSION['urun_delete_error_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["urun_update_success_message"])) { ?>
                    <div class="alert alert-success mt-2 w-25" role="alert">
                      <?php echo $_SESSION['urun_update_success_message'];
                      unset($_SESSION['urun_update_success_message']); ?>
                    </div>
                  <?php } else if (isset($_SESSION["urun_update_error_message"])) { ?>
                    <div class="alert alert-danger mt-2 w-25" role="alert">
                      <?php echo $_SESSION['urun_update_error_message'];
                      unset($_SESSION['urun_update_error_message']); ?>
                    </div>
                  <?php } ?>
                </div>
                <a href="urunler-ekle?kategoriId=<?= $_GET['kategoriId'] ?>" class="btn btn-success float-right mr-2">Ürün Ekle</a>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Resim</th>
                      <th>Id</th>
                      <th>Başlık</th>
                      <th>Model</th>
                      <th>Renk</th>
                      <th>Sıra</th>
                      <th>Adet</th>
                      <th>Durum</th>
                      <th>Öne Çıkarılsın Mı?</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $urunler = $baglanti->prepare("SELECT * FROM urunler WHERE kategori_id=:kategori_id ORDER BY id DESC");
                    $urunler->execute([
                      ":kategori_id" => $_GET["kategoriId"]
                    ]);
                    $urunlerCek = $urunler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($urunlerCek as $urun) {
                    ?>
                      <tr id=<?= "row-{$urun['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td>
                          <?php if (isset($urun['resim'])) { ?>
                            <img src="./public/assets/images/urunler/<?= $urun['resim'] ?>" alt="<?= $urun['resim'] ?>" title="<?= $urun['resim'] ?>" width="50" height="auto">
                          <?php } else {
                            echo '<span class="badge badge-info text-white">İlgili veriye ait görsel bulunmamaktadır.</span>';
                          } ?>
                        </td>

                        <td><?= $urun['id']   ?? '-' ?></td>

                        <td <?php if (isset($urun['baslik']) && strlen(trim($urun['baslik'])) > 15) {
                              echo 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $urun['baslik'] . '"';
                            } ?>>
                          <?php
                          if (!isset($urun['baslik'])) {
                            echo '<span class="badge badge-info text-white">---</span>';
                          } else if (strlen($urun['baslik']) > 15) {
                            echo substr($urun['baslik'], 0, 15) . '...';
                          } else {
                            echo $urun['baslik'];
                          } ?>
                        </td>
                        <td><?= $urun['model'] ?></td>
                        <td><?= $urun['renk'] ?></td>
                        <td><?= $urun['sira'] ?></td>
                        <td><?= $urun['adet'] ?></td>
                        <td>
                          <?= $urun['durum'] == 1
                            ? "<a class='btn btn-success btn-change-status text-white' data-id='{$urun['id']}'>Aktif</a>"
                            : "<a class='btn btn-danger btn-change-status text-white' data-id='{$urun['id']}'>Pasif</a>"
                          ?>
                        </td>
                        <td>
                          <?= $urun['is_featured'] == 1
                            ? "<a class='btn btn-success btn-change-feature-status text-white' data-id='{$urun['id']}'>Evet</a>"
                            : "<a class='btn btn-danger btn-change-feature-status text-white' data-id='{$urun['id']}'>Hayır</a>"
                          ?>
                        </td>

                        <td>
                          <a href="javascript:void(0)" data-id="<?= $urun['id'] ?>" class="btn btn-success btn-edit">
                            <i class="fa fa-pen btn-edit" data-id="<?= $urun['id'] ?>"></i>
                          </a>

                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $urun['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $urun['id'] ?>"></i>
                          </a>

                          <a href="cokluresim?id=<?= $urun['id'] ?>" class="btn btn-info">
                            Çoklu Resim
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
  <div class="modal fade" id="urunModal" tabindex="-1" role="dialog" aria-labelledby="urunModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="./app/controllers/Admin/ProductController.php" method="POST" enctype="multipart/form-data" id="urunGuncelleme">
          <div class="modal-header">
            <h5 class="modal-title" id="urunModalLabel">
              Urun Güncelleme</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <input type="hidden" name="id" id="urunId">

              <div class="form-group col-md-12" id="resimDiv">
                <label for="resim">Ürün Görseli</label>
                <input type="file" class="form-control" id="resim" name="resim">
              </div>

              <div class="form-group col-md-6">
                <label for="baslik">Ürün Başlık</label>
                <input type="text" class="form-control" id="baslik" name="baslik" required placeholder="Ürün başlığı giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="kategori_id">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-control select2" style="width: 100%;">
                  <option value="-1">Ürün Kategorisi Seçiniz</option>
                  <?php
                  $kategoriler = $baglanti->prepare("SELECT * FROM kategori order by id DESC");
                  $kategoriler->execute();
                  $kategorilerCek = $kategoriler->fetchAll(PDO::FETCH_ASSOC);
                  $index = 1;

                  foreach ($kategorilerCek as $kategori) {
                  ?>
                    <option value="<?= $kategori['id'] ?>" <?=
                                                            $kategori['id'] == $_GET['kategoriId'] ?  'selected' : ''
                                                            ?>>
                      <?= $kategori['ad'] ?>
                    </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label for="sira">Ürün Sıra</label>
                <input type="number" class="form-control" id="sira" name="sira" required placeholder="Ürün sırası giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="model">Ürün Model</label>
                <input type="text" class="form-control" id="model" name="model" required placeholder="Ürün model giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="renk">Ürün Renk</label>
                <input type="text" class="form-control" id="renk" name="renk" required placeholder="Ürün rengi giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="adet">Ürün Adet</label>
                <input type="number" class="form-control" id="adet" name="adet" required placeholder="Ürün adeti giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="fiyat">Ürün Fiyat</label>
                <input type="text" class="form-control" id="fiyat" name="fiyat" required placeholder="Ürün fiyatı giriniz">
              </div>

              <div class="form-group col-md-6">
                <label for="etiket">Ürün Seo Keywords</label>
                <input type="text" class="form-control" id="etiket" name="etiket" required placeholder="Ürün seo kelimelerini giriniz">
              </div>

              <div class="form-group col-md-6">
                <label>Durum</label>
                <select name="durum" id="durum" class="form-control select2" style="width: 100%;">
                  <option value="-1">Ürün Durumu Seçiniz</option>
                  <option value="0">Pasif</option>
                  <option value="1">Aktif</option>
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>Ürün Öne Çıkarılsın Mı?</label>
                <select name="is_featured" id="is_featured" class="form-control select2" style="width: 100%;">
                  <option value="-1">Ürün Çıkarılma Durumu Seçiniz</option>
                  <option value="0">Hayır</option>
                  <option value="1">Evet</option>
                </select>
              </div>

              <div class="form-group col-md-12">
                <label for="aciklama">Ürün Açıklama</label>
                <textarea class="form-control" id="aciklama" name="aciklama" rows="4"></textarea>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            <button type="submit" class="btn btn-primary" name="urun_guncelle">Güncelle</button>
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

          fetch(`./app/controllers/Admin/ProductController.php?action=getUrunler&id=${dataID}`)
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              const urunler = data.urunler;

              document.querySelector('#urunId').value = urunler.id;
              document.querySelector('#baslik').value = urunler.baslik;
              document.querySelector('#aciklama').value = urunler.aciklama;
              document.querySelector('#sira').value = urunler.sira;
              document.querySelector('#model').value = urunler.model;
              document.querySelector('#renk').value = urunler.renk;
              document.querySelector('#adet').value = urunler.adet;
              document.querySelector('#fiyat').value = urunler.fiyat;
              document.querySelector('#etiket').value = urunler.etiket;
              document.querySelector('#durum').value = urunler.durum;
              document.querySelector('#is_featured').value = urunler.is_featured;
              document.querySelector('#kategori_id').value = urunler.kategori_id;

              if (urunler.resim) {
                let resimDiv = document.querySelector('#resimDiv');
                resimDiv.classList.remove("col-md-12");
                resimDiv.classList.add("col-md-6");

                let createWrapperImgDiv = document.createElement('div');
                createWrapperImgDiv.classList.add("form-group", "col-md-6");

                let createImgLabel = document.createElement('label');
                createImgLabel.setAttribute("for", "img_label");
                createImgLabel.textContent = "Mevcut Ürün Görseli";

                let createImgDiv = document.createElement('div');

                let createImg = document.createElement('img');
                createImg.setAttribute('width', '100');
                createImg.setAttribute('height', 'auto');
                createImg.setAttribute('src', `./public/assets/images/urunler/${urunler.resim}`);
                createImg.setAttribute('alt', `${urunler.baslik}`);

                createImgDiv.appendChild(createImg);

                createWrapperImgDiv.appendChild(createImgLabel);
                createWrapperImgDiv.appendChild(createImgDiv);

                resimDiv.insertAdjacentElement('afterend', createWrapperImgDiv);
              }

              $('#urunModal').modal('show');
            })
            .catch(error => {
              console.error('Bir hata oluştu:', error);
              toastr.error('Bir hata oluştu', 'Hata!');
            });
        }

        if (element.classList.contains('btn-change-feature-status')) {
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
                'action': 'changeUrunFeatureStatus'
              };

              fetch('./app/controllers/Admin/ProductController.php', {
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
                if (data.is_featured) {
                  element.classList.add("btn-success", "text-white");
                  element.classList.remove('btn-danger');
                  element.textContent = "Evet";
                } else {

                  element.classList.remove("btn-success");
                  element.classList.add('btn-danger', "text-white");
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
                'action': 'changeUrunStatus'
              };

              fetch('./app/controllers/Admin/ProductController.php', {
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
                action: 'deleteUrun'
              };

              fetch('./app/controllers/Admin/ProductController.php', {
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
