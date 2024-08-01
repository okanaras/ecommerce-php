<?php
session_start();
require_once '../../../../database/baglanti.php';

if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

if (isset($_POST['yorum_kaydet_input'])) {
  $redirect_url = $_SERVER['HTTP_REFERER'];
  $user_id = $_POST['user_id'];
  $urun_id = $_POST['urun_id'];
  $detay = $_POST['detay'];
  $onay = 0;
  $is_is_spam = 1;
  $created_at = date('Y-m-d H:i:s');

  // Küfürlü kelimeler ve varyasyonları için regex desenleri
  $kufurlu_kelime_regex_listesi = [
    '/a[mc]{1,2}ık/',
    '/a[mc]{1,2}k/',
    '/orospu/',
    '/piç/',
    '/sik(i|mek)?/',
    '/yarrak/',
    '/bok/',
    '/siktir/',
    '/götü?/',
    '/çüş/',
    '/ahlaka aykırı/',
    '/açık saçık/',
    '/yırtık/',
    '/kaltak/',
    '/gavat/',
    '/p[ıi]ç/',
    '/sik(i|mek)?k/',
    '/sıçmak/',
    '/kötü söz/',
    '/sakso/',
    '/anani sikeyim/',
    '/götüne sokayım/',
    '/yarak/',
    '/amına koyayım/',
    '/götüne/',
    '/götünü/',
    '/çömez/',
    '/siktir git/',
    '/boku yedi/',
    '/vursana/',
    '/tahrik edici/',
    '/kötü niyetli/',
    '/rezil/',
    '/şerefsiz/',
    '/it/',
    '/köpek/',
    '/soytarı/',
    '/kabadayı/',
    '/terbiyesiz/',
    '/çürük/',
    '/salak/',
    '/gerizekalı/'
  ];

  $kufur_tespit_edildi = false;

  // Yorum detayında küfürlü kelime kontrolü
  foreach ($kufurlu_kelime_regex_listesi as $regex) {
    if (preg_match($regex, $detay)) {
      $kufur_tespit_edildi = true;
      break;
    }
  }

  if ($kufur_tespit_edildi) {
    $sql = "INSERT INTO yorumlar SET user_id=:user_id, urun_id=:urun_id, detay=:detay, onay=:onay, is_spam=:is_spam, created_at=:created_at";
    $stmt = $baglanti->prepare($sql);
    $insert = $stmt->execute([
      ":user_id" => $user_id,
      ":urun_id" => $urun_id,
      ":detay" => $detay,
      ":onay" => $onay,
      ":is_spam" => $is_spam,
      ":created_at" => $created_at
    ]);

    $_SESSION["yorum_store_success_message"] = "Yorumunuz başarıyla iletildi. En kısa sürede paylaşılacaktır.";
    header("Location:$redirect_url");
  } else {
    $is_spam = 0;
    $sql = "INSERT INTO yorumlar SET user_id=:user_id, urun_id=:urun_id, detay=:detay, onay=:onay, is_spam=:is_spam, created_at=:created_at";
    $stmt = $baglanti->prepare($sql);
    $insert = $stmt->execute([
      ":user_id" => $user_id,
      ":urun_id" => $urun_id,
      ":detay" => $detay,
      ":onay" => $onay,
      ":is_spam" => $is_spam,
      ":created_at" => $created_at
    ]);

    if ($insert) {
      $_SESSION["yorum_store_success_message"] = "Yorumunuz başarıyla iletildi. En kısa sürede paylaşılacaktır.";
      header("Location:$redirect_url");
    } else {
      $_SESSION["yorum_store_error_message"] = "Kayıt işlemi başarısız.";
      header("Location:$redirect_url");
    }
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'getComment' && isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM yorumlar WHERE id =:id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([":id" => $id]);
  $commentData = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'comment' => $commentData
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeCommentStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $statusSql = "SELECT onay FROM yorumlar WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['onay']; 
    $newStatus = ($currentStatus == 1) ? 0 : 1; 
  } else {
    $newStatus = 0;
  }

  $sql = "UPDATE yorumlar SET onay = :onay WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':onay' => $newStatus,
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

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeSpamStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $statusSql = "SELECT is_spam FROM yorumlar WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['is_spam']; 
    $newStatus = ($currentStatus == 1) ? 0 : 1; 
  } else {
    $newStatus = 0; 
  }

  $sql = "UPDATE yorumlar SET is_spam = :is_spam WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':is_spam' => $newStatus,
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

if (isset($_POST['yorum_guncelle'])) {
  $id = $_POST['id'];
  $detay = $_POST['detay'];
  $onay = $_POST['onay'];
  $is_spam = $_POST['is_spam'];

  if ($is_spam == '-1') {
    $is_spam = 0;
  }

  if ($onay == '-1') {
    $onay = 0;
  }

  $sql = "UPDATE yorumlar SET detay=:detay, onay=:onay, is_spam=:is_spam WHERE id=$id";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    ":detay" => $detay,
    ":onay" => $onay,
    ":is_spam" => $is_spam
  ]);

  if ($update) {
    $_SESSION["yorum_update_success_message"] = "Yorum başarıyla güncellendi.";
    header("Location:../../../../yorumlar");
  } else {
    $_SESSION["yorum_update_error_message"] = "Yorum güncellenemedi!";
    header("Location:../../../../yorumlar");
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteComment' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $sql = "DELETE FROM yorumlar WHERE id=:id";
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
    $_SESSION["yorum_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../../../../yorumlar');
  }
}
