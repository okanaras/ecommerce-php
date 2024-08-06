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

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'alisveris-bitir') {
  $user_id = $data4JsonReq['user_id'];
  $toplam_fiyat = $data4JsonReq['toplam_fiyat'];
  $odeme_turu = $data4JsonReq['odeme'];
  $created_at = date('Y-m-d H:i:s');
  $onay = -1;

  if (isset($_COOKIE['sepet']) && is_array($_COOKIE['sepet'])) {
    foreach ($_COOKIE['sepet'] as $key => $amount) {
      $urunler = $baglanti->prepare("SELECT * FROM urunler WHERE id=:id ORDER BY sira DESC");
      $urunler->execute([
        ":id" => $key,
      ]);
      $urunlerCek = $urunler->fetch(PDO::FETCH_ASSOC);
      $urun_fiyat = $urunlerCek["fiyat"];

      $sql = "INSERT INTO siparisler SET user_id=:user_id, urun_id=:urun_id, urun_adet=:urun_adet, urun_fiyat=:urun_fiyat, toplam_fiyat=:toplam_fiyat, odeme_turu=:odeme_turu, onay=:onay, created_at=:created_at";
      $stmt = $baglanti->prepare($sql);

      $insert = $stmt->execute([
        ":user_id" => $user_id,
        ":urun_id" => $key,
        ":urun_adet" => $amount,
        ":urun_fiyat" => $urun_fiyat,
        ":toplam_fiyat" => $toplam_fiyat,
        ":odeme_turu" => $odeme_turu,
        ":onay" => $onay,
        ":created_at" => $created_at
      ]);
    }

    if ($insert) {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(200);

      $_SESSION["siparis_success_message"] = "Siparişiniz oluşturuldu. Onay işleminden sonra en kısa sürede kargoya verilecektir.";

      $response = [
        'message' => 'Ok',
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
      $_SESSION["siparis_error_message"] = "Sipariş oluşturulamadı. Lütfen info@okanaras.com adresi ile iletişime geçiniz.";
      Header('Location: ../../../../../alisveris');
    }
  }
}
