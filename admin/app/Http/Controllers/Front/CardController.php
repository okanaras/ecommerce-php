<?php

session_start();
require_once '../../../../database/baglanti.php';

// JSON veri alımı
$input4JsonReq = file_get_contents('php://input');
$data4JsonReq = json_decode($input4JsonReq, true);

if (isset($_POST["sepete_ekle"])) {
  $id = $_POST['urun_id'];
  $adet = $_POST['adet'];

  // Cookie ayarlama
  setcookie("sepet[$id]", $adet, time() + 7 * 24 * 60 * 60, "/");

  if (isset($_COOKIE["sepet"][$id])) {
    $_SESSION["sepet_store_success_message"] = "Ürününüz başarıyla sepete eklendi.";
    header("Location: ../../../../../sepet");
    exit();
  } else {
    $_SESSION["sepet_store_error_message"] = "Ürünü sepete ekleme başarısız.";
    header("Location: ../../../../../sepet");
    exit();
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'urun-kaldir' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  setcookie("sepet[$id]", "", time() - 3600, "/");

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $_SESSION["sepet_delete_success_message"] = "Ürününüz başarıyla sepetten kaldırıldı.";

  $response = [
    'message' => 'İşlem başarılı',
    'id' => $id
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
