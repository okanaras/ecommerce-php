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

if (isset($_POST["logoKaydet"])) {
  $logo = $_FILES["logo"];

  $uploads_dir = "../images/logo";
  @$tmp_name = $logo["tmp_name"];
  @$name = pathinfo($logo['name'], PATHINFO_FILENAME);
  $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
  @$ext = pathinfo($logo['name'], PATHINFO_EXTENSION);

  $imagePath = "{$name}_{$now}.{$ext}";
  @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

  $sql = "UPDATE ayarlar SET logo=:logo WHERE id=1 ";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    ":logo" => $imagePath
  ]);


  if ($update) {
    $deleteLogo = $_POST['eski_logo'];
    unlink("../images/logo/$deleteLogo");

    Header('Location: ../ayarlar.php?success=1');
  } else {
    Header('Location: ../ayarlar.php?error=1');
  }
}

if (isset($_POST["hakkimizdaKaydet"])) {
  $baslik = $_POST["baslik"];
  $detay = $_POST["detay"];
  $misyon = $_POST["misyon"];
  $vizyon = $_POST["vizyon"];
  $resim = $_FILES["resim"];

  if ($resim && $resim['size'] > 0) {
    $uploads_dir = "../images/hakkimizda";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

    $sql = "UPDATE hakkimizda SET baslik=:baslik, detay=:detay, misyon=:misyon, vizyon=:vizyon, resim=:resim WHERE id=1 ";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":baslik" => $baslik,
      ":detay" => $detay,
      ":misyon" => $misyon,
      ":vizyon" => $vizyon,
      ":resim" => $imagePath
    ]);
  } else {
    $sql = "UPDATE hakkimizda SET baslik=:baslik, detay=:detay, misyon=:misyon, vizyon=:vizyon WHERE id=1 ";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":baslik" => $baslik,
      ":detay" => $detay,
      ":misyon" => $misyon,
      ":vizyon" => $vizyon
    ]);
  }
  if ($update) {
    if ($resim && $resim['size'] > 0) {
      $oldImage = $_POST['eski_resim'];
      unlink("../images/hakkimizda/$oldImage");
    }
    Header('Location: ../hakkimizda.php?success=1');
  } else {
    Header('Location: ../hakkimizda.php?error=1');
  }
}