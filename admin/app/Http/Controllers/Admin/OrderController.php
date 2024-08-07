<?php

session_start();
require_once '../../../../database/baglanti.php';

// JSON veri alımı
if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'approveSiparisStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];
  $statusSql = "SELECT onay FROM siparisler WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  $newStatus = 1;

  $sql = "UPDATE siparisler SET onay = :onay WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':onay' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'Sipariş onaylandı.',
    'onay' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'rejectSiparisStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];
  $statusSql = "SELECT onay FROM siparisler WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  $newStatus = 0;

  $sql = "UPDATE siparisler SET onay = :onay WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':onay' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'Sipariş reddedildi.',
    'onay' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteSiparis' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $sql = "DELETE FROM siparisler WHERE id=:id";
  $stmt = $baglanti->prepare($sql);
  $delete =  $stmt->execute([
    ":id" => $id
  ]);

  if ($delete) {
    header('Content-Type:application/json; charset=UTF-8');
    http_response_code(200);

    $response = [
      'message' => 'Sipariş başarıyla silindi'
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  } else {
    header('Content-Type:application/json; charset=UTF-8');
    http_response_code(404);

    $response = [
      'message' => 'Sipariş silinirken bir hata oluştu.',
      'id' => $id
    ];

    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'siparis-guncelle' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];
  $yeni_adet = $data4JsonReq['yeni_adet'];
  $siparis_not = $data4JsonReq['not'];

  if (filter_var($yeni_adet, FILTER_VALIDATE_INT) !== false && $yeni_adet > 0) {
    if ($siparis_not == '' || $siparis_not == null) {
      $siparis_not = null;
    }

    $sql = "UPDATE siparisler SET yeni_adet=:yeni_adet, siparis_not=:siparis_not WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":yeni_adet" => $yeni_adet,
      ":siparis_not" => $siparis_not
    ]);

    if ($update) {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(200);

      $_SESSION['siparis_update_success_message'] = 'Talebiniz uygun görüldüğü takdirde gerçekleşecektir.';

      $response = [
        'message' => 'Talebiniz uygun görüldüğü takdirde gerçekleşecektir.'
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(404);

      $_SESSION['siparis_update_error_message'] = 'Siparişler güncellenemedi. Bir hata oluştu.';

      $response = [
        'message' => 'Siparişler güncellenemedi.',
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
  } else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(202);

    $msg = 'Lütfen adet miktarını 0\'dan büyük olacak şekilde ve tam sayı olarak giriniz.';
    $_SESSION['siparis_update_request_error_message'] = $msg;

    $response = [
      'message' => $msg,
    ];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'siparis-guncelle-admin' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];
  $adet = $data4JsonReq['adet'];

  $checkAdetSql = "SELECT urun_adet FROM siparisler WHERE id=:id";
  $checkAdetStmt = $baglanti->prepare($checkAdetSql);
  $checkAdetStmt->execute([
    ":id" => $id,
  ]);
  $result = $checkAdetStmt->fetch(PDO::FETCH_ASSOC);

  if ($result['urun_adet'] != $adet) {

    $sql = "UPDATE siparisler SET urun_adet=:adet WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":adet" => $adet,
    ]);

    if ($update) {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(200);

      $_SESSION['fiyat_update_success_message'] = 'İşlem Başarılı. Adet güncellendi.';

      $response = [
        'message' => 'İşlem Başarılı.'
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
      header('Content-Type: application/json; charset=utf-8');
      http_response_code(404);

      $_SESSION['fiyat_update_error_message'] = 'Adet güncellenemedi. Bir hata oluştu.';

      $response = [
        'message' => 'Siparişler güncellenemedi.',
      ];
      echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
  } else {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(200);

    $_SESSION['fiyat_update_success_message'] = 'İşlem Başarılı. Adet güncellendi.';

    $response = [
      'message' => 'İşlem Başarılı.'
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
  }
}
