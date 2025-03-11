<?php
// Veritabanı bağlantı bilgileri
$host = 'localhost';
$dbname = 'linwood_roleplay';
$username = 'root';
$password = '';

try {
  // İlk olarak MySQL sunucusuna bağlan (veritabanı olmadan)
  $pdo = new PDO("mysql:host=$host", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Veritabanını oluştur (eğer yoksa)
  $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
  
  // Veritabanına bağlan
  $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
  
  // Hata modunu ayarla
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  // Varsayılan fetch modu
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  
} catch(PDOException $e) {
  // Bağlantı hatası durumunda
  die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
