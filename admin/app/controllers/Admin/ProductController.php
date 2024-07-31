<?php

session_start();

require_once "../../../database/baglanti.php";

if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

/***** urunler *****/
if (isset($_POST['urunler_kaydet'])) {
  $baslik = $_POST['baslik'];
  $aciklama = $_POST['aciklama'];
  $kategori_id = $_POST['kategori_id'];
  $model = $_POST['model'];
  $renk = $_POST['renk'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];
  $adet = $_POST['adet'];
  $fiyat = $_POST['fiyat'];
  $etiket = $_POST['etiket'];
  $is_featured = $_POST['is_featured'];
  $created_at = date('Y-m-d H:i:s');
  

  $resim = $_FILES['resim'];

  if ($durum == '-1') {
    $durum = 0;
  } else if ($is_featured == '-1') {
    $is_featured = 0;
  }


  if (isset($resim) && $resim['size']) {
    $uploads_dir = "../../../public/assets/images/urunler";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His');
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");


    $sql = "INSERT INTO urunler SET baslik=:baslik, aciklama=:aciklama, kategori_id=:kategori_id, model=:model, renk=:renk, sira=:sira, adet=:adet, fiyat=:fiyat, etiket=:etiket, is_featured=:is_featured, durum=:durum, resim=:resim, created_at=:created_at";
    $stmt = $baglanti->prepare($sql);

    $insert = $stmt->execute([
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":kategori_id" => $kategori_id,
      ":model" => $model,
      ":renk" => $renk,
      ":sira" => $sira,
      ":adet" => $adet,
      ":fiyat" => $fiyat,
      ":etiket" => $etiket,
      ":is_featured" => $is_featured,
      ":durum" => $durum,
      ":created_at" => $created_at,
      ":resim" => $imagePath
    ]);
  } else {
    $sql = "INSERT INTO urunler SET baslik=:baslik, aciklama=:aciklama, kategori_id=:kategori_id, model=:model, renk=:renk, sira=:sira, adet=:adet, fiyat=:fiyat, etiket=:etiket, is_featured=:is_featured, durum=:durum, created_at=:created_at";
    $stmt = $baglanti->prepare($sql);

    $insert = $stmt->execute([
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":kategori_id" => $kategori_id,
      ":model" => $model,
      ":renk" => $renk,
      ":sira" => $sira,
      ":adet" => $adet,
      ":fiyat" => $fiyat,
      ":etiket" => $etiket,
      ":is_featured" => $is_featured,
      ":durum" => $durum,
      ":created_at" => $created_at
    ]);
  }

  if ($insert) {
    $_SESSION["urunler-ekle_store_success_message"] = "Ürünler başarıyla eklendi.";
    Header("Location: ../../../urunler?kategoriId={$kategori_id}");
  } else {
    $_SESSION["urunler-ekle_store_error_message"] = "Kayıt işlemi başarısız.";
    Header("Location: ../../../urunler?kategoriId={$kategori_id}");
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'getUrunler' && isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM urunler WHERE id =:id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([":id" => $id]);
  $urunlerData = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'urunler' => $urunlerData
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeUrunFeatureStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $statusSql = "SELECT is_featured FROM urunler WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['is_featured']; 
    $newStatus = ($currentStatus == 1) ? 0 : 1;
  } else {
    $newStatus = 0; 
  }

  $sql = "UPDATE urunler SET is_featured = :is_featured WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':is_featured' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'is_featured' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeUrunStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $statusSql = "SELECT durum FROM urunler WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['durum']; 
    $newStatus = ($currentStatus == 1) ? 0 : 1; 
  } else {
    $newStatus = 0; 
  }

  $sql = "UPDATE urunler SET durum = :durum WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':durum' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'durum' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['urun_guncelle'])) {

  $id = $_POST['id'];
  $baslik = $_POST['baslik'];
  $aciklama = $_POST['aciklama'];
  $kategori_id = $_POST['kategori_id'];
  $model = $_POST['model'];
  $renk = $_POST['renk'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];
  $adet = $_POST['adet'];
  $fiyat = $_POST['fiyat'];
  $etiket = $_POST['etiket'];
  $is_featured = $_POST['is_featured'];
  $created_at = date('Y-m-d H:i:s');


  $resim = $_FILES['resim'];

  if ($durum == '-1') {
    $durum = 0;
  } else if ($is_featured == '-1') {
    $is_featured = 0;
  }


  if (isset($resim) && $resim['size']) {
    $uploads_dir = "../../../public/assets/images/urunler";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His');
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

    $sql = "UPDATE urunler SET baslik=:baslik, aciklama=:aciklama, kategori_id=:kategori_id, model=:model, renk=:renk, sira=:sira, adet=:adet, fiyat=:fiyat, etiket=:etiket, is_featured=:is_featured, durum=:durum, resim=:resim, created_at=:created_at WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update =
    $stmt->execute([
      ":id" => $id,
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":kategori_id" => $kategori_id,
      ":model" => $model,
      ":renk" => $renk,
      ":sira" => $sira,
      ":adet" => $adet,
      ":fiyat" => $fiyat,
      ":etiket" => $etiket,
      ":is_featured" => $is_featured,
      ":durum" => $durum,
      ":created_at" => $created_at,
      ":resim" => $imagePath
    ]);
  } else {
    $sql = "UPDATE urunler SET baslik=:baslik, aciklama=:aciklama, kategori_id=:kategori_id, model=:model, renk=:renk, sira=:sira, adet=:adet, fiyat=:fiyat, etiket=:etiket, is_featured=:is_featured, durum=:durum, created_at=:created_at WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":kategori_id" => $kategori_id,
      ":model" => $model,
      ":renk" => $renk,
      ":sira" => $sira,
      ":adet" => $adet,
      ":fiyat" => $fiyat,
      ":etiket" => $etiket,
      ":is_featured" => $is_featured,
      ":durum" => $durum,
      ":created_at" => $created_at
    ]);
  }

  if ($update) {
    $_SESSION["urunler_update_success_message"] = "Ürünler başarıyla güncellendi.";
    header("Location: ../../../urunler?kategoriId={$kategori_id}");
  } else {
    $_SESSION["urunler_update_error_message"] = "Ürünler güncellenemedi!";
    header("Location: ../../../urunler?kategoriId={$kategori_id}");
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteUrun' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $resimSql = "SELECT resim FROM urunler WHERE id = :id";
  $resimStmt = $baglanti->prepare($resimSql);
  $resimStmt->execute([':id' => $id]);
  $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

  if (file_exists("../../../public/assets/images/urunler/{$oldImage['resim']}")) {
    unlink("../../../public/assets/images/urunler/{$oldImage['resim']}");
  }

  $sql = "DELETE FROM urunler WHERE id=:id";
  $stmt = $baglanti->prepare($sql);

  $delete = $stmt->execute([':id' => $id]);

  if ($delete) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    $response = [
      'message' => 'İşlem başarılı',
      'id' => $id
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    $_SESSION["urunler_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../../../urunler');
  }
}
