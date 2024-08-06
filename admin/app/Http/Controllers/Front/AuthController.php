<?php
session_start();
require_once '../../../../database/baglanti.php';


// JSON veri alımı
$input4JsonReq = file_get_contents('php://input');
$data4JsonReq = json_decode($input4JsonReq, true);


/***** login *****/
if (isset($_POST["login"])) {
  $k_adi = htmlspecialchars($_POST['k_adi']);
  $sifre = htmlspecialchars($_POST['sifre']);
  $makeHash =  hash('SHA512', $sifre);
  $yetki = 0;

  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi AND sifre=:sifre AND yetki=:yetki";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ":k_adi" => $k_adi,
    ":sifre" => $makeHash,
    ":yetki" => $yetki
  ]);

  $checkUser = $stmt->rowCount();

  if ($checkUser) {
    $_SESSION['normalUser'] = $k_adi;
    $_SESSION['normalUserPermission'] = $yetki;

    Header("Location:../../../../../index");
  } else {
    $_SESSION["front_login_error_message"] = "Kullanıcı adı veya şifre hatalı.";
    Header("Location:../../../../../login");
  }
}

/***** register *****/
if (isset($_POST["register"])) {
  $k_adi = htmlspecialchars($_POST["k_adi"]);
  $ad_soyad = htmlspecialchars($_POST["ad_soyad"]);
  $email = htmlspecialchars($_POST["email"]);
  $sifre = hash("SHA512", htmlspecialchars($_POST["sifre"]));
  $sifre_tekrar = hash("SHA512", htmlspecialchars($_POST["sifre_tekrar"]));
  $yetki = 0;

  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi OR email=:email AND yetki=:yetki";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    ":k_adi" => $k_adi,
    ":email" => $email,
    ":yetki" => 0
  ]);

  $checkUser = $stmt->rowCount();

  if ($checkUser) {
    $_SESSION['front_login_user_error_message'] = 'Kullanıcı sistemde mevcuttur.';
    Header("Location:../../../../../login");
  } else {
    if ($sifre == $sifre_tekrar) {
      if (strlen($_POST["sifre"]) >= 6) {
        $sql = "INSERT INTO kullanici SET kullanici_adi=:k_adi, sifre=:sifre, ad_soyad=:ad_soyad, email=:email, yetki=:yetki";
        $stmt = $baglanti->prepare($sql);
        $insert = $stmt->execute([
          ":k_adi" => $k_adi,
          ":ad_soyad" => $ad_soyad,
          ":email" => $email,
          ":sifre" => $sifre,
          ":yetki" => $yetki,
        ]);

        if ($insert) {
          $_SESSION["uye_store_success_message"] = "İşlem başarılı.";
          Header('Location:: ../../index');
        } else {
          $_SESSION["uye_store_error_message"] = "İşlem başarısız.";
          Header('Location:: ../../index');
        }
      } else {
        $_SESSION["front_login_pass_len_error_message"] = "Şifre en az 6 karakter uzunluğunda olmak zorundadır.";
        Header("Location:../../../../../login");
      }
    } else {
      $_SESSION["front_login_pass_error_message"] = "Şifreler aynı olmak zorundadır.";
      Header("Location:../../../../../login");
    }
  }
}


/***** sifremi unuttum ******/
if (isset($data4JsonReq['action']) && $data4JsonReq['action'] == 'sifremi_unuttum') {
  $k_adi = $data4JsonReq['k_adi'];
  $yetki = 0;

  $sql = "SELECT * FROM kullanici WHERE kullanici_adi=:k_adi AND yetki=:yetki";
  $stmt = $baglanti->prepare($sql);
  $stmt->execute([
    "k_adi" => $k_adi,
    "yetki" => $yetki
  ]);

  $getUser = $stmt->fetch(PDO::FETCH_ASSOC);
  $hasUser = $stmt->rowCount();

  if ($hasUser) {
    $sifreOlustur = date("HisY");
    $username = strtolower(substr($getUser['kullanici_adi'], 0, 5));
    $finalPass = "$username.$sifreOlustur!";
    $sifre = Hash('SHA512', $finalPass);

    $id = $getUser['id'];
    $email = $getUser['email'];

    $updSql = "UPDATE kullanici SET sifre=:sifre WHERE id=:id";
    $updStmt = $baglanti->prepare($updSql);

    $update = $updStmt->execute([
      "id" => $id,
      "sifre" => $sifre
    ]);

    if ($update) {
      require_once("../phpmailer/class.phpmailer.php");
      $fromMail = "info@okanaras.com";

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Host = "smtp.hostinger.web.tr"; // hosting
      $mail->SMTPAuth = true;
      $mail->Username = "info@okanaras.com"; // email
      $mail->Password = "123456"; // mail parolasi
      $mail->From = (string) $fromMail; //from email
      $mail->FromName = "Okan Aras"; // from name
      $mail->AddAddress((string) $email, "Mail gönderimi"); // okan
      $mail->AddReplyTo((string) $email, 'Reply to name'); // okan
      $mail->Subject = "Şifremi Unuttum!"; // konu
      $mail->Body = "Merhaba, sisteme gecici olarak asagidaki sifre ike giris yapabilirsiniz. '$finalPass'"; // message
      $mail->CharSet = 'UTF-8';

      if ($mail->Send()) {
        echo "Şifreniz mail adresine iletildi. Lütfen gelen ve spam kutunuzu kontrol ediniz.";
      } else {
        echo $mail->ErrorInfo;
        die();
      }
    } else {
      $msg = "sifre degismedi";
      echo $msg;
      die();
    }
  } else {
    echo "kullanici bulunamadi";
    die();
  }
}
