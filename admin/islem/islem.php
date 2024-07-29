<?php
session_start();

require_once 'baglanti.php';

if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}

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
    Header('Location: ../ayarlar');
  } else {
    $_SESSION["ayarlar_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../ayarlar');
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
    Header('Location: ../ayarlar');
  } else {
    $_SESSION["ayarlar_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../ayarlar');
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
    Header('Location: ../iletisim');
  } else {
    $_SESSION["iletisim_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../iletisim');
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
    Header('Location: ../sosyalmedya');
  } else {
    $_SESSION["sosyalmedya_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../sosyalmedya');
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
    Header('Location: ../hakkimizda');
  } else {
    $_SESSION["hakkimizda_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../hakkimizda');
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
    $_SESSION['loggedUser'] = $k_adi;
    Header("Location:../index");
  } else {
    $_SESSION["login_error_message"] = "Kullanıcı adı veya şifre hatalı.";
    Header("Location:../login");
  }
}

if (isset($_POST["uyeler_kaydet"])) {
  $k_adi = htmlspecialchars($_POST["k_adi"]);
  $sifre = hash('SHA512', htmlspecialchars($_POST["sifre"]));
  $ad_soyad = htmlspecialchars($_POST["ad_soyad"]);
  $resim = $_FILES['resim'];


  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ":k_adi" => $k_adi
  ]);

  $checkUser = $stmt->rowCount();

  if ($checkUser) {
    $_SESSION["uyeler-ekle_store_info_message"] = "Bu kullanıcı sistemde mevcuttur.";
    Header('Location: ../uyeler-ekle');
  } else {
    $uploads_dir = "../images/kullanici/";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

    $sql = "INSERT INTO kullanici SET kullanici_adi=:k_adi, sifre=:sifre, ad_soyad=:ad_soyad, yetki=:yetki, resim=:resim";
    $stmt = $baglanti->prepare($sql);

    $insert = $stmt->execute([
      ":k_adi" => $k_adi,
      ":sifre" => $sifre,
      ":ad_soyad" => $ad_soyad,
      ":yetki" => 1,
      ":resim" => $imagePath
    ]);

    if ($insert) {

      $_SESSION["uyeler-ekle_store_success_message"] = "İşlem başarılı.";
      Header('Location: ../uyeler-ekle');
    } else {
      $_SESSION["uyeler-ekle_store_error_message"] = "İşlem başarısız.";
      Header('Location: ../uyeler-ekle');
    }
  }
}

if (isset($_GET['delete_user'])) {
  $userId = $_GET['id'];

  $sql = "DELETE FROM  kullanici WHERE id=:id";
  $stmt = $baglanti->prepare($sql);

  $delete = $stmt->execute([
    ":id" => $userId
  ]);

  if ($delete) {
    $_SESSION["uyeler_delete_success_message"] = "Kayıt başarıyla silindi.";
    Header('Location: ../uyeler');
  } else {
    $_SESSION["uyeler_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../uyeler');
  }
}

if (isset($_POST['kategori_kaydet'])) {
  $ad = $_POST['ad'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];

  if ($durum == '-1') {
    $durum = 0;
  }


  $sql = "INSERT INTO kategori SET ad=:ad, sira=:sira, durum=:durum";
  $stmt = $baglanti->prepare($sql);

  $insert = $stmt->execute([
    ":ad" => $ad,
    ":sira" => $sira,
    ":durum" => $durum
  ]);

  if ($insert) {
    $_SESSION["kategori-ekle_store_success_message"] = "Kategori başarıyla eklendi.";
    Header('Location: ../kategori-ekle');
  } else {
    $_SESSION["kategori-ekle_store_error_message"] = "Kayıt işlemi başarısız.";
    Header('Location: ../kategori-ekle');
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'getCategory' && isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM kategori WHERE id =:id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([":id" => $id]);
  $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'category' => $categoryData
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}


if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeCategoryStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  // Mevcut durumu almak için sorgu
  $statusSql = "SELECT durum FROM kategori WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['durum']; // 'durum' anahtarını kullanarak mevcut durumu alıyoruz
    $newStatus = ($currentStatus == 1) ? 0 : 1; // Durum 1 ise 0, 0 ise 1 olacak
  } else {
    $newStatus = 0; // Eğer durum bulunamazsa varsayılan olarak 0
  }

  $sql = "UPDATE kategori SET durum = :durum WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':durum' => $newStatus,
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


if (isset($_POST['kategori_guncelle'])) {
  $id = $_POST['id'];
  $ad = $_POST['ad'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];

  $sql = "UPDATE kategori SET ad=:ad, sira=:sira, durum=:durum WHERE id=$id";
  $stmt = $baglanti->prepare($sql);

  $update = $stmt->execute([
    ":ad" => $ad,
    ":sira" => $sira,
    ":durum" => $durum
  ]);

  if ($update) {
    $_SESSION["kategori_update_success_message"] = "Kategori başarıyla güncellendi.";
    header("Location:../kategori");
  } else {
    $_SESSION["kategori_update_error_message"] = "Kategori güncellenemedi!";
    header("Location:../kategori");
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteCategory' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $sql = "DELETE FROM kategori WHERE id=:id";
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
    $_SESSION["kategoriler_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../kategoriler');
  }
}
