<?php
session_start();
require_once '../../../../database/baglanti.php';


if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

if (isset($_POST["kullanici_duzenle"])) {
  $id = $_POST["id"];
  $ad_soyad = $_POST["ad_soyad"];
  $tel = $_POST["tel"];
  $email = $_POST["email"];
  $il = $_POST["il"];
  $ilce = $_POST["ilce"];
  $adres = $_POST["adres"];

  $sql = "UPDATE kullanici SET ad_soyad=:ad_soyad, tel=:tel, email=:email, il=:il,ilce=:ilce, adres=:adres WHERE id=:id";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    "id" => $id,
    "ad_soyad" => $ad_soyad,
    "tel" => $tel,
    "email" => $email,
    "il" => $il,
    "ilce" => $ilce,
    "adres" => $adres
  ]);

  if ($update) {
    $_SESSION["user_update_success_message"] = "Güncelleme işlemi başarılı.";
    Header('Location: ../../../../../kullanici');
  } else {
    $_SESSION["user_update_error_message"] = "Güncelleme işlemi başarısız.";
    Header('Location: ../../../../../kullanici');
  }
}
