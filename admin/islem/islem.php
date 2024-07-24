<?php

require_once 'baglanti.php';

if (isset($_POST["ayarKaydet"])) {
  $baslik = $_POST["baslik"];
  $aciklama = $_POST["aciklama"];
  $anahtarKelime = $_POST["anahtarKelime"];

  $prepareData = $baglanti->prepare("UPDATE ayarlar SET
  baslik=:baslik,
  aciklama=:aciklama,
  anahtarkelime=:anahtarKelime

  WHERE id=1

  ");

  $update = $prepareData->execute([
    "baslik" => $baslik,
    "aciklama" => $aciklama,
    "anahtarKelime" => $anahtarKelime
  ]);

  if ($update) {
    Header('Location: ../ayarlar.php?success=1');
  } else {
    Header('Location: ../ayarlar.php?error=1');
  }
}

if (isset($_POST["iletisimKaydet"])) {
  $telefon = $_POST["telefon"];
  $adres = $_POST["adres"];
  $email = $_POST["email"];
  $mesai = $_POST["mesai"];

  $prepareData = $baglanti->prepare("UPDATE ayarlar SET
  telefon=:telefon,
  adres=:adres,
  email=:email,
  mesai=:mesai

  WHERE id=1

  ");

  $update = $prepareData->execute([
    "telefon" => $telefon,
    "adres" => $adres,
    "email" => $email,
    "mesai" => $mesai
  ]);

  if ($update) {
    Header('Location: ../iletisim.php?success=1');
  } else {
    Header('Location: ../iletisim.php?error=1');
  }
}

if (isset($_POST["sosyalMedyaKaydet"])) {
  $facebook = $_POST["facebook"];
  $instagram = $_POST["instagram"];
  $twitter = $_POST["twitter"];
  $youtube = $_POST["youtube"];

  $prepareData = $baglanti->prepare("UPDATE ayarlar SET
  facebook=:facebook,
  instagram=:instagram,
  twitter=:twitter,
  youtube=:youtube

  WHERE id=1

  ");

  $update = $prepareData->execute([
    "facebook" => $facebook,
    "instagram" => $instagram,
    "twitter" => $twitter,
    "youtube" => $youtube
  ]);

  if ($update) {
    Header('Location: ../sosyalmedya.php?success=1');
  } else {
    Header('Location: ../sosyalmedya.php?error=1');
  }
}