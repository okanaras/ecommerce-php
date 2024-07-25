<?php
session_start();
session_destroy();
session_start();

$_SESSION['logout_message'] = 'Çıkış işlemi başarıyla gerçekleştirildi.';
header("Location:login");