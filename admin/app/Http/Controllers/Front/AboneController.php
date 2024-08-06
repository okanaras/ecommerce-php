<?php
session_start();
require_once '../../../../database/baglanti.php';


if (isset($_POST)) {
  // JSON veri alımı
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'aboneOl') {
  $email = $data4JsonReq['email'];
  $redirect_url = $_SERVER['HTTP_REFERER'];

  $searchSql = "SELECT abone_email FROM abone WHERE abone_email=:email";
  $searchStmt = $baglanti->prepare($searchSql);
  $searchStmt->execute([
    ":email" => $email,
  ]);

  $hasEmail = $searchStmt->rowCount();
  if ($hasEmail) {

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    $_SESSION['abone_store_success_message'] = "Abonelik talebiniz başarıyla gerçekleştirildi.";

    $response = [
      'message' => 'Ok',
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    $sql = "INSERT INTO abone SET abone_email=:email";
    $stmt = $baglanti->prepare($sql);
    $insert = $stmt->execute([
      ":email" => $email
    ]);

    if ($insert) {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(200);

      $_SESSION['abone_store_success_message'] = "Abonelik talebiniz başarıyla gerçekleştirildi.";

      $response = [
        'message' => 'Ok',
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
      $_SESSION['abone_store_error_message'] = "Bir hata oluştu.";
      Header("Location:$redirect_url");
    }
  }
}




if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteAbone' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];
  $redirect_url = $_SERVER['HTTP_REFERER'];
  $sql = "DELETE FROM abone WHERE id=:id";
  $stmt = $baglanti->prepare($sql);
  $delete = $stmt->execute([
    ":id" => $id
  ]);
  if ($delete) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    $response = [
      'message' => "Mevcut abonelik başarıyla silindi.",
      'id' => $id
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    $_SESSION['abone_delete_error_message'] = "Bir hata oluştu.";
    Header("Location:$redirect_url");
  }
}
