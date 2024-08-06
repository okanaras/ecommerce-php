
<?php

if (isset($_POST["mail_gonder"])) {
  require_once("class.phpmailer.php");
  $adsoyad = $_POST["adsoyad"];
  $email = $_POST["email"];
  $konu = $_POST["konu"];
  $mesaj = $_POST["mesaj"];

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->Host = "smtp.hostinger.web.tr"; // hosting
  $mail->SMTPAuth = true;
  $mail->Username = "info@okanaras.com"; // email
  $mail->Password = "123456"; // mail parolasi
  $mail->From = (string) $email; //from email
  $mail->FromName = $adsoyad; // from name
  $mail->AddAddress("info@okanaras.com", "Mail gönderimi"); // okan
  $mail->AddReplyTo((string) $email, 'Reply to name'); // okan
  $mail->Subject = $konu; // konu
  $mail->Body = $mesaj; // message
  $mail->CharSet = 'UTF-8';

  if ($mail->Send()) {
    echo "gonderildi";
  } else {
    echo $mail->ErrorInfo;
  }
}

?>

