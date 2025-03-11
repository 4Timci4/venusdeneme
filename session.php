<?php
// Maksimum oturum süresi (3600 saniye = 1 saat)
$session_timeout = 3600;

// Oturum güvenliği için ayarlar
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// Oturum cookie parametrelerini ayarlama
$cookie_params = session_get_cookie_params();
session_set_cookie_params(
    $session_timeout,
    $cookie_params['path'],
    $cookie_params['domain'],
    true,  // Secure flag (HTTPS üzerinden)
    true   // HTTPOnly flag (JavaScript erişimi engelleme)
);

// Oturum başlatma
session_start();

// Oturum süresini kontrol etme ve yenileme
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Oturum zaman aşımına uğradıysa oturumu sonlandır
    session_unset();
    session_destroy();
    session_start();
}

// Son aktivite zamanını güncelle
$_SESSION['last_activity'] = time();

// Her 30 dakikada bir oturum ID'sini yenile (session fixation saldırılarına karşı)
if (isset($_SESSION['created']) && (time() - $_SESSION['created'] > 1800)) {
    // Oturum verilerini geçici olarak sakla
    $old_session_data = $_SESSION;
    
    // Oturumu yenile
    session_regenerate_id(true);
    
    // Önceki oturum verilerini geri yükle
    $_SESSION = $old_session_data;
    
    // Oluşturma zamanını güncelle
    $_SESSION['created'] = time();
}

// Oturum ilk kez oluşturuluyorsa oluşturma zamanını ayarla
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
}

// Oturum CSRF tokenini oluştur
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
