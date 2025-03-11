<?php
$page_title = "Giriş Yap";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor

// Kullanıcı zaten giriş yapmışsa profile sayfasına yönlendir
if (is_logged_in()) {
  redirect('profile.php');
}

// Giriş formu işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF token kontrolü
  if (!check_csrf_token($_POST['csrf_token'])) {
    set_error('Güvenlik doğrulaması başarısız oldu! Lütfen sayfayı yenileyip tekrar deneyin.');
  } else {
    // Formdan gelen verileri temizle
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    
    // Zorunlu alanları doğrula
    $fields = ['username' => $username, 'password' => $password];
    $required_fields = ['username', 'password'];
    $errors = validate_form($fields, $required_fields);
    
    // Hata yoksa kullanıcıyı doğrula
    if (empty($errors)) {
      try {
        // Kullanıcı adına göre kullanıcıyı bul
        $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        // Kullanıcı bulunduysa şifreyi doğrula
        if ($user && password_verify($password, $user['password'])) {
          // Kullanıcının yönetici durumunu kontrol et
          $admin_check = $db->prepare("SELECT is_admin FROM users WHERE id = ?");
          $admin_check->execute([$user['id']]);
          $admin_result = $admin_check->fetch();
          
          // Giriş başarılı - oturum oluştur
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['is_admin'] = ($admin_result && $admin_result['is_admin'] == 1) ? true : false;
          
          // Son giriş zamanını güncelle
          $update_stmt = $db->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
          $update_stmt->execute([$user['id']]);
          
          set_success('Başarıyla giriş yaptınız!' . ($_SESSION['is_admin'] ? ' (Yönetici yetkisiyle)' : ''));
          redirect('profile.php');
        } else {
          // Giriş başarısız
          set_error('Kullanıcı adı veya şifre hatalı!');
        }
      } catch (PDOException $e) {
        set_error('Veritabanı hatası: ' . $e->getMessage());
      }
    } else {
      // Hata mesajlarını session'a kaydet
      set_error(implode('<br>', $errors));
    }
  }
}
?>

<section class="py-12 sm:py-16 fade-in-up">
  <div class="container mx-auto px-4 max-w-md">
    <div class="glass-card p-6 md:p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Giriş Yap</h1>
        <div class="flex justify-center">
          <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
            <i class="fas fa-sign-in-alt"></i>
          </div>
        </div>
        <p class="text-gray-300 mb-6">Hesabınıza giriş yaparak karakter başvurusunda bulunabilir ve profil bilgilerinizi yönetebilirsiniz.</p>
      </div>
      
      <form method="POST" action="login.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Kullanıcı Adı</label>
          <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Şifre</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <button type="submit" class="w-full py-2 px-4 btn btn-primary hover-glow font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
          Giriş Yap
        </button>
      </form>
    
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
