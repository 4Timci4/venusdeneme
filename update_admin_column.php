<?php
require_once 'db.php';

try {
  // Sütun var mı kontrol et ve eğer yoksa ekle
  $stmt = $db->prepare("
    SELECT COUNT(*) as column_exists 
    FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = ? 
    AND TABLE_NAME = 'users' 
    AND COLUMN_NAME = 'is_admin'
  ");
  $stmt->execute([$dbname]);
  $result = $stmt->fetch();
  
  if ($result['column_exists'] == 0) {
    // is_admin sütunu mevcut değil, ekleyelim
    $db->exec("ALTER TABLE users ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0");
    echo "is_admin sütunu users tablosuna başarıyla eklendi!";
  } else {
    echo "is_admin sütunu zaten mevcut.";
  }
  
  // Örnek bir yönetici atama (kullanıcı adını uygun bir değerle değiştirin)
  echo "<hr>";
  echo "<h3>Yönetici Atama</h3>";
  echo "<form method='post' action=''>";
  echo "<label>Yönetici yapılacak kullanıcı adı: </label>";
  echo "<input type='text' name='admin_username' required>";
  echo "<input type='submit' name='make_admin' value='Yönetici Yap'>";
  echo "</form>";
  
  if (isset($_POST['make_admin']) && !empty($_POST['admin_username'])) {
    $admin_username = $_POST['admin_username'];
    
    // Kullanıcı varlığını kontrol et
    $check_user = $db->prepare("SELECT id FROM users WHERE username = ?");
    $check_user->execute([$admin_username]);
    $user = $check_user->fetch();
    
    if ($user) {
      // Kullanıcıyı yönetici yap
      $update = $db->prepare("UPDATE users SET is_admin = 1 WHERE username = ?");
      $update->execute([$admin_username]);
      echo "<div style='color: green;'>{$admin_username} kullanıcısı yönetici yapıldı!</div>";
    } else {
      echo "<div style='color: red;'>'{$admin_username}' kullanıcısı bulunamadı!</div>";
    }
  }
  
} catch(PDOException $e) {
  die("Veritabanı güncellemesi sırasında hata oluştu: " . $e->getMessage());
}
?>

<style>
  body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
  hr { margin: 20px 0; }
  h3 { margin-bottom: 10px; }
  form { margin-bottom: 20px; }
  input[type="text"] { padding: 5px; margin-right: 10px; }
  input[type="submit"] { padding: 5px 10px; background: #4CAF50; color: white; border: none; cursor: pointer; }
</style>

<p><a href="login.php">Giriş sayfasına dön</a></p>
