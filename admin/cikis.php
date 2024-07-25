<?php
session_start();
session_destroy();

$_SESSION['logout_message'] = 'Çıkış işlemi başarıyla gerçekleştirildi.';
header("Location:login");