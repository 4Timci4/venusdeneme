<?php
$page_title = "Karakter Bilgileri";
require_once 'session.php';
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor

// Oturum kontrolü - sadece giriş yapan kullanıcılar erişebilir
require_login();

// Kullanıcıyı profil sayfasına yönlendir
redirect('profile.php');
?>
