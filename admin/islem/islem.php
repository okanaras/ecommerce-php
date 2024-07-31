<?php
session_start();

require_once '../database/baglanti.php';

if (isset($_POST)) {
  $input4JsonReq = file_get_contents('php://input');
  $data4JsonReq = json_decode($input4JsonReq, true);
}


/***** ayarlar *****/
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

  $deleteLogo = $_POST['eski_logo'];
  unlink("../public/assets/images/logo/$deleteLogo");

  $uploads_dir = "../public/assets/images/logo";
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
  $id = 1;
  $baslik = $_POST["baslik"];
  $detay = $_POST["detay"];
  $misyon = $_POST["misyon"];
  $vizyon = $_POST["vizyon"];

  $resim = $_FILES["resim"];

  if ($resim && $resim['size']) {

    $resimSql = "SELECT resim FROM hakkimizda WHERE id = :id";
    $resimStmt = $baglanti->prepare($resimSql);
    $resimStmt->execute([':id' => $id]);
    $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

    if (file_exists("../public/assets/images/hakkimizda/{$oldImage['resim']}")) {
      unlink("../public/assets/images/hakkimizda/{$oldImage['resim']}");
    }

    $uploads_dir = "../public/assets/images/hakkimizda";
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
    $_SESSION["hakkimizda_store_success_message"] = "İşlem başarılı.";
    Header('Location: ../hakkimizda');
  } else {
    $_SESSION["hakkimizda_store_error_message"] = "İşlem başarısız.";
    Header('Location: ../hakkimizda');
  }
}





/***** login *****/
if (isset($_POST["giris_yap"])) {
  $k_adi = htmlspecialchars($_POST['k_adi']);
  $sifre = htmlspecialchars($_POST['sifre']);
  $makeHash =  hash('SHA512', $sifre);

  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi AND sifre=:sifre AND yetki=:yetki";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ":k_adi" => $k_adi,
    ":sifre" => $makeHash,
    ":yetki" => 1,
  ]);

  $checkUser = $stmt->rowCount();

  if ($checkUser) {
    $_SESSION['loggedUser'] = $k_adi;
    $_SESSION['loggedUserPermission'] = 1;
    Header("Location:../index");
  } else {
    $_SESSION["login_error_message"] = "Kullanıcı adı, şifre veya izin hatalı.";
    Header("Location:../login");
  }
}




/***** uye *****/
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
    if (isset($resim) && $resim['size']) {
      $uploads_dir = "../public/assets/images/kullanici/";
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
    } else {
      $sql = "INSERT INTO kullanici SET kullanici_adi=:k_adi, sifre=:sifre, ad_soyad=:ad_soyad, yetki=:yetki";
      $stmt = $baglanti->prepare($sql);

      $insert = $stmt->execute([
        ":k_adi" => $k_adi,
        ":sifre" => $sifre,
        ":ad_soyad" =>  $ad_soyad,
        ":yetki" => 1
      ]);
    }

    if ($insert) {

      $_SESSION["uyeler-ekle_store_success_message"] = "İşlem başarılı.";
      Header('Location: ../uyeler-ekle');
    } else {
      $_SESSION["uyeler-ekle_store_error_message"] = "İşlem başarısız.";
      Header('Location: ../uyeler-ekle');
    }
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'getMember' && isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM kullanici WHERE id =:id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([":id" => $id]);
  $memberData = $stmt->fetch(PDO::FETCH_ASSOC);

  unset($memberData['sifre']);
  unset($memberData['created_at']);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'member' => $memberData
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeMemberStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $statusSql = "SELECT yetki FROM kullanici WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['yetki'];
    $newStatus = ($currentStatus == 1) ? 0 : 1;
  } else {
    $newStatus = 0;
  }

  $sql = "UPDATE kullanici SET yetki = :yetki WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':yetki' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'yetki' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($_POST['uye_guncelle'])) {

  $id = $_POST['id'];
  $username = $_POST['username'];
  $sifre =  hash('SHA512', $_POST['sifre']);
  $ad_soyad = $_POST['ad_soyad'];
  $adres = $_POST['adres'];
  $il = $_POST['il'];
  $ilce = $_POST['ilce'];
  $tel = $_POST['tel'];
  $yetki = $_POST['yetki'];

  $resim = $_FILES['resim'];

  if ($yetki == '-1') {
    $yetki = 0;
  }


  if ($resim && $resim['size']) {

    $resimSql = "SELECT resim FROM kullanici WHERE id = :id";
    $resimStmt = $baglanti->prepare($resimSql);
    $resimStmt->execute([':id' => $id]);
    $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

    if (file_exists("../public/assets/images/kullanici/{$oldImage['resim']}")) {
      unlink("../public/assets/images/kullanici/{$oldImage['resim']}");
    }


    $uploads_dir = "../public/assets/images/kullanici";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

    $sql = "UPDATE kullanici SET kullanici_adi=:username, sifre=:sifre, ad_soyad=:ad_soyad, adres=:adres, il=:il, ilce=:ilce, tel=:tel, yetki=:yetki, resim=:resim WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":username" => $username,
      ":sifre" => $sifre,
      ":ad_soyad" => $ad_soyad,
      ":adres" => $adres,
      ":il" => $il,
      ":ilce" => $ilce,
      ":tel" => $tel,
      ":yetki" => $yetki,
      ":resim" => $imagePath
    ]);
  } else {
    $sql = "UPDATE kullanici SET kullanici_adi=:username, sifre=:sifre, ad_soyad=:ad_soyad, adres=:adres, il=:il, ilce=:ilce, tel=:tel, yetki=:yetki WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":username" => $username,
      ":sifre" => $sifre,
      ":ad_soyad" => $ad_soyad,
      ":adres" => $adres,
      ":il" => $il,
      ":ilce" => $ilce,
      ":tel" => $tel,
      ":yetki" => $yetki
    ]);
  }

  if ($update) {
    $_SESSION["uyeler_update_success_message"] = "Üye başarıyla güncellendi.";
    header("Location:../uyeler");
  } else {
    $_SESSION["uyeler_update_error_message"] = "Üye güncellenemedi!";
    header("Location:../uyeler");
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteMember' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $resimSql = "SELECT resim FROM kullanici WHERE id = :id";
  $resimStmt = $baglanti->prepare($resimSql);
  $resimStmt->execute([':id' => $id]);
  $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

  if (file_exists("../public/assets/images/kullanici/{$oldImage['resim']}")) {
    unlink("../public/assets/images/kullanici/{$oldImage['resim']}");
  }

  $sql = "DELETE FROM kullanici WHERE id=:id";
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
    $_SESSION["kullanici_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../uyeler');
  }
}




/***** kategori *****/
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

  if ($durum == '-1') {
    $durum = 0;
  }


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
    $_SESSION["kategori_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../kategori');
  }
}





/***** slider *****/
if (isset($_POST['slider_kaydet'])) {
  $baslik = $_POST['baslik'];
  $aciklama = $_POST['aciklama'];
  $link = $_POST['link'];
  $fiyat_yazisi = $_POST['fiyat_yazisi'];
  $indirim_miktari_yazisi = $_POST['indirim_miktari_yazisi'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];
  $banner = $_POST['slider_banner'];
  $resim = $_FILES['resim'];

  if ($durum == '-1') {
    $durum = 0;
  } else if ($banner == '-1') {
    $banner = 1;
  }


  if (isset($resim) && $resim['size']) {
    $uploads_dir = "../public/assets/images/slider";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");


    $sql = "INSERT INTO slider SET baslik=:baslik, aciklama=:aciklama, link=:link, fiyat_yazisi=:fiyat_yazisi, indirim_miktari_yazisi=:indirim_miktari_yazisi, sira=:sira, banner=:banner, durum=:durum, resim=:resim";
    $stmt = $baglanti->prepare($sql);

    $insert = $stmt->execute([
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":link" => $link,
      ":fiyat_yazisi" => $fiyat_yazisi,
      ":indirim_miktari_yazisi" => $indirim_miktari_yazisi,
      ":sira" => $sira,
      ":banner" => $banner,
      ":durum" => $durum,
      ":resim" => $imagePath,
    ]);
  } else {
    $sql = "INSERT INTO slider SET baslik=:baslik, aciklama=:aciklama, link=:link, fiyat_yazisi=:fiyat_yazisi, indirim_miktari_yazisi=:indirim_miktari_yazisi, sira=:sira, banner=:banner, durum=:durum";
    $stmt = $baglanti->prepare($sql);

    $insert = $stmt->execute([
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":link" => $link,
      ":fiyat_yazisi" => $fiyat_yazisi,
      ":indirim_miktari_yazisi" => $indirim_miktari_yazisi,
      ":sira" => $sira,
      ":banner" => $banner,
      ":durum" => $durum,
    ]);
  }

  if ($insert) {
    $_SESSION["slider-ekle_store_success_message"] = "Slider başarıyla eklendi.";
    Header('Location: ../slider-ekle');
  } else {
    $_SESSION["slider-ekle_store_error_message"] = "Kayıt işlemi başarısız.";
    Header('Location: ../slider-ekle');
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'getSlider' && isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM slider WHERE id =:id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([":id" => $id]);
  $sliderData = $stmt->fetch(PDO::FETCH_ASSOC);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'slider' => $sliderData
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeSliderBannerStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  // Mevcut durumu almak için sorgu
  $statusSql = "SELECT banner FROM slider WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['banner']; // 'banner' anahtarını kullanarak mevcut banneru alıyoruz
    $newStatus = ($currentStatus == 1) ? 0 : 1; // Banner 1 ise 0, 0 ise 1 olacak
  } else {
    $newStatus = 0; // Eğer banner bulunamazsa varsayılan olarak 0
  }

  $sql = "UPDATE slider SET banner = :banner WHERE id = :id";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ':banner' => $newStatus,
    ':id' => $id
  ]);

  header('Content-Type: application/json; charset=utf-8');
  http_response_code(200);

  $response = [
    'message' => 'İşlem başarılı',
    'banner' => $newStatus
  ];
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'changeSliderStatus' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  // Mevcut durumu almak için sorgu
  $statusSql = "SELECT durum FROM slider WHERE id = :id";
  $statusStmt = $baglanti->prepare($statusSql);
  $statusStmt->execute([':id' => $id]);
  $status = $statusStmt->fetch(PDO::FETCH_ASSOC);

  if ($status) {
    $currentStatus = $status['durum']; // 'durum' anahtarını kullanarak mevcut durumu alıyoruz
    $newStatus = ($currentStatus == 1) ? 0 : 1; // Durum 1 ise 0, 0 ise 1 olacak
  } else {
    $newStatus = 0; // Eğer durum bulunamazsa varsayılan olarak 0
  }

  $sql = "UPDATE slider SET durum = :durum WHERE id = :id";
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

if (isset($_POST['slider_guncelle'])) {

  $id = $_POST['id'];
  $baslik = $_POST['baslik'];
  $aciklama = $_POST['aciklama'];
  $fiyat_yazisi = $_POST['fiyat_yazisi'];
  $indirim_miktari_yazisi = $_POST['indirim_miktari_yazisi'];
  $link = $_POST['link'];
  $sira = $_POST['sira'];
  $durum = $_POST['durum'];
  $banner = $_POST['slider_banner'];

  $resim = $_FILES['resim'];

  if ($durum == '-1') {
    $durum = 0;
  } else if ($banner == '-1') {
    $banner = 1;
  }


  if ($resim && $resim['size']) {

    $resimSql = "SELECT resim FROM slider WHERE id = :id";
    $stmt = $baglanti->prepare($resimSql);
    $stmt->execute([':id' => $id]);
    $oldImage = $stmt->fetch(PDO::FETCH_ASSOC);

    if (file_exists("../public/assets/images/slider/{$oldImage['resim']}")) {
      unlink("../public/assets/images/slider/{$oldImage['resim']}");
    }


    $uploads_dir = "../public/assets/images/slider";
    @$tmp_name = $resim["tmp_name"];
    @$name = pathinfo($resim['name'], PATHINFO_FILENAME);
    $now = date('Ymd-His'); // Yıl-ay-gün saat:dakika:saniye
    @$ext = pathinfo($resim['name'], PATHINFO_EXTENSION);

    $imagePath = "{$name}_{$now}.{$ext}";
    @move_uploaded_file($tmp_name, "$uploads_dir/$imagePath");

    $sql = "UPDATE slider SET baslik=:baslik, aciklama=:aciklama, link=:link, fiyat_yazisi=:fiyat_yazisi, indirim_miktari_yazisi=:indirim_miktari_yazisi, sira=:sira, banner=:banner, durum=:durum, resim=:resim WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":link" => $link,
      ":fiyat_yazisi" => $fiyat_yazisi,
      ":indirim_miktari_yazisi" => $indirim_miktari_yazisi,
      ":sira" => $sira,
      ":banner" => $banner,
      ":durum" => $durum,
      ":resim" => $imagePath
    ]);
  } else {
    $sql = "UPDATE slider SET baslik=:baslik, aciklama=:aciklama, link=:link,  fiyat_yazisi=:fiyat_yazisi, indirim_miktari_yazisi=:indirim_miktari_yazisi, sira=:sira, banner=:banner, durum=:durum WHERE id=:id";
    $stmt = $baglanti->prepare($sql);

    $update = $stmt->execute([
      ":id" => $id,
      ":baslik" => $baslik,
      ":aciklama" => $aciklama,
      ":link" => $link,
      ":fiyat_yazisi" => $fiyat_yazisi,
      ":indirim_miktari_yazisi" => $indirim_miktari_yazisi,
      ":sira" => $sira,
      ":banner" => $banner,
      ":durum" => $durum
    ]);
  }

  if ($update) {
    $_SESSION["slider_update_success_message"] = "Slider başarıyla güncellendi.";
    header("Location:../slider");
  } else {
    $_SESSION["slider_update_error_message"] = "Slider güncellenemedi!";
    header("Location:../slider");
  }
}

if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'deleteSlider' && isset($data4JsonReq['id'])) {
  $id = $data4JsonReq['id'];

  $resimSql = "SELECT resim FROM slider WHERE id = :id";
  $resimStmt = $baglanti->prepare($resimSql);
  $resimStmt->execute([':id' => $id]);
  $oldImage = $resimStmt->fetch(PDO::FETCH_ASSOC);

  if (file_exists("../public/assets/images/slider/{$oldImage['resim']}")) {
    unlink("../public/assets/images/slider/{$oldImage['resim']}");
  }

  $sql = "DELETE FROM slider WHERE id=:id";
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
    $_SESSION["slider_delete_error_message"] = "İşlem başarısız. Bir hata oluştu.";
    Header('Location: ../slider');
  }
}
