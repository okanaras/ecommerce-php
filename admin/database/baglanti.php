<?php
try {
  $dsn = "mysql:host=localhost; dbname=ecommerce; charset=utf8mb4";
  $username = "root";
  $password = "";

  $baglanti = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  print "Hata!:" . $e->getMessage() . "<br/>";
  die();
}
