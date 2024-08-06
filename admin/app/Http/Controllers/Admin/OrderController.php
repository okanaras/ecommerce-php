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
