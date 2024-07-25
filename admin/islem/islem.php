<?php
session_start();

require_once 'baglanti.php';

if (isset($_POST["ayarKaydet"])) {
  $baslik = $_POST["baslik"];
  $aciklama = $_POST["aciklama"];
  $anahtar_kelime = $_POST["anahtarKelime"];

  $sql = "UPDATE ayarlar SET baslik=:baslik, aciklama=:aciklama, anahtarkelime=:anahtar_kelime WHERE id=1 ";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    ":baslik" => $baslik,
    ":aciklama" => $aciklama,
    ":anahtar_kelime" => $anahtar_kelime
  ]);

  if ($update) {
    $_SESSION["ayarlar_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../ayarlar.php');
  } else {
    $_SESSION["ayarlar_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../ayarlar.php');
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

    $_SESSION["ayarlar_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../ayarlar.php');
  } else {
    $_SESSION["ayarlar_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../ayarlar.php');
  }
}



if (isset($_POST["iletisimKaydet"])) {
  $telefon = $_POST["telefon"];
  $adres = $_POST["adres"];
  $email = $_POST["email"];
  $mesai = $_POST["mesai"];

  $sql = "UPDATE ayarlar SET telefon=:telefon, adres=:adres, email=:email, mesai=:mesai WHERE id=1";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    ":telefon" => $telefon,
    ":adres" => $adres,
    ":email" => $email,
    ":mesai" => $mesai
  ]);

  if ($update) {
    $_SESSION["iletisim_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../iletisim.php');
  } else {
    $_SESSION["iletisim_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../iletisim.php');
  }
}

if (isset($_POST["sosyalMedyaKaydet"])) {
  $facebook = $_POST["facebook"];
  $instagram = $_POST["instagram"];
  $twitter = $_POST["twitter"];
  $youtube = $_POST["youtube"];

  $sql = "UPDATE ayarlar SET facebook=:facebook, instagram=:instagram, twitter=:twitter, youtube=:youtube WHERE id=1";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    "facebook" => $facebook,
    "instagram" => $instagram,
    "twitter" => $twitter,
    "youtube" => $youtube
  ]);

  if ($update) {
    $_SESSION["sosyalmedya_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../sosyalmedya.php');
  } else {
    $_SESSION["sosyalmedya_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../sosyalmedya.php');
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
    $_SESSION["hakkimizda_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../hakkimizda.php');
  } else {
    $_SESSION["hakkimizda_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../hakkimizda.php');
  }
}

if (isset($_POST["giris_yap"])) {
  $k_adi = htmlspecialchars($_POST['k_adi']);
  $sifre = htmlspecialchars($_POST['sifre']);
  $makeHash =  hash('SHA512', $sifre);

  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi AND sifre=:sifre";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ":k_adi" => $k_adi,
    ":sifre" => $makeHash
  ]);

  $checkUser = $stmt->rowCount();
  if ($checkUser) {
    $_SESSION['girisbelgesi'] = $k_adi;
    Header("Location:../index");
  } else {
    $_SESSION["login_error_message"] = "Kullanıcı adı veya şifre hatalı.";
    Header("Location:../login");
  }
}