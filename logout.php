<?php
require_once 'session.php';
require_once 'functions.php';

// Tüm oturum verilerini temizle
session_unset();

// Oturumu yok et
session_destroy();

// Oturum çerezini sil
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Oturum başarıyla sonlandırıldı mesajını ayarla
// Yeni oturum başlat
session_start();
set_success("Başarıyla çıkış yaptınız!");

// Ana sayfaya yönlendir
redirect("index.php");
?>
