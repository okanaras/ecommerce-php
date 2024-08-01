<?php
session_start();
require_once '../../../../database/baglanti.php';

if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

if (!empty($_FILES)) {
  $urun_id = $_POST['urunId'];
  $resim = $_FILES['file'];

  $uploads_dir = "../../../../public/assets/images/cokluresim";
  @$tmp_name = $resim["tmp_name"];
  @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
  $now = date('Ymd-His');
  @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

  $imagePath = "{$name}_{$now}.{$ext}";
  @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");


  $sql = "INSERT INTO cokluresim SET resim=:resim, urun_id=:urun_id";
  $stmt = $baglanti->prepare($sql);

  $insert = $stmt->execute([
    ":urun_id" => $urun_id,
    ":resim" => $imagePath
  ]);

  // if ($insert) {
  //   $_SESSION["resim-ekle_store_success_message"] = "Görseler başarıyla eklendi.";
  //   Header("Location: ../../../../cokluresim");
  // } else {
  //   $_SESSION["resim-ekle_store_error_message"] = "Kayıt işlemi başarısız.";
  //   Header("Location: ../../../../cokluresim?id={$urun_id}");
  // }
}


if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteResim' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $resimSql = "SELECT resim FROM cokluresim WHERE id = :id";
  $resimStmt = $baglanti->prepare($resimSql);
  $resimStmt->execute([':id' => $id]);
  $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

  if (file_exists("../../../../public/assets/images/cokluresim/{$oldImage['resim']}")) {
    unlink("../../../../public/assets/images/cokluresim/{$oldImage['resim']}");
  }

  $sql = "DELETE FROM cokluresim WHERE id=:id";
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
    $_SESSION["resimler_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../../../../cokluresim');
  }
}
