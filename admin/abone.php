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
                <h3 class="card-title">Aboneler Tablosu</h3>

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
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Abone Email</th>
                      <th>Abonelik Tarihi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $aboneler = $baglanti->prepare("SELECT * FROM abone ORDER BY id DESC");
                    $aboneler->execute();
                    $abonelerCek = $aboneler->fetchAll(PDO::FETCH_ASSOC);
                    $index = 1;

                    foreach ($abonelerCek as $abone) {
                    ?>
                      <tr id=<?= "row-{$abone['id']}" ?>>
                        <td><?= $index++ ?></td>
                        <td><?= $abone['abone_email']   ?? '-' ?></td>
                        <td><?= $abone['created_at']  ?? '-' ?></td>
                        <td>
                          <a href="javascript:void(0)" class="btn btn-danger btn-delete" data-id="<?= $abone['id'] ?>">
                            <i class="fa fa-trash btn-delete" data-id="<?= $abone['id'] ?>"></i>
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

  <!-- Button trigger modal -->


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelector('.table').addEventListener('click', (event) => {
        let element = event.target;

        if (element.classList.contains("btn-delete")) {
          Swal.fire({
            title: "Silmek istediğinize emin misiniz?",
            showDenyButton: true,
            icon: "info",
            confirmButtonText: "Evet",
            denyButtonText: `Hayır`
          }).then((result) => {
            if (result.isConfirmed) {
              let dataID = element.getAttribute('data-id');

              let body = {
                id: dataID,
                action: 'deleteAbone'
              };

              const route = "./app/Http/Controllers/Front/AboneController";

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
                console.log('data: ', data);
                let row = document.querySelector(`#row-${data.id}`);
                row.remove();
                console.log('row: ', row);

                toastr.success(data.message, 'Başarılı');
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
